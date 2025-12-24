<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Category;
use App\Models\Feature;

use App\Models\BusinessListing;
use App\Models\BusinessContact;
use App\Models\BusinessSocialLink;
use App\Models\BusinessHour;
use App\Models\BusinessService;
use App\Models\BusinessFeature;
use App\Models\BusinessGallery;
use App\Models\BusinessVideoLink;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ListingController extends Controller
{
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
            'business_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'business_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
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

            // ✅ business hours:
            // Handle BOTH:
            // 1) Form arrays: day_of_week[] open_time[] close_time[] break_start[] break_end[]
            // 2) JSON object: hours[monday][start,end,lunch_start,lunch_end]
            $days = $request->input('day_of_week', []);
            if (is_array($days) && count($days)) {
                foreach ($days as $k => $day) {
                    if (!$day) continue;

                    BusinessHour::create([
                        'business_id' => $listing->id,
                        'day_of_week' => $day,
                        'is_closed'   => (bool)($request->input("is_closed.$k") ?? false),
                        'open_time'   => $request->input("open_time.$k"),
                        'close_time'  => $request->input("close_time.$k"),
                        'break_start' => $request->input("break_start.$k"),
                        'break_end'   => $request->input("break_end.$k"),
                    ]);
                }
            } else {
                $hours = $request->input('hours', []);
                if (is_array($hours)) {
                    foreach ($hours as $day => $info) {
                        if (!is_array($info)) continue;

                        $open  = $info['start'] ?? null;
                        $close = $info['end'] ?? null;

                        // If no open/close, skip (or you can mark closed)
                        if (!$open && !$close) continue;

                        BusinessHour::create([
                            'business_id' => $listing->id,
                            'day_of_week' => $day,
                            'is_closed'   => false,
                            'open_time'   => $open,
                            'close_time'  => $close,
                            'break_start' => $info['lunch_start'] ?? null,
                            'break_end'   => $info['lunch_end'] ?? null,
                        ]);
                    }
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

            // ✅ features:
            // Handle BOTH:
            // 1) Form arrays: feature_id[] + feature_name[]
            // 2) JSON: "features": "hfgfghf,parking"
            $fids   = $request->input('feature_id', []);
            $fnames = $request->input('feature_name', []);

            if (is_array($fids) && count($fids)) {
                foreach ($fids as $k => $fid) {
                    $fname = $fnames[$k] ?? null;
                    if ($fid || $fname) {
                        BusinessFeature::create([
                            'business_id'   => $listing->id,
                            'feature_id'    => $fid,
                            'feature_name'  => $fname,
                        ]);
                    }
                }
            } else {
                $featuresStr = $request->input('features'); // "hfgfghf,parking"
                if (!empty($featuresStr)) {
                    $parts = array_filter(array_map('trim', explode(',', $featuresStr)));
                    foreach ($parts as $fname) {
                        BusinessFeature::create([
                            'business_id'  => $listing->id,
                            'feature_id'   => null,
                            'feature_name' => $fname,
                        ]);
                    }
                }
            }

            // ✅ gallery upload (multiple)
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

            return back()
                ->with('success', 'Listing submitted successfully! (Pending approval)');
        });
    }
}
