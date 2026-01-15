<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessListing;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\BusinessContact;
use App\Models\BusinessHour;
use App\Models\BusinessSocialLink;
use App\Models\BusinessFeature;
use App\Models\BusinessService;
use App\Models\BusinessGallery;
use App\Models\BusinessVideoLink;

use App\Mail\ListingAdminCredentialsMail;


class AdminListingController extends Controller
{
    public function index(Request $request)
    {
        $adminId = auth()->id(); // ✅ since admin guard nahi hai

        $listings = BusinessListing::with(['categoryRel:id,name', 'cityRel:id,name'])
            ->where('user_id', $adminId) // ✅ user_id match
            ->latest()
            ->paginate(10);

        return view('admin.listing.index', compact('listings'));
    }

    // ✅ ADD LISTING PAGE (your 6-step design blade)
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $countries  = Country::orderBy('name')->get();
        $features   = Feature::orderBy('name')->get();

        return view('admin.listing.create', compact('categories', 'countries', 'features'));
    }

    // ✅ STORE (admin add karega to DB me save + pending)
    public function store(Request $request)
    {
        Log::info('Admin Listing Submit Data:', $request->all());

        // ✅ Accept both: (form fields) and (your JSON keys)
        $businessName = $request->input('business_name');
        $categoryId   = $request->input('category_id');

        // JSON: country_id/state_id/city_id | Form: country_id/state_id/city_id OR state/city
        $countryId = $request->input('country_id');
        $stateVal  = $request->input('state') ?? $request->input('state_id');
        $cityVal   = $request->input('city')  ?? $request->input('city_id');

        // JSON: full_address | Form: address
        $addressVal = $request->input('address') ?? $request->input('full_address');

        // JSON: business_description | Form: description
        $descVal = $request->input('description') ?? $request->input('business_description');

        // JSON: listing_option | Form: listing_type
        $listingType = $request->input('listing_type') ?? $request->input('listing_option') ?? 'free';

        $request->validate([
            'business_name' => 'required|string|max:255',
            'category_id'   => 'required',

            // admin form me logo required tha, lekin main store me nullable hai
            // aap required rakhna chahte ho to nullable hata do
            'business_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'business_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'email' => 'nullable|email',
        ]);

        return DB::transaction(function () use (
            $request,
            $businessName,
            $categoryId,
            $countryId,
            $stateVal,
            $cityVal,
            $addressVal,
            $descVal,
            $listingType
        ) {

            // ✅ slug unique
            $baseSlug = $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : Str::slug($businessName);

            $slug = $baseSlug;
            $i = 1;
            while (BusinessListing::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }

            // ✅ logo upload (admin form key: business_logo)
            $logoPath = null;
            if ($request->hasFile('business_logo')) {
                // aapki main store path style:
                $logoPath = $request->file('business_logo')->store('business/logo', 'public');
            }

            // ✅ create listing (same as MAIN)
            $listing = BusinessListing::create([
                'user_id'        => auth()->id(),   // ✅ admin user_id
                'business_name'  => $businessName,
                'category_id'    => $categoryId,
                'category'       => $request->input('category') ?? null,
                'slug'           => $slug,

                // IMPORTANT: yaha columns aapke BusinessListing table ke hisaab se hone chahiye
                // aapke MAIN store me: country/state/city/address
                'country'        => $countryId,
                'state'          => $stateVal,
                'city'           => $cityVal,
                'address'        => $addressVal,

                'latitude'       => $request->input('latitude'),
                'longitude'      => $request->input('longitude'),

                'description'    => $descVal,
                'logo'           => $logoPath,

                'listing_type'   => $listingType,
                'is_featured'    => (bool)($request->input('is_featured') ?? false),

                'status'         => 'pending',
                'submitted_at'   => now(),
            ]);

            // ✅ contact (same as MAIN)
            if ($request->filled('contact_name') || $request->filled('phone') || $request->filled('email')) {
                BusinessContact::create([
                    'business_id'     => $listing->id,
                    'contact_name'    => $request->input('contact_name'),
                    'phone'           => $request->input('phone'),
                    'email'           => $request->input('email'),
                    'alternate_phone' => $request->input('alternate_phone'),
                    'website'         => $request->input('website'),
                    'is_primary'      => true,
                ]);
            }

            // ✅ auto create admin user + send credentials (same as MAIN)
            $listingEmail = $request->input('email');
            if (!empty($listingEmail)) {
                $user = User::where('email', $listingEmail)->first();

                if (!$user) {
                    $plainPassword = Str::random(10);

                    $user = User::create([
                        'name'       => $request->input('contact_name') ?? $request->input('business_name') ?? 'Admin',
                        'email'      => $listingEmail,
                        'password'   => Hash::make($plainPassword),
                        'role'       => 'admin',
                        'is_blocked' => 0,
                    ]);

                    // mail send (optional: try/catch so transaction fail na ho)
                    Mail::to($listingEmail)->send(new ListingAdminCredentialsMail($user, $plainPassword));
                }
            }

            // ✅ business hours (same as MAIN)
            $hours = $request->input('hours', []);
            $daysOrder = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            foreach ($daysOrder as $day) {
                $d = $hours[$day] ?? null;
                $isClosed = empty($d) ? 1 : 0;

                BusinessHour::create([
                    'business_id' => $listing->id,
                    'day_of_week' => $day,
                    'is_closed'   => $isClosed,
                    'open_time'   => $d['start'] ?? null,
                    'close_time'  => $d['end'] ?? null,
                    'break_start' => $d['lunch_start'] ?? null,
                    'break_end'   => $d['lunch_end'] ?? null,
                ]);
            }

            // ✅ social links (same as MAIN)
            $platforms = $request->input('social_platform', []);
            $urls      = $request->input('social_url', []);

            if (is_array($platforms) && count($platforms)) {
                foreach ($platforms as $k => $p) {
                    $u = $urls[$k] ?? null;
                    if ($p && $u) {
                        BusinessSocialLink::create([
                            'business_id' => $listing->id,
                            'platform'    => $p,
                            'url'         => $u,
                        ]);
                    }
                }
            } else {
                $directSocial = [
                    'facebook'  => $request->input('facebook'),
                    'instagram' => $request->input('instagram'),
                    'youtube'   => $request->input('youtube'),
                    'twitter'   => $request->input('twitter'),
                    'linkedin'  => $request->input('linkedin'),
                    'snapchat'  => $request->input('snapchat'),
                ];

                foreach ($directSocial as $platform => $url) {
                    if (!empty($url)) {
                        BusinessSocialLink::create([
                            'business_id' => $listing->id,
                            'platform'    => $platform,
                            'url'         => $url,
                        ]);
                    }
                }
            }

            // ✅ FEATURES (CSV hidden inputs) (same as MAIN)
            $featuresStr   = $request->input('features');
            $featureIcons  = $request->input('feature_icons');
            $featureIdsStr = $request->input('feature_id');

            if (!empty($featuresStr)) {
                $names = array_values(array_filter(array_map('trim', explode(',', $featuresStr))));
                $icons = !empty($featureIcons) ? array_values(array_map('trim', explode(',', $featureIcons))) : [];
                $ids   = !empty($featureIdsStr) ? array_values(array_map('trim', explode(',', $featureIdsStr))) : [];

                foreach ($names as $i => $fname) {
                    BusinessFeature::create([
                        'business_id'  => $listing->id,
                        'feature_id'   => $ids[$i] ?? null,
                        'feature_name' => $fname,
                        'feature_icon' => $icons[$i] ?? null,
                    ]);
                }
            }

            // ✅ services (form arrays OR JSON) (same as MAIN)
            $sn = $request->input('service_name', []);
            if (is_array($sn) && count($sn)) {
                foreach ($sn as $k => $name) {
                    if (!$name) continue;

                    BusinessService::create([
                        'business_id'       => $listing->id,
                        'name'              => $name,
                        'description'       => $request->input("service_description.$k"),
                        'price'             => $request->input("service_price.$k"),
                        'currency'          => $request->input("service_currency.$k"),
                        'duration_minutes'  => $request->input("service_duration.$k"),
                        'is_popular'        => (bool)($request->input("service_popular.$k") ?? false),
                        'sort_order'        => $k,
                    ]);
                }
            } else {
                $services = $request->input('services', []);
                if (is_array($services)) {
                    foreach ($services as $k => $svc) {
                        if (!is_array($svc)) continue;
                        $name = $svc['name'] ?? null;
                        if (!$name) continue;

                        BusinessService::create([
                            'business_id'      => $listing->id,
                            'name'             => $name,
                            'description'      => $svc['description'] ?? null,
                            'price'            => $svc['price'] ?? null,
                            'currency'         => $svc['currency'] ?? null,
                            'duration_minutes' => $svc['duration'] ?? null,
                            'is_popular'       => (bool)($svc['popular'] ?? false),
                            'sort_order'       => $k,
                        ]);
                    }
                }
            }

            // ✅ gallery upload (same as MAIN)
            if ($request->hasFile('business_gallery')) {
                foreach ($request->file('business_gallery') as $index => $img) {
                    $path = $img->store('business/gallery', 'public');

                    BusinessGallery::create([
                        'business_id' => $listing->id,
                        'image_path'  => $path,
                        'caption'     => null,
                        'alt_text'    => null,
                        'is_cover'    => $index === 0,
                        'sort_order'  => $index,
                        'uploaded_at' => now(),
                    ]);
                }
            }

            // ✅ video link (same as MAIN)
            $videoUrl = $request->input('video_link_url') ?? $request->input('youtube_video');
            if (!empty($videoUrl) || $request->filled('embed_code')) {
                BusinessVideoLink::create([
                    'business_id'     => $listing->id,
                    'video_link_url'  => $videoUrl,
                    'embed_code'      => $request->input('embed_code'),
                    'provider'        => $request->input('provider'),
                ]);
            }

            return redirect()->route('admin.listing.index')
                ->with('success', 'Listing submitted successfully! (Pending approval)');
        });
    }


    public function edit(BusinessListing $listing)
    {
        // ✅ security: sirf apni listing edit kar sake
        abort_if($listing->user_id !== auth()->id(), 403);

        return view('admin.listing.edit', compact('listing'));
    }

    public function update(Request $request, BusinessListing $listing)
    {
        abort_if($listing->user_id !== auth()->id(), 403);

        $request->validate([
            'business_name' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);

        $listing->update($request->only('business_name', 'status'));

        return redirect()->route('admin.listing.index')->with('success', 'Listing updated successfully!');
    }
}
