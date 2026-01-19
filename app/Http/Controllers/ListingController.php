<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\Feature;
use App\Models\User; // ✅ add
use App\Mail\ListingAdminCredentialsMail; // ✅ add
use App\Models\BusinessListing;
use App\Models\BusinessContact;
use App\Models\BusinessSocialLink;
use App\Models\BusinessHour;
use App\Models\BusinessService;
use App\Models\BusinessFeature;
use App\Models\BusinessGallery;
use App\Models\BusinessVideoLink;
use Illuminate\Support\Facades\Hash; // ✅ add
use Illuminate\Support\Facades\Mail; // ✅ add
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;



class ListingController extends Controller
{





    public function show($slug)
    {
        $today = Carbon::today()->toDateString();

        $listing = BusinessListing::with([
            'hours',
            'gallery',
            'features.feature',
            'cityRel',
            'stateRel',
            'countryRel',
            'faqs.items',

            'announcements' => function ($q) use ($today) {
                $q->where('is_active', 1)
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->latest();
            },

            'events' => function ($q) use ($today) {
                $q->where('is_active', 1)
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->latest();
            },

            // ✅ ADD THIS (Coupons)
            'coupons' => function ($q) use ($today) {
                $q->where('is_active', 1)
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->latest();
            }

        ])->where('slug', $slug)->firstOrFail();

        return view('pages.listingdetail', compact('listing'));
    }

    public function create()
    {
        $countries  = Country::orderBy('name')->get();
        $features   = Feature::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('pages.addlisting', compact('countries', 'categories', 'features'));
    }

    public function getStates(Request $request)
    {
        return State::where('country_id', $request->country_id)->orderBy('name')->get();
    }

    public function getCities(Request $request)
    {
        return City::where('state_id', $request->state_id)->orderBy('name')->get();
    }

    public function store(Request $request)
    {
        Log::info('Form Submit Data:', $request->all());

        // ✅ Accept both: (form fields) and (your JSON keys)
        $businessName = $request->input('business_name');
        $categoryId   = $request->input('category_id');


        // JSON: country_id/state_id/city_id | Form: country_id/state/city (tumhare code me)
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
            'agree_terms'   => 'accepted',
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
            $listingType,
        ) {

            // ✅ slug
            $baseSlug = $request->filled('slug')
                ? Str::slug($request->input('slug'))
                : Str::slug($businessName);

            $slug = $baseSlug;
            $i = 1;
            while (BusinessListing::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }

            // ✅ logo upload
            $logoPath = null;
            if ($request->hasFile('business_logo')) {
                $logoPath = $request->file('business_logo')->store('business/logo', 'public');
            }

            // ✅ create listing
            $listing = BusinessListing::create([
                'user_id'        => auth()->id(),
                'business_name' => $businessName,
                'category_id'   => $categoryId,
                'category'      => $request->input('category') ?? null,
                'slug'          => $slug,

                'country'       => $countryId,
                'state'         => $stateVal,
                'city'          => $cityVal,
                'address'       => $addressVal,

                'latitude'      => $request->input('latitude'),
                'longitude'     => $request->input('longitude'),

                'description'   => $descVal,
                'logo'          => $logoPath,

                'listing_type'  => $listingType,
                'is_featured'   => (bool)($request->input('is_featured') ?? false),

                'status'        => 'pending',
                'submitted_at'  => now(),
            ]);

            // ✅ contact (JSON uses: contact_name, phone, email, alternate_phone, website)
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

            $listingEmail = $request->email; // aapka email input name="email"

            $user = User::where('email', $listingEmail)->first();

            if (!$user) {
                $plainPassword = Str::random(10);

                $user = User::create([
                    'name' => $request->contact_name ?? $request->business_name ?? 'Admin',
                    'email' => $listingEmail,
                    'password' => Hash::make($plainPassword),
                    'role' => 'admin',
                    'is_blocked' => 0,
                ]);

                // mail send
                Mail::to($listingEmail)->send(new ListingAdminCredentialsMail($user, $plainPassword));
            }



            // ✅ business hours save
            $hours = $request->input('hours', []);

            $daysOrder = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            foreach ($daysOrder as $day) {
                $d = $hours[$day] ?? [];

                // day closed agar start/end hi nahi
                $isClosed = empty($d['start']) || empty($d['end']) ? 1 : 0;

                BusinessHour::create([
                    'business_id' => $listing->id,
                    'day_of_week' => $day,
                    'is_closed'   => $isClosed,

                    // open/close
                    'open_time'   => $d['start'] ?? null,
                    'close_time'  => $d['end'] ?? null,

                    // lunch/break (agar user ne dala ho)
                    'break_start' => $d['lunch_start'] ?? null,
                    'break_end'   => $d['lunch_end'] ?? null,
                ]);
            }




            // ✅ social links:
            // Handle BOTH:
            // 1) Form arrays: social_platform[] + social_url[]
            // 2) JSON direct fields: facebook, instagram, youtube, twitter, linkedin, snapchat
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

            // ✅ FEATURES (save only once) — CSV from hidden inputs
            $featuresStr   = $request->input('features');       // "Halwa,hfgfghf,parking"
            $featureIcons  = $request->input('feature_icons');  // "flaticon-chef,flaticon-government,..."
            $featureIdsStr = $request->input('feature_id');     // "6,4,5"

            if (!empty($featuresStr)) {
                $names = array_values(array_filter(array_map('trim', explode(',', $featuresStr))));
                $icons = !empty($featureIcons)
                    ? array_values(array_map('trim', explode(',', $featureIcons)))
                    : [];
                $ids   = !empty($featureIdsStr)
                    ? array_values(array_map('trim', explode(',', $featureIdsStr)))
                    : [];

                foreach ($names as $i => $fname) {
                    BusinessFeature::create([
                        'business_id'  => $listing->id,
                        'feature_id'   => $ids[$i] ?? null,
                        'feature_name' => $fname,
                        'feature_icon' => $icons[$i] ?? null,
                    ]);
                }
            }



            // ✅ services:
            // Handle BOTH:
            // 1) Form arrays: service_name[]
            // 2) JSON: services: [{name,price,duration}]
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


            // ✅ gallery upload (multiple)
            if ($request->hasFile('business_gallery')) {

                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

                foreach ($request->file('business_gallery') as $index => $img) {

                    $image = $manager->read($img->getPathname());

                    // ✅ resize (max width 1200px)
                    $image->scaleDown(width: 1200);

                    $filename = uniqid('gallery_') . '.jpg';
                    $path = 'business/gallery/' . $filename;   // ✅ same folder

                    // ✅ compress until <= 500 KB
                    $quality = 85;
                    do {
                        $encoded = $image->toJpeg($quality);
                        $quality -= 5;
                    } while (strlen((string)$encoded) > (500 * 1024) && $quality > 30);

                    \Storage::disk('public')->put($path, (string)$encoded);

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


            // ✅ video link (handle your JSON key also)
            // JSON: youtube_video, Form: video_link_url/embed_code
            $videoUrl = $request->input('video_link_url') ?? $request->input('youtube_video');

            if (!empty($videoUrl) || $request->filled('embed_code')) {
                BusinessVideoLink::create([
                    'business_id'     => $listing->id,
                    'video_link_url'  => $videoUrl,
                    'embed_code'      => $request->input('embed_code'),
                    'provider'        => $request->input('provider'),
                ]);
            }

            return back()->with('success', 'Your listing submitted successfully! (Pending approval)');
        });
    }
}
