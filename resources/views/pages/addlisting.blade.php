@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

<!-- <section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Submit Your Listing</h1>
            <p>Get your business discovered by thousands of potential customers</p>
        </div>
    </div>
</section> -->



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

            <form action="" class="row">
                <div class="form-step active">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-step-inner">
                                <h2>Basic Information</h2>
                                <div class="form-grid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_name" class="form-label">Business Name <span class="required">*</span></label>
                                                <input type="text" id="business_name" name="business_name" placeholder="Enter your business name" required>
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
                                                            {{-- your svg icon --}}
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
                                                            {{-- if you want only active categories: add ->where('is_active',1) in controller --}}
                                                            <li class="select-option"
                                                                data-id="{{ $cat->id }}"
                                                                data-value="{{ $cat->id }}">
                                                                {{ $cat->name }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    {{-- IMPORTANT: submit this --}}
                                                    <input type="hidden" name="category_id" data-hidden />
                                                </div>

                                                <div class="error-message"></div>
                                            </div>
                                        </div>

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

                                                    <input type="hidden" name="country_id" data-hidden />
                                                </div>
                                            </div>
                                        </div>

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

                                                    <input type="hidden" name="state_id" data-hidden />
                                                </div>
                                            </div>
                                        </div>

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

                                                    <input type="hidden" name="city_id" data-hidden />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="full_address" class="form-label">
                                                    Full Address <span class="required">*</span>
                                                </label>
                                                <textarea
                                                    id="full_address"
                                                    name="full_address"
                                                    class="form-control textarea-field"
                                                    placeholder="Enter full business address"
                                                    rows="3"
                                                    required></textarea>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="business_description" class="form-label">
                                                    Business Description <span class="required">*</span>
                                                </label>
                                                <textarea
                                                    id="business_description"
                                                    name="business_description"
                                                    class="form-control textarea-field"
                                                    placeholder="Describe your business, services, and specialties"
                                                    rows="4"
                                                    required></textarea>
                                                <div class="error-message"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

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
                                        <div class="logo-preview" id="logoPreview" style="display: none;">
                                            <img id="logoImage" src="" alt="Logo">
                                            <button type="button" class="remove-btn" id="removeLogo">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>






</section>

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


@endsection