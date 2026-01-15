@extends('layouts.admin')

@section('title', 'Home Page')

@section('content')





<section class="main-top-progress-bar sticky-progess-bar">
    <div class="top-progress-bar">
        <div class="container">
            <div class="progess-area-list ">
                <div class="progess-box active">
                    <div class="step-circle">1</div>
                    <span class="step-label">Basic Info</span>
                </div>
                <hr>
                <div class="progess-box">
                    <div class="step-circle">2</div>
                    <span class="step-label">Contact Info</span>
                </div>
                <hr>
                <div class="progess-box">
                    <div class="step-circle">3</div>
                    <span class="step-label">Hours</span>
                </div>
                <hr>
                <div class="progess-box">
                    <div class="step-circle">4</div>
                    <span class="step-label">Services</span>
                </div>
                <hr>
                <div class="progess-box">
                    <div class="step-circle">5</div>
                    <span class="step-label">Media</span>
                </div>
                <hr>
                <div class="progess-box">
                    <div class="step-circle">6</div>
                    <span class="step-label">Review</span>
                </div>
            </div>
        </div>
    </div>

    <div class="step-area">
        <div class="container">

            <form action="{{ route('admin.listing.update', $listing->id) }}" method="POST" enctype="multipart/form-data" class="row">
                @csrf
                @method('PUT')

                @php
                $primaryContact = $listing->contacts->first();

                // ✅ videos() relation
                $video = $listing->videos->first();

                // ✅ socialLinks() relation
                $social = $listing->socialLinks->keyBy('platform');

                // ✅ hours()
                $hoursMap = $listing->hours->keyBy('day_of_week');

                // ✅ services()
                $services = $listing->services ?? collect();

                // ✅ features() -> BusinessFeature rows
                $bizFeatures = $listing->features ?? collect();

                $featureIdsCsv = $bizFeatures->pluck('feature_id')->filter()->implode(',');
                $featureNamesCsv = $bizFeatures->pluck('feature_name')->filter()->implode(',');
                $featureIconsCsv = $bizFeatures->pluck('feature_icon')->filter()->implode(',');
                @endphp



                {{-- ===================== STEP 1 ===================== --}}
                <div class="form-step active" data-step="1">
                    <div class="row">
                        <h2>Basic Information</h2>
                        <div class="col-lg-7">
                            <div class="form-step-inner">

                                <div class="form-grid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_name" class="form-label">Business Name <span class="required">*</span></label>
                                                <input type="text" id="business_name" name="business_name"
                                                    value="{{ old('business_name', $listing->business_name) }}"
                                                    placeholder="Enter your business name">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Category <span class="required">*</span></label>

                                                <div class="custom-select" data-select id="categorySelect">
                                                    <button type="button" class="select-trigger" data-trigger>
                                                        <span class="select-placeholder" data-label>Select a category</span>
                                                        <span class="select-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m6 9 6 6 6-6" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="select-panel" data-panel>
                                                        <div class="select-search">
                                                            <input type="text" placeholder="Search..." data-search />
                                                        </div>

                                                        <ul class="select-options" data-options id="categoryOptions">
                                                            @foreach($categories as $cat)
                                                            <li class="select-option"
                                                                data-id="{{ $cat->id }}"
                                                                data-value="{{ $cat->id }}">
                                                                {{ $cat->name }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    {{-- ✅ Prefill hidden --}}
                                                    <input type="hidden" name="category_id" data-hidden
                                                        value="{{ old('category_id', $listing->category_id) }}" />
                                                </div>

                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        {{-- COUNTRY --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Country <span class="required">*</span></label>
                                                <div class="custom-select" data-select id="countrySelect">
                                                    <button type="button" class="select-trigger" data-trigger>
                                                        <span class="select-placeholder" data-label>Select your country</span>
                                                        <span class="select-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m6 9 6 6 6-6" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="select-panel" data-panel>
                                                        <div class="select-search">
                                                            <input type="text" placeholder="Search..." data-search />
                                                        </div>

                                                        <ul class="select-options" data-options>
                                                            @foreach($countries as $country)
                                                            <li class="select-option"
                                                                data-id="{{ $country->id }}">
                                                                {{ $country->name }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    <input type="hidden" name="country_id" data-hidden
                                                        value="{{ old('country_id', $listing->country) }}" />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- STATE --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">State <span class="required">*</span></label>
                                                <div class="custom-select" data-select id="stateSelect">
                                                    <button type="button" class="select-trigger" data-trigger>
                                                        <span class="select-placeholder" data-label>Select your state</span>
                                                        <span class="select-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m6 9 6 6 6-6" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="select-panel" data-panel>
                                                        <div class="select-search">
                                                            <input type="text" placeholder="Search..." data-search />
                                                        </div>

                                                        <ul class="select-options" data-options id="stateOptions"></ul>
                                                    </div>

                                                    <input type="hidden" name="state_id" data-hidden
                                                        value="{{ old('state_id', $listing->state) }}" />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- CITY --}}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">City <span class="required">*</span></label>
                                                <div class="custom-select" data-select id="citySelect">
                                                    <button type="button" class="select-trigger" data-trigger>
                                                        <span class="select-placeholder" data-label>Select your city</span>
                                                        <span class="select-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="m6 9 6 6 6-6" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <div class="select-panel" data-panel>
                                                        <div class="select-search">
                                                            <input type="text" placeholder="Search..." data-search />
                                                        </div>

                                                        <ul class="select-options" data-options id="cityOptions"></ul>
                                                    </div>

                                                    <input type="hidden" name="city_id" data-hidden
                                                        value="{{ old('city_id', $listing->city) }}" />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Address --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="full_address" class="form-label">
                                                    Full Address <span class="required">*</span>
                                                </label>
                                                <textarea id="full_address" name="full_address"
                                                    class="form-control textarea-field"
                                                    placeholder="Enter full business address"
                                                    rows="3">{{ old('full_address', $listing->address) }}</textarea>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="business_description" class="form-label">
                                                    Business Description <span class="required">*</span>
                                                </label>
                                                <textarea id="business_description" name="business_description"
                                                    class="form-control textarea-field"
                                                    placeholder="Describe your business, services, and specialties"
                                                    rows="4">{{ old('business_description', $listing->description) }}</textarea>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- LOGO --}}
                        <div class="col-lg-5">
                            <div class="bussiness-logo">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="business_logo" class="form-label">Business Logo <span class="required">*</span></label>
                                            <div class="category-img-upload" id="business_logo">
                                                <div class="upload-area">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload">
                                                        <path d="M12 13v8" />
                                                        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                                                        <path d="m8 17 4-4 4 4" />
                                                    </svg>
                                                    <p class="upload-text">Drop logo here or click</p>
                                                </div>
                                                <input type="file" id="logoFile" name="business_logo" accept="image/*" hidden="">
                                            </div>
                                            <div class="error-message"></div>
                                        </div>

                                        <div class="logo-preview" id="logoPreview" style="display:none;">
                                            <img id="logoImage" src="" alt="Logo">
                                            <button type="button" class="remove-btn" id="removeLogo">Remove</button>
                                        </div>

                                        {{-- ✅ existing logo path for JS --}}
                                        <input type="hidden" id="existingLogoPath" value="{{ $listing->logo ? asset('storage/'.$listing->logo) : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ===================== STEP 2 ===================== --}}
                <div class="form-step" data-step="2">
                    <div class="row">
                        <h2>Contact Information</h2>
                        <div class="col-lg-12">
                            <div class="form-step-inner">
                                <div class="form-grid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="contact_name">Your Name <span class="required">*</span></label>
                                                <input type="text" id="contact_name" name="contact_name"
                                                    value="{{ old('contact_name', $primaryContact->contact_name ?? '') }}"
                                                    placeholder="John Doe">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="phone">Phone <span class="required">*</span></label>
                                                <input type="tel" id="phone" name="phone"
                                                    value="{{ old('phone', $primaryContact->phone ?? '') }}"
                                                    placeholder="(555) 123-4567">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="email">Email <span class="required">*</span></label>
                                                <input type="email" id="email" name="email"
                                                    value="{{ old('email', $primaryContact->email ?? '') }}"
                                                    placeholder="business@example.com">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="website">Website</label>
                                                <input type="url" id="website" name="website"
                                                    value="{{ old('website', $primaryContact->website ?? '') }}"
                                                    placeholder="https://yoursite.com">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label" for="alternate">Alternate Phone</label>
                                                <input type="tel" id="alternate" name="alternate_phone"
                                                    value="{{ old('alternate_phone', $primaryContact->alternate_phone ?? '') }}"
                                                    placeholder="(555) 987-6543">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social --}}
                    <div class="row">
                        <h2>Social Media Links</h2>
                        <div class="col-lg-12">
                            <div class="form-step-inner">
                                <div class="form-grid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="facebook" class="form-label">Facebook</label>
                                                <input type="url" id="facebook" name="facebook"
                                                    value="{{ old('facebook', $social['facebook']->url ?? '') }}"
                                                    placeholder="https://facebook.com/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="instagram" class="form-label">Instagram</label>
                                                <input type="url" id="instagram" name="instagram"
                                                    value="{{ old('instagram', $social['instagram']->url ?? '') }}"
                                                    placeholder="https://instagram.com/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="youtube" class="form-label">Youtube</label>
                                                <input type="url" id="youtube" name="youtube"
                                                    value="{{ old('youtube', $social['youtube']->url ?? '') }}"
                                                    placeholder="https://youtube.com/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="twitter" class="form-label">Twitter</label>
                                                <input type="url" id="twitter" name="twitter"
                                                    value="{{ old('twitter', $social['twitter']->url ?? '') }}"
                                                    placeholder="https://twitter.com/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="linkedin" class="form-label">LinkedIn</label>
                                                <input type="url" id="linkedin" name="linkedin"
                                                    value="{{ old('linkedin', $social['linkedin']->url ?? '') }}"
                                                    placeholder="https://linkedin.com/company/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="snapchat" class="form-label">Snapchat</label>
                                                <input type="url" id="snapchat" name="snapchat"
                                                    value="{{ old('snapchat', $social['snapchat']->url ?? '') }}"
                                                    placeholder="https://snapchat.com/yourbusiness">
                                                <div class="error-message"></div>
                                            </div>
                                        </div>
                                    </div> {{-- row --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ===================== STEP 3 (HOURS) ===================== --}}
                <div class="form-step" data-step="3">
                    <div class="row">
                        <h2>Add working hours</h2>

                        <div class="col-lg-12">
                            <div class="working-hours-card">
                                @php
                                $daysLabel = [
                                'monday' => 'Monday',
                                'tuesday' => 'Tuesday',
                                'wednesday' => 'Wednesday',
                                'thursday' => 'Thursday',
                                'friday' => 'Friday',
                                'saturday' => 'Saturday',
                                'sunday' => 'Sunday',
                                ];
                                @endphp

                                @foreach($daysLabel as $dayKey => $dayTitle)
                                @php
                                $h = $hoursMap[$dayKey] ?? null;
                                $isClosed = $h ? (int)$h->is_closed : 1; // if not exist => closed
                                @endphp

                                <div class="day-row {{ $isClosed ? 'is-closed' : '' }}" data-day="{{ $dayKey }}">
                                    <label class="switch">
                                        <input type="checkbox" class="day-toggle" {{ $isClosed ? '' : 'checked' }}>
                                        <span class="slider"></span>
                                    </label>

                                    <div class="day-name">{{ $dayTitle }}</div>

                                    <div class="time-wrap">
                                        <div class="time-box">
                                            <input type="time" name="hours[{{ $dayKey }}][start]"
                                                value="{{ old("hours.$dayKey.start", $h->open_time ?? '') }}">
                                        </div>

                                        <div class="to-text">to</div>

                                        <div class="time-box">
                                            <input type="time" name="hours[{{ $dayKey }}][end]"
                                                value="{{ old("hours.$dayKey.end", $h->close_time ?? '') }}">
                                        </div>

                                        <span class="lunch-label">Lunch</span>

                                        <div class="time-box">
                                            <input type="time" name="hours[{{ $dayKey }}][lunch_start]"
                                                value="{{ old("hours.$dayKey.lunch_start", $h->break_start ?? '') }}">
                                        </div>

                                        <div class="to-text">to</div>

                                        <div class="time-box">
                                            <input type="time" name="hours[{{ $dayKey }}][lunch_end]"
                                                value="{{ old("hours.$dayKey.lunch_end", $h->break_end ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="closed-text {{ $isClosed ? '' : 'd-none' }}">Closed</div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>


                {{-- ===================== STEP 4 (SERVICES + FEATURES) ===================== --}}
                <div class="form-step" data-step="4">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2>Services Offered</h2>

                            <div id="servicesWrap" class="so-wrap">
                                @forelse($services as $i => $srv)
                                <div class="service-card service-row">
                                    <div class="service-grid">
                                        <div class="fg">
                                            <label>Service Name</label>
                                            <input type="text" name="services[{{ $i }}][name]"
                                                value="{{ old("services.$i.name", $srv->name) }}"
                                                placeholder="e.g., Haircut">
                                        </div>
                                        <div class="fg">
                                            <label>Price</label>
                                            <input type="text" name="services[{{ $i }}][price]"
                                                value="{{ old("services.$i.price", $srv->price) }}"
                                                placeholder="e.g., $25">
                                        </div>
                                        <div class="fg">
                                            <label>Duration (mins)</label>
                                            <input type="number" name="services[{{ $i }}][duration]"
                                                value="{{ old("services.$i.duration", $srv->duration_minutes) }}"
                                                min="0">
                                        </div>

                                        <button type="button" class="delete-service" title="Remove">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @empty
                                {{-- fallback 1 blank row --}}
                                <div class="service-card service-row">
                                    <div class="service-grid">
                                        <div class="fg">
                                            <label>Service Name</label>
                                            <input type="text" name="services[0][name]" placeholder="e.g., Haircut">
                                        </div>
                                        <div class="fg">
                                            <label>Price</label>
                                            <input type="text" name="services[0][price]" placeholder="e.g., $25">
                                        </div>
                                        <div class="fg">
                                            <label>Duration (mins)</label>
                                            <input type="number" name="services[0][duration]" value="30" min="0">
                                        </div>

                                        <button type="button" class="delete-service" title="Remove">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforelse
                            </div>

                            <button type="button" id="addServiceBtn" class="add-service-btn">
                                <span class="plus">＋</span> Add Service
                            </button>
                        </div>

                        <div class="col-lg-4">
                            <h2>Features</h2>

                            <div class="features-card">
                                <div class="features-grid" id="featuresGrid">
                                    @foreach($features as $f)
                                    <button type="button"
                                        class="feature-tile"
                                        data-id="{{ $f->id }}"
                                        data-name="{{ $f->name }}"
                                        data-icon="{{ $f->icon }}">
                                        <span class="ft-icon">
                                            @if(!empty($f->icon))
                                            <i class="{{ $f->icon }}"></i>
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 8v8M8 12h8"></path>
                                            </svg>
                                            @endif
                                        </span>
                                        <span class="ft-text">{{ $f->name }}</span>
                                    </button>
                                    @endforeach
                                </div>

                                <div class="features-divider"></div>

                                <div class="selected-head">
                                    <div class="selected-title">SELECTED (<span id="selectedCount">0</span>)</div>
                                </div>

                                <div class="selected-chips" id="selectedChips"></div>

                                <div id="featuresHiddenWrap"></div>

                                {{-- ✅ Prefill CSV for edit --}}
                                <input type="hidden" id="featureIDHidden" name="feature_id" value="{{ old('feature_id', $featureIdsCsv) }}">
                                <input type="hidden" id="featuresHidden" name="features" value="{{ old('features', $featureNamesCsv) }}">
                                <input type="hidden" id="featureIconsHidden" name="feature_icons" value="{{ old('feature_icons', $featureIconsCsv) }}">
                            </div>
                        </div>

                    </div>
                </div>


                {{-- ===================== STEP 5 (MEDIA) ===================== --}}
                <div class="form-step" data-step="5">
                    <h2 class="step-title">Media</h2>

                    <div class="row g-4">
                        {{-- Gallery Upload --}}
                        <div class="col-lg-6">
                            <div class="media-card">
                                <div class="media-card-head">
                                    <div class="media-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                                            <circle cx="9" cy="9" r="2"></circle>
                                            <path d="M21 15l-5-5L5 21"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="media-title">Business Gallery</div>
                                        <div class="media-subtitle">Professional Photos</div>
                                    </div>
                                </div>

                                <label class="upload-box" for="business_gallery">
                                    <div class="upload-inner">
                                        <div class="upload-circle">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 3v12"></path>
                                                <path d="M7 8l5-5 5 5"></path>
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            </svg>
                                        </div>

                                        <div class="upload-title">Upload Your Photos</div>
                                        <div class="upload-hint">Drag and drop multiple images or click to browse</div>
                                        <div class="upload-meta">PNG, JPG up to 10MB each (max 20 images)</div>

                                        <div class="upload-btn">Choose Images</div>
                                    </div>

                                    <input id="business_gallery" name="business_gallery[]" type="file" accept="image/*" multiple hidden />
                                </label>
                            </div>
                        </div>

                        {{-- Youtube --}}
                        <div class="col-lg-6">
                            <div class="media-card">
                                <div class="media-card-head">
                                    <div class="media-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="5" width="18" height="14" rx="3"></rect>
                                            <path d="M10 9l6 3-6 3V9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="media-title">YouTube Video</div>
                                        <div class="media-subtitle">Promotional Content</div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Video Link / Embed Code</label>
                                    <input type="text"
                                        name="youtube_video"
                                        id="youtube_video"
                                        value="{{ old('youtube_video', $video->video_link_url ?? '') }}">

                                </div>

                                <div class="video-preview-wrap">
                                    <div class="video-preview-title">VIDEO PREVIEW</div>

                                    <div class="video-preview" id="videoPreviewEmpty">
                                        <div class="video-preview-icon">
                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M8 5v14l11-7L8 5z"></path>
                                            </svg>
                                        </div>
                                        <div class="video-preview-text">Video preview will appear here</div>
                                    </div>

                                    <div class="ratio ratio-16x9 d-none" id="videoPreviewFrame"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery Preview --}}
                        <div class="col-12">
                            <div class="media-card">
                                <div class="gallery-head">
                                    <div>
                                        <div class="media-title">Gallery Preview</div>
                                        <div class="media-subtitle" id="galleryCountText">
                                            {{ ($listing->gallery?->count() ?? 0) }} photos ready to showcase
                                        </div>
                                    </div>
                                </div>

                                <div class="gallery-strip thumb-row" id="galleryPreview">
                                    {{-- ✅ Existing gallery thumbnails --}}
                                    @foreach($listing->gallery as $img)
                                    <div class="thumb">
                                        <img src="{{ asset('storage/'.$img->image_path) }}" alt="">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- ===================== STEP 6 ===================== --}}
                <div class="form-step" data-step="6">
                    <h2>Review</h2>

                    {{-- Your review UI kept as-is (no change) --}}
                    {{-- ... your same review HTML ... --}}
                    {{-- (Keeping it as you pasted) --}}

                    <div class="terms-box mt-3">
                        <label class="d-flex align-items-start gap-2 m-0">
                            <input type="checkbox" name="agree_terms" id="agree_terms" class="mt-1">
                            <span class="terms-text">
                                I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a>.
                                I confirm that all information provided is accurate and up to date.
                            </span>
                        </label>
                    </div>
                </div>


                {{-- FOOTER --}}
                <div class="wizard-footer">
                    <button type="button" class="btn-prev" id="btnPrev">Previous</button>

                    <div class="wizard-center">
                        <span id="stepIndicator">Step 1 of 6</span>
                    </div>

                    <button type="button" class="btn next-btn" id="nextBtn">Next</button>

                    <button type="submit" class="btn submit-btn" id="submitBtn" style="display:none;">
                        Submit Listing
                    </button>
                </div>

            </form>

        </div>
    </div>

</section>



<!-- dropdown js category, , country, state, city js -->


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const allSelects = document.querySelectorAll('[data-select]');

        // ========= Category (static) =========
        const categorySelect = document.getElementById('categorySelect');
        const categoryOptions = document.getElementById('categoryOptions');

        if (categorySelect && categoryOptions) {
            categoryOptions.addEventListener('click', (e) => {
                const opt = e.target.closest('.select-option');
                if (!opt) return;

                const categoryId = opt.dataset.id || opt.dataset.value;
                setSelectValue(categorySelect, opt.textContent.trim(), categoryId);
            });
        }


        function closeAll(except = null) {
            allSelects.forEach(s => {
                if (s !== except) s.classList.remove('is-open');
            });
        }

        // ONLY ONE outside click => close
        document.addEventListener('click', () => closeAll());

        // stop close when clicking inside dropdown (panel/search/options)
        allSelects.forEach(sel => {
            sel.addEventListener('click', (e) => e.stopPropagation());
        });

        function openSelect(select) {
            const isOpen = select.classList.contains('is-open');
            closeAll(select);
            select.classList.toggle('is-open', !isOpen);

            // focus search on open
            if (!isOpen) {
                const search = select.querySelector('[data-search]');
                const options = select.querySelectorAll('.select-option');
                if (search) {
                    search.value = '';
                    options.forEach(li => li.classList.remove('is-hidden'));
                    setTimeout(() => search.focus(), 50);
                }
            }
        }

        function setSelectValue(select, text, value) {
            const label = select.querySelector('[data-label]');
            const hidden = select.querySelector('[data-hidden]');
            if (label) {
                label.textContent = text;
            }
            if (hidden) hidden.value = value;
            select.classList.remove('is-open');
        }

        // Trigger click => open/close
        document.querySelectorAll('[data-trigger]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const select = btn.closest('[data-select]');
                if (!select || select.classList.contains('is-disabled')) return;
                openSelect(select);
            });
        });

        // Search filter (per dropdown)
        allSelects.forEach(select => {
            const search = select.querySelector('[data-search]');
            if (!search) return;

            search.addEventListener('click', (e) => e.stopPropagation()); // MAIN FIX
            search.addEventListener('input', () => {
                const q = search.value.toLowerCase().trim();
                select.querySelectorAll('.select-option').forEach(li => {
                    const txt = li.textContent.toLowerCase();
                    li.classList.toggle('is-hidden', q && !txt.includes(q));
                });
            });
        });

        // ========= Country -> State -> City =========
        const countrySelect = document.getElementById('countrySelect');
        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');

        const stateOptions = document.getElementById('stateOptions');
        const cityOptions = document.getElementById('cityOptions');

        function disableSelect(select, placeholderText) {
            select.classList.add('is-disabled');
            setSelectValue(select, placeholderText, '');
            const optionsWrap = select.querySelector('[data-options]');
            if (optionsWrap) optionsWrap.innerHTML = '';
        }

        function enableSelect(select) {
            select.classList.remove('is-disabled');
        }

        // Start: state & city disabled
        disableSelect(stateSelect, 'Select your state');
        disableSelect(citySelect, 'Select your city');

        // COUNTRY option click (static list)
        countrySelect.querySelectorAll('.select-option').forEach(opt => {
            opt.addEventListener('click', async () => {
                const countryId = opt.dataset.id;
                setSelectValue(countrySelect, opt.textContent.trim(), countryId);

                // reset & disable city, enable state after load
                disableSelect(stateSelect, 'Loading states...');
                disableSelect(citySelect, 'Select your city');

                try {
                    const res = await fetch("{{ route('get.states') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            country_id: countryId
                        })
                    });

                    const states = await res.json();

                    let html = '';
                    states.forEach(st => {
                        html += `<li class="select-option" data-id="${st.id}" data-value="${st.id}">${st.name}</li>`;
                    });
                    stateOptions.innerHTML = html;

                    enableSelect(stateSelect);
                    setSelectValue(stateSelect, 'Select your state', '');
                    stateSelect.classList.remove('is-open');

                } catch (err) {
                    disableSelect(stateSelect, 'Select your state');
                    console.error(err);
                }
            });
        });

        // STATE option click (dynamic => event delegation)
        stateOptions.addEventListener('click', async (e) => {
            const opt = e.target.closest('.select-option');
            if (!opt) return;

            const stateId = opt.dataset.id;
            setSelectValue(stateSelect, opt.textContent.trim(), stateId);

            disableSelect(citySelect, 'Loading cities...');

            try {
                const res = await fetch("{{ route('get.cities') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        state_id: stateId
                    })
                });

                const cities = await res.json();

                let html = '';
                cities.forEach(ct => {
                    html += `<li class="select-option" data-id="${ct.id}" data-value="${ct.id}">${ct.name}</li>`;
                });
                cityOptions.innerHTML = html;

                enableSelect(citySelect);
                setSelectValue(citySelect, 'Select your city', '');
                citySelect.classList.remove('is-open');

            } catch (err) {
                disableSelect(citySelect, 'Select your city');
                console.error(err);
            }
        });

        // CITY option click (dynamic)
        cityOptions.addEventListener('click', (e) => {
            const opt = e.target.closest('.select-option');
            if (!opt) return;

            const cityId = opt.dataset.id;
            setSelectValue(citySelect, opt.textContent.trim(), cityId);
        });

    });
</script>



<!-- logo select box for  -->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const uploadBox = document.getElementById('business_logo');
        const logoFile = document.getElementById('logoFile');
        const logoPreview = document.getElementById('logoPreview');
        const logoImage = document.getElementById('logoImage');
        const removeLogo = document.getElementById('removeLogo');

        if (uploadBox && logoFile) {

            // Click on upload area => open file picker
            uploadBox.addEventListener('click', () => {
                logoFile.click();
            });

            // When file selected => show preview
            logoFile.addEventListener('change', () => {
                const file = logoFile.files && logoFile.files[0];
                if (!file) return;

                // only image check (optional)
                if (!file.type.startsWith('image/')) {
                    logoFile.value = '';
                    return;
                }

                const url = URL.createObjectURL(file);
                logoImage.src = url;
                logoPreview.style.display = 'block';
            });

            // Remove
            if (removeLogo) {
                removeLogo.addEventListener('click', () => {
                    logoFile.value = '';
                    logoImage.src = '';
                    logoPreview.style.display = 'none';
                });
            }
        }

    });
</script>


<!-- form previous btn, next btn, and top form progress bar js -->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const formSteps = Array.from(document.querySelectorAll('.form-step'));
        const progressBoxes = Array.from(document.querySelectorAll('.progess-area-list .progess-box'));
        const totalSteps = Math.max(formSteps.length, progressBoxes.length) || 6;

        // ✅ IDs matched with your HTML
        const prevBtn = document.getElementById('btnPrev'); // was prevBtn
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        // ✅ Your indicator: "Step 1 of 6"
        const stepIndicator = document.getElementById('stepIndicator');

        const tickSVG = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
              viewBox="0 0 24 24" fill="none" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-check-icon lucide-check">
              <path d="M20 6 9 17l-5-5"/>
            </svg>
        `;

        // number labels store
        progressBoxes.forEach((box, idx) => {
            const circle = box.querySelector('.step-circle');
            if (circle) circle.dataset.stepNumber = String(idx + 1);
        });

        let currentStep = 1;

        function clearStepErrors(stepEl) {
            stepEl.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            stepEl.querySelectorAll('.error-message').forEach(em => em.textContent = '');
        }

        function setFieldError(field, message) {
            field.classList.add('is-invalid');
            const fg = field.closest('.form-group');
            if (fg) {
                const em = fg.querySelector('.error-message');
                if (em) em.textContent = message || 'This field is required.';
            }
        }

        function validateCurrentStep() {
            const stepEl = formSteps[currentStep - 1];
            if (!stepEl) return true;

            clearStepErrors(stepEl);

            const requiredFields = Array.from(stepEl.querySelectorAll('[required]'));
            let firstInvalid = null;

            requiredFields.forEach(field => {
                // hidden inputs (custom selects)
                if (field.type === 'hidden') {
                    if (!field.value || String(field.value).trim() === '') {
                        if (!firstInvalid) firstInvalid = field;
                        setFieldError(field, 'Please select a value.');
                    }
                    return;
                }

                if (!field.checkValidity()) {
                    if (!firstInvalid) firstInvalid = field;
                    setFieldError(field, field.validationMessage || 'This field is required.');
                }
            });

            if (firstInvalid) {
                if (firstInvalid.type !== 'hidden') {
                    firstInvalid.focus({
                        preventScroll: true
                    });
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                } else {
                    const fg = firstInvalid.closest('.form-group');
                    if (fg) fg.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return false;
            }

            return true;
        }

        function renderSteps() {
            // show active step
            formSteps.forEach((stepEl, idx) => {
                stepEl.classList.toggle('active', (idx + 1) === currentStep);
            });

            // progress UI
            progressBoxes.forEach((box, idx) => {
                const stepNo = idx + 1;
                const circle = box.querySelector('.step-circle');

                box.classList.remove('active', 'completed');

                if (stepNo < currentStep) {
                    box.classList.add('completed');
                    if (circle) circle.innerHTML = tickSVG;
                } else if (stepNo === currentStep) {
                    box.classList.add('active');
                    if (circle) circle.textContent = circle.dataset.stepNumber || stepNo;
                } else {
                    if (circle) circle.textContent = circle.dataset.stepNumber || stepNo;
                }
            });

            // prev disabled on step 1
            if (prevBtn) prevBtn.disabled = currentStep === 1;

            // last step => hide next, show submit
            const isLast = currentStep === totalSteps;
            if (nextBtn) nextBtn.style.display = isLast ? 'none' : 'inline-flex';
            if (submitBtn) submitBtn.style.display = isLast ? 'inline-flex' : 'none';

            // Step indicator text: "Step X of Y"
            if (stepIndicator) stepIndicator.textContent = `Step ${currentStep} of ${totalSteps}`;
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (!validateCurrentStep()) return;

                if (currentStep < totalSteps) {
                    currentStep++;
                    renderSteps();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    renderSteps();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            });
        }

        renderSteps();
    });
</script>

<!-- // ✅ Toggle open/close day rows + disable inputs when closed -->

<script>
    document.querySelectorAll(".day-row").forEach((row) => {
        const toggle = row.querySelector(".day-toggle");
        const timeWrap = row.querySelector(".time-wrap");
        const closedText = row.querySelector(".closed-text");
        const inputs = row.querySelectorAll('input[type="time"]');

        function applyState() {
            const open = toggle.checked;

            row.classList.toggle("is-closed", !open);

            if (timeWrap) timeWrap.style.display = open ? "flex" : "none";
            if (closedText) closedText.classList.toggle("d-none", open);

            inputs.forEach(i => i.disabled = !open);
        }

        toggle.addEventListener("change", applyState);
        applyState();
    });
</script>


<!-- services step -->

<script>
    (function() {
        // ====== Services (your existing code) ======
        const servicesWrap = document.getElementById('servicesWrap');
        const addServiceBtn = document.getElementById('addServiceBtn');

        function reIndexServices() {
            const rows = servicesWrap.querySelectorAll('.service-row');
            rows.forEach((row, i) => {
                row.querySelectorAll('input').forEach(inp => {
                    inp.name = inp.name
                        .replace(/services\[\d+\]\[name\]/, `services[${i}][name]`)
                        .replace(/services\[\d+\]\[price\]/, `services[${i}][price]`)
                        .replace(/services\[\d+\]\[duration\]/, `services[${i}][duration]`);
                });
            });
        }

        servicesWrap?.addEventListener('click', function(e) {
            const btn = e.target.closest('.delete-service');
            if (!btn) return;
            const rows = servicesWrap.querySelectorAll('.service-row');
            if (rows.length === 1) return;
            btn.closest('.service-row').remove();
            reIndexServices();
        });

        addServiceBtn?.addEventListener('click', function() {
            const idx = servicesWrap.querySelectorAll('.service-row').length;
            const div = document.createElement('div');
            div.className = 'service-card service-row';
            div.innerHTML = `
      <div class="service-grid">
        <div class="fg">
          <label>Service Name</label>
          <input type="text" name="services[${idx}][name]" placeholder="e.g., Haircut, Massage">
        </div>
        <div class="fg">
          <label>Price</label>
          <input type="text" name="services[${idx}][price]" placeholder="e.g., $25">
        </div>
        <div class="fg">
          <label>Duration (mins)</label>
          <input type="number" name="services[${idx}][duration]" value="30" min="0">
        </div>
        <button type="button" class="delete-service" title="Remove">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/>
          </svg>
        </button>
      </div>
    `;
            servicesWrap.appendChild(div);
        });

        // ====== Features Select (FIXED) ======
        const featuresGrid = document.getElementById('featuresGrid');
        const selectedChips = document.getElementById('selectedChips');
        const selectedCount = document.getElementById('selectedCount');

        const featuresHidden = document.getElementById('featuresHidden'); // CSV names
        const featureIconsHidden = document.getElementById('featureIconsHidden'); // CSV icons
        const featureIDHidden = document.getElementById('featureIDHidden'); // CSV icons

        const rvFeat = document.getElementById('rv_features_chips'); // Step6 review

        if (!featuresGrid || !selectedChips || !selectedCount || !featuresHidden || !featureIconsHidden) {
            return; // features section not on this page
        }

        // Map key = feature_id (string), value = {name, icon}
        const selected = new Map();

        function setTileSelected(tile, isSel) {
            tile.classList.toggle('is-selected', isSel);
            tile.setAttribute('aria-pressed', isSel ? 'true' : 'false');
        }

        function syncHidden() {
            const names = [];
            const icons = [];
            const ids = [];

            selected.forEach((v, k) => { // k = feature_id
                names.push(v.name);
                icons.push(v.icon || '');
                ids.push(k); // ✅ id Map key se
            });

            featuresHidden.value = names.join(',');
            featureIconsHidden.value = icons.join(',');
            featureIDHidden.value = ids.join(',');
            selectedCount.textContent = String(selected.size);
        }



        function renderReviewFeatures() {
            if (!rvFeat) return;

            rvFeat.innerHTML = '';

            if (selected.size === 0) {
                rvFeat.innerHTML = `<span class="muted-sm">No features selected.</span>`;
                return;
            }

            // Review chips (simple chips without remove button)
            selected.forEach((v) => {
                const chip = document.createElement('span');
                chip.className = 'chip';
                chip.textContent = v.name;
                rvFeat.appendChild(chip);
            });
        }

        function renderChips() {
            selectedChips.innerHTML = '';

            selected.forEach((v, id) => {
                const chip = document.createElement('div');
                chip.className = 'sel-chip';
                chip.setAttribute('data-id', id);

                chip.innerHTML = `
        <span>${v.name}</span>
        <button type="button" aria-label="remove">×</button>
      `;
                selectedChips.appendChild(chip);
            });

            syncHidden();
            renderReviewFeatures();
        }

        // Click on tiles (select / deselect)
        featuresGrid.addEventListener('click', function(e) {
            const tile = e.target.closest('.feature-tile');
            if (!tile) return;

            const id = String(tile.getAttribute('data-id') || '').trim();
            const name = String(tile.getAttribute('data-name') || '').trim();
            const icon = String(tile.getAttribute('data-icon') || '').trim();

            console.log({
                id,
                name,
                icon
            });

            if (!id || !name) return;

            if (selected.has(id)) {
                selected.delete(id);
                setTileSelected(tile, false);
            } else {
                selected.set(id, {
                    name,
                    icon
                });
                setTileSelected(tile, true);
            }

            renderChips();
        });

        // Remove from chips
        selectedChips.addEventListener('click', function(e) {
            const btn = e.target.closest('button');
            if (!btn) return;

            const chip = btn.closest('.sel-chip');
            const id = chip?.getAttribute('data-id');
            if (!id) return;

            selected.delete(id);
            chip.remove();

            // unselect tile too
            const tile = featuresGrid.querySelector(`.feature-tile[data-id="${id}"]`);
            consolelog(tile);
            if (tile) setTileSelected(tile, false);

            syncHidden();
            renderReviewFeatures();
            selectedCount.textContent = String(selected.size);

            if (selected.size === 0) renderChips();
        });

        // ✅ If edit page (already saved CSV in hidden) -> auto select
        const savedNames = (featuresHidden.value || '').split(',').map(s => s.trim()).filter(Boolean);
        const savedIcons = (featureIconsHidden.value || '').split(',').map(s => s.trim());

        if (savedNames.length) {
            // match by tile name (because CSV me ids nahi)
            const tiles = featuresGrid.querySelectorAll('.feature-tile');
            tiles.forEach((tile) => {
                const id = String(tile.getAttribute('data-id') || '').trim();
                const name = String(tile.getAttribute('data-name') || '').trim();
                const icon = String(tile.getAttribute('data-icon') || '').trim();

                const idx = savedNames.findIndex(n => n.toLowerCase() === name.toLowerCase());
                if (idx > -1 && id) {
                    selected.set(id, {
                        name,
                        icon: savedIcons[idx] || icon
                    });
                    setTileSelected(tile, true);
                }
            });

            renderChips();
        } else {
            renderReviewFeatures(); // initial
        }

    })();
</script>


<!-- media step js -->

<script>
    // Gallery preview (shows thumbnails like your screenshot)
    const galleryInput = document.getElementById("business_gallery");
    const galleryPreview = document.getElementById("galleryPreview");
    const galleryCountText = document.getElementById("galleryCountText");

    // IMPORTANT: FileList read-only hoti hai, so we keep our own array
    let selectedFiles = [];

    function syncInputFiles() {
        // Update the actual input.files using DataTransfer
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        galleryInput.files = dt.files;
    }

    function renderGallery() {
        galleryPreview.innerHTML = "";

        // show max 20 like your code
        selectedFiles.slice(0, 20).forEach((file, index) => {
            const url = URL.createObjectURL(file);

            // wrapper
            const wrap = document.createElement("div");
            wrap.className = "gallery-item";

            // image
            const img = document.createElement("img");
            img.className = "gallery-thumb";
            img.src = url;
            img.alt = "Gallery Image";

            // remove button
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "gallery-remove-btn";
            btn.innerHTML = "&times;"; // ×

            btn.addEventListener("click", () => {
                // remove that file from array
                selectedFiles.splice(index, 1);

                // update input files + re-render
                syncInputFiles();
                renderGallery();

                // cleanup object url
                URL.revokeObjectURL(url);
            });

            wrap.appendChild(img);
            wrap.appendChild(btn);
            galleryPreview.appendChild(wrap);
        });

        galleryCountText.textContent = `${selectedFiles.length} photos ready to showcase`;
    }

    galleryInput?.addEventListener("change", () => {
        const files = Array.from(galleryInput.files || []);

        // replace selection (same behaviour as your old code)
        selectedFiles = files.slice(0, 20);

        syncInputFiles();
        renderGallery();
    });

    // Optional: YouTube preview (basic)
    const ytInput = document.getElementById("youtube_video");
    const emptyBox = document.getElementById("videoPreviewEmpty");
    const frameBox = document.getElementById("videoPreviewFrame");

    function extractYouTubeId(value) {
        if (!value) return null;

        // iframe embed
        const iframeMatch = value.match(/src=["']([^"']+)["']/i);
        if (iframeMatch) value = iframeMatch[1];

        // youtu.be / watch?v=
        const idMatch =
            value.match(/youtu\.be\/([A-Za-z0-9_-]{6,})/) ||
            value.match(/v=([A-Za-z0-9_-]{6,})/) ||
            value.match(/embed\/([A-Za-z0-9_-]{6,})/);

        return idMatch ? idMatch[1] : null;
    }

    ytInput?.addEventListener("input", () => {
        const id = extractYouTubeId(ytInput.value.trim());
        if (!id) {
            frameBox.classList.add("d-none");
            emptyBox.classList.remove("d-none");
            frameBox.innerHTML = "";
            return;
        }

        emptyBox.classList.add("d-none");
        frameBox.classList.remove("d-none");
        frameBox.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}" title="YouTube video"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen></iframe>`;
    });
</script>

<script>
    // ---------- Listing option active border ----------
    const optFree = document.getElementById('optFreeWrap');
    const optPremium = document.getElementById('optPremiumWrap');

    function refreshListingUI() {
        const freeChecked = optFree.querySelector('input').checked;
        optFree.classList.toggle('active', freeChecked);
        optPremium.classList.toggle('active', !freeChecked);
    }
    optFree?.addEventListener('click', refreshListingUI);
    optPremium?.addEventListener('click', refreshListingUI);
    refreshListingUI();

    // ---------- Edit button jump (you already have steps) ----------
    function goToStep(stepNumber) {
        // yahan aap apna existing step show wala function call karo
        // Example: showStep(stepNumber)
        // Abhi demo:
        const allSteps = document.querySelectorAll('.form-step');
        allSteps.forEach(s => s.classList.add('d-none'));
        const target = document.querySelector('.form-step[data-step="' + stepNumber + '"]');
        if (target) {
            target.classList.remove('d-none');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }
</script>

<script>
    function fillReviewFromForm() {
        const setText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = (val && String(val).trim()) ? val : '—';
        };

        // Step 1
        const businessName = document.querySelector('[name="business_name"]')?.value || '—';

        // ✅ Custom selects: label text (shown text) yaha se milega
        const categoryLabel = document.querySelector('#categorySelect [data-label]')?.textContent?.trim() || '—';
        const countryLabel = document.querySelector('#countrySelect [data-label]')?.textContent?.trim() || '—';
        const stateLabel = document.querySelector('#stateSelect [data-label]')?.textContent?.trim() || '—';
        const cityLabel = document.querySelector('#citySelect [data-label]')?.textContent?.trim() || '—';

        // ✅ Hidden selected ids
        const categoryId = document.querySelector('[name="category_id"]')?.value || '';
        const countryId = document.querySelector('[name="country_id"]')?.value || '';
        const stateId = document.querySelector('[name="state_id"]')?.value || '';
        const cityId = document.querySelector('[name="city_id"]')?.value || '';

        const address = document.querySelector('[name="full_address"]')?.value || '—';
        const description = document.querySelector('[name="business_description"]')?.value || '—';

        setText('rv_business_name', businessName);
        setText('rv_category', categoryId ? categoryLabel : '—');
        setText('rv_country', countryId ? countryLabel : '—');
        setText('rv_state', stateId ? stateLabel : '—');
        setText('rv_city', cityId ? cityLabel : '—');
        setText('rv_address', address);
        setText('rv_description', description);

        // Step 2: Contact
        setText('rv_contact_name', document.querySelector('[name="contact_name"]')?.value || '—');
        setText('rv_phone', document.querySelector('[name="phone"]')?.value || '—');
        setText('rv_email', document.querySelector('[name="email"]')?.value || '—');
        setText('rv_alt_phone', document.querySelector('[name="alternate_phone"]')?.value || '—');
        setText('rv_website', document.querySelector('[name="website"]')?.value || '—');

        // ✅ Logo in review (aapke preview img se)
        const logoImg = document.getElementById('logoImage');
        const rvLogo = document.getElementById('rv_business_logo');
        if (rvLogo) {
            if (logoImg && logoImg.src && logoImg.src.startsWith('blob:')) {
                rvLogo.innerHTML = `<img src="${logoImg.src}" style="max-width:120px; height:auto; border-radius:8px;" alt="Logo" />`;
            } else {
                rvLogo.textContent = '—';
            }
        }

        // Step 4: Services list
        const rvServices = document.getElementById('rv_services_list');
        if (rvServices) {
            const serviceRows = document.querySelectorAll('#servicesWrap .service-row');
            const items = [];
            serviceRows.forEach((row) => {
                const name = row.querySelector('input[name*="[name]"]')?.value?.trim();
                const price = row.querySelector('input[name*="[price]"]')?.value?.trim();
                const dur = row.querySelector('input[name*="[duration]"]')?.value?.trim();
                if (name || price || dur) items.push({
                    name,
                    price,
                    dur
                });
            });

            if (!items.length) {
                rvServices.textContent = 'No services added.';
            } else {
                rvServices.innerHTML = items.map(s =>
                    `<div class="hours-row">
            <div class="d">${s.name || '—'}</div>
            <div class="t">${s.price || '—'} ${s.dur ? `• ${s.dur} mins` : ''}</div>
          </div>`
                ).join('');
            }
        }

        // Step 4: Features chips (hidden input: features)
        // const rvFeat = document.getElementById('rv_features_chips');
        // const featHidden = document.getElementById('featuresHidden')?.value || '';
        // if (rvFeat) {
        //     if (!featHidden.trim()) {
        //         rvFeat.innerHTML = `<span class="muted-sm">No features selected.</span>`;
        //     } else {
        //         const selectedChips = document.getElementById('selectedChips');
        //         rvFeat.innerHTML = selectedChips ? selectedChips.innerHTML : `<span class="muted-sm">Selected.</span>`;
        //     }
        // }

        // Step 5: Gallery thumbs
        const rvThumbs = document.getElementById('rv_gallery_thumbs');
        const galleryPreview = document.getElementById('galleryPreview');
        const rvCount = document.getElementById('rv_gallery_count');
        if (rvThumbs && galleryPreview) {
            rvThumbs.innerHTML = galleryPreview.innerHTML || '';
            const count = galleryPreview.querySelectorAll('img').length;
            if (rvCount) rvCount.textContent = count;
            if (!rvThumbs.innerHTML.trim()) rvThumbs.innerHTML = `<span class="muted-sm">—</span>`;
        }

        // Step 5: Youtube (just show text or embed later)
        const yt = document.getElementById('youtube_video')?.value?.trim();
        const rvYt = document.getElementById('rv_youtube_box');
        if (rvYt) {
            if (!yt) {
                rvYt.innerHTML = `<div class="video-empty">—</div>`;
            } else {
                rvYt.innerHTML = `<div style="font-size:14px; word-break:break-all;">${yt}</div>`;
            }
        }

        fillHoursInReview();
    }

    function fillHoursInReview() {
        const rvTable = document.getElementById('rv_hours_table');
        if (!rvTable) return;

        // review me already Monday..Sunday rows hain (d=day, t=time). :contentReference[oaicite:2]{index=2}
        const rows = rvTable.querySelectorAll('.hours-row');

        rows.forEach((row) => {
            const dayName = (row.querySelector('.d')?.textContent || '').trim().toLowerCase();
            const timeCell = row.querySelector('.t');
            if (!timeCell || !dayName) return;

            // step 3 day-row data-day="monday" etc
            const dayRow = document.querySelector(`.day-row[data-day="${dayName}"]`);
            if (!dayRow) {
                timeCell.textContent = '—';
                return;
            }

            const toggle = dayRow.querySelector('.day-toggle');
            const isOpen = toggle ? toggle.checked : true;

            if (!isOpen) {
                timeCell.textContent = 'Closed';
                return;
            }

            const start = document.querySelector(`input[name="hours[${dayName}][start]"]`)?.value || '';
            const end = document.querySelector(`input[name="hours[${dayName}][end]"]`)?.value || '';

            const lunchStart = document.querySelector(`input[name="hours[${dayName}][lunch_start]"]`)?.value || '';
            const lunchEnd = document.querySelector(`input[name="hours[${dayName}][lunch_end]"]`)?.value || '';

            let txt = '';
            if (start && end) txt += `${start} - ${end}`;
            if (lunchStart && lunchEnd) txt += `  |  Lunch: ${lunchStart} - ${lunchEnd}`;

            timeCell.textContent = txt || '—';
        });
    }
</script>


<script>
    // goToStep already hai aapke project me (Edit buttons me call ho raha hai)
    // बस isme end me yeh add kardo:

    function goToStep(step) {
        document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
        document.querySelector('.form-step[data-step="' + step + '"]')?.classList.add('active');

        // ✅ Step 6 par आते hi review fill
        if (Number(step) === 6) {
            fillReviewFromForm();
        }
    }

    // ✅ Next button se jab step 6 aayega tab bhi fill
    document.getElementById('nextBtn')?.addEventListener('click', () => {
        const active = document.querySelector('.form-step.active');
        const step = Number(active?.getAttribute('data-step') || 1);
        const next = step + 1;

        // (aapka existing step change logic rahe)
        // बस before/after step activate, yeh call ensure:
        if (next === 6) fillReviewFromForm();
    });
</script>



{{-- ===================== EDIT PREFILL + HELPERS JS ===================== --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ----------------- Custom select helper -----------------
        function setSelectValue(selectId, value, label) {
            const wrap = document.getElementById(selectId);
            if (!wrap) return;
            const hidden = wrap.querySelector('input[data-hidden]');
            const lbl = wrap.querySelector('[data-label]');
            if (hidden) hidden.value = value ?? '';
            if (lbl) lbl.textContent = (label && label.trim()) ? label : lbl.textContent;
        }

        // ✅ Prefill Category label from selected option
        const catHidden = document.querySelector('#categorySelect input[data-hidden]');
        if (catHidden && catHidden.value) {
            const opt = document.querySelector(`#categoryOptions .select-option[data-id="${catHidden.value}"]`);
            if (opt) setSelectValue('categorySelect', catHidden.value, opt.textContent.trim());
        }

        // ✅ Prefill Country label (from list)
        const countryHidden = document.querySelector('#countrySelect input[data-hidden]');
        if (countryHidden && countryHidden.value) {
            const opt = document.querySelector(`#countrySelect .select-option[data-id="${countryHidden.value}"]`);
            if (opt) setSelectValue('countrySelect', countryHidden.value, opt.textContent.trim());
        }

        // ⚠️ State/City options are loaded dynamically in your JS (AJAX),
        // so we keep ids ready. After your stateOptions/cityOptions load,
        // call these lines again (or call `prefillStateCity()`).
        function prefillStateCity() {
            const stateId = document.querySelector('#stateSelect input[data-hidden]')?.value;
            const cityId = document.querySelector('#citySelect input[data-hidden]')?.value;

            if (stateId) {
                const st = document.querySelector(`#stateOptions .select-option[data-id="${stateId}"]`);
                if (st) setSelectValue('stateSelect', stateId, st.textContent.trim());
            }
            if (cityId) {
                const ct = document.querySelector(`#cityOptions .select-option[data-id="${cityId}"]`);
                if (ct) setSelectValue('citySelect', cityId, ct.textContent.trim());
            }
        }

        // Run once (if options already there)
        prefillStateCity();

        // ----------------- Hours toggle UI -----------------
        document.querySelectorAll('.day-row').forEach(row => {
            const toggle = row.querySelector('.day-toggle');
            const timeWrap = row.querySelector('.time-wrap');
            const closedText = row.querySelector('.closed-text');

            function sync() {
                const isOn = toggle.checked;
                row.classList.toggle('is-closed', !isOn);

                if (timeWrap) timeWrap.style.display = isOn ? '' : 'none';
                if (closedText) closedText.classList.toggle('d-none', isOn);

                // Disable inputs when closed (so request doesn't send)
                row.querySelectorAll('input[type="time"]').forEach(inp => {
                    inp.disabled = !isOn;
                });
            }

            if (toggle) {
                toggle.addEventListener('change', sync);
                sync();
            }
        });

        // ----------------- Logo preview -----------------
        const existingLogoPath = document.getElementById('existingLogoPath')?.value;
        const logoPreview = document.getElementById('logoPreview');
        const logoImage = document.getElementById('logoImage');
        const logoFile = document.getElementById('logoFile');
        const removeLogo = document.getElementById('removeLogo');

        if (existingLogoPath) {
            logoPreview.style.display = 'block';
            logoImage.src = existingLogoPath;
        }

        if (logoFile) {
            logoFile.addEventListener('change', (e) => {
                const f = e.target.files?.[0];
                if (!f) return;
                const url = URL.createObjectURL(f);
                logoPreview.style.display = 'block';
                logoImage.src = url;
            });
        }

        if (removeLogo) {
            removeLogo.addEventListener('click', () => {
                if (logoFile) logoFile.value = '';
                if (logoPreview) logoPreview.style.display = 'none';
                if (logoImage) logoImage.src = '';
            });
        }

        // ----------------- Services add/remove -----------------
        const servicesWrap = document.getElementById('servicesWrap');
        const addServiceBtn = document.getElementById('addServiceBtn');

        function currentServiceIndex() {
            return servicesWrap ? servicesWrap.querySelectorAll('.service-row').length : 0;
        }

        if (addServiceBtn && servicesWrap) {
            addServiceBtn.addEventListener('click', () => {
                const i = currentServiceIndex();
                const html = `
                <div class="service-card service-row">
                    <div class="service-grid">
                        <div class="fg">
                            <label>Service Name</label>
                            <input type="text" name="services[${i}][name]" placeholder="e.g., Haircut">
                        </div>
                        <div class="fg">
                            <label>Price</label>
                            <input type="text" name="services[${i}][price]" placeholder="e.g., $25">
                        </div>
                        <div class="fg">
                            <label>Duration (mins)</label>
                            <input type="number" name="services[${i}][duration]" value="30" min="0">
                        </div>
                        <button type="button" class="delete-service" title="Remove">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M8 6V4h8v2" />
                                <path d="M19 6l-1 14H6L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
                servicesWrap.insertAdjacentHTML('beforeend', html);
            });

            servicesWrap.addEventListener('click', (e) => {
                const btn = e.target.closest('.delete-service');
                if (!btn) return;
                const row = btn.closest('.service-row');
                if (row) row.remove();
            });
        }

        // ----------------- Features preselect + CSV hidden sync -----------------
        const featureIDHidden = document.getElementById('featureIDHidden');
        const featuresHidden = document.getElementById('featuresHidden');
        const featureIconsHidden = document.getElementById('featureIconsHidden');

        function updateFeatureCsvFromActive() {
            const active = Array.from(document.querySelectorAll('.feature-tile.active'));
            const ids = active.map(b => b.dataset.id);
            const names = active.map(b => b.dataset.name);
            const icons = active.map(b => b.dataset.icon || '');

            if (featureIDHidden) featureIDHidden.value = ids.join(',');
            if (featuresHidden) featuresHidden.value = names.join(',');
            if (featureIconsHidden) featureIconsHidden.value = icons.join(',');

            const count = document.getElementById('selectedCount');
            if (count) count.textContent = String(active.length);

            // Chips
            const chipsWrap = document.getElementById('selectedChips');
            if (chipsWrap) {
                chipsWrap.innerHTML = '';
                active.forEach(b => {
                    const chip = document.createElement('div');
                    chip.className = 'chip';
                    chip.textContent = b.dataset.name;
                    chipsWrap.appendChild(chip);
                });
            }
        }

        // Pre-activate based on CSV
        const existingIds = (featureIDHidden?.value || '').split(',').map(v => v.trim()).filter(Boolean);
        if (existingIds.length) {
            document.querySelectorAll('.feature-tile').forEach(btn => {
                if (existingIds.includes(btn.dataset.id)) btn.classList.add('active');
            });
        }
        updateFeatureCsvFromActive();

        document.getElementById('featuresGrid')?.addEventListener('click', (e) => {
            const tile = e.target.closest('.feature-tile');
            if (!tile) return;
            tile.classList.toggle('active');
            updateFeatureCsvFromActive();
        });

        // ----------------- Gallery preview (new uploads) -----------------
        const galleryInput = document.getElementById('business_gallery');
        const galleryPreview = document.getElementById('galleryPreview');
        const galleryCountText = document.getElementById('galleryCountText');

        if (galleryInput && galleryPreview) {
            galleryInput.addEventListener('change', () => {
                const files = Array.from(galleryInput.files || []);
                // Keep existing thumbs, append new thumbs
                files.forEach(f => {
                    const url = URL.createObjectURL(f);
                    const div = document.createElement('div');
                    div.className = 'thumb';
                    div.innerHTML = `<img src="${url}" alt="">`;
                    galleryPreview.appendChild(div);
                });

                if (galleryCountText) {
                    const total = galleryPreview.querySelectorAll('.thumb').length;
                    galleryCountText.textContent = `${total} photos ready to showcase`;
                }
            });
        }

    });
</script>


@endsection