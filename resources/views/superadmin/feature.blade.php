@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')

<main class="main-dashboard">

    <div class="top-heading">
        <h1>Feature List</h1>

        {{-- FIX: target should be #featureModal --}}
        <button type="button" class="theme-btn" data-bs-toggle="modal" data-bs-target="#featureModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Feature
        </button>
    </div>

    <section class="table-section table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Feature Name</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="featureTableBody">

                @forelse($features as $feature)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $feature->name }}</td>

                    <td>
                        <div class="category-icon">
                            @if($feature->icon)
                            <i class="{{ $feature->icon }}"></i>
                            @else
                            -
                            @endif
                        </div>
                    </td>

                    <td>
                        <form method="POST" action="{{ route('superadmin.feature.toggle-status', $feature) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="badge {{ $feature->is_active ? 'bg-label-success' : 'bg-label-danger' }}"
                                style="border:0;">
                                {{ $feature->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>

                    <td>
                        <div class="action-buttons">

                            {{-- EDIT --}}
                            <button
                                type="button"
                                class="btn-icon btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editfeatureModal"
                                data-id="{{ $feature->id }}"
                                data-name="{{ $feature->name }}"
                                data-icon="{{ $feature->icon ?? '' }}"
                                data-active="{{ $feature->is_active ? 1 : 0 }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-pencil">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>

                            {{-- DELETE --}}
                            <form method="POST"
                                action="{{ route('superadmin.feature.destroy', $feature) }}"
                                class="deletefeatureForm d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash-2">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No features found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </section>

</main>

<!-- Add Feature Modal -->
<!-- Add Feature Modal -->
<div class="modal fade CategoryModal" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="featureModalLabel">Add New Feature</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="featureForm" method="POST" action="{{ route('superadmin.feature.store') }}" class="modal-body">
                @csrf

                <div class="form-group">
                    <label for="featureName" class="form-label">Feature Name</label>
                    <input type="text" id="featureName" name="name" class="form-input"
                        placeholder="Enter feature name" required>
                </div>

                <div class="form-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                            type="button" id="iconDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectedIcon">
                                <i class="fa-solid fa-icons me-2"></i>Select Icon
                            </span>
                        </button>

                        <ul class="dropdown-menu w-100" aria-labelledby="iconDropdown" style="max-height: 250px; overflow-y: auto;">
                            {{-- Add more icons here --}}
                            <li>
                                <a class="dropdown-item icon-option" data-value="flaticon-government" href="#">
                                    <i class="flaticon-government me-2"></i> Home
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item icon-option" data-value="flaticon-chef" href="#">
                                    <i class="flaticon-chef me-2"></i> User
                                </a>
                            </li>
                        </ul>

                        <input type="hidden" name="icon" id="iconInput">
                    </div>
                </div>

                <div class="form-group-inline">
                    <div>
                        <label class="form-label">Active Status</label>
                        <p class="form-help text-muted">Set the feature as active or inactive</p>
                    </div>

                    <label class="switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="featureStatus" name="is_active" value="1" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Feature</button>
                </div>
            </form>

        </div>
    </div>
</div>




<!-- Edit Feature Modal -->
<div class="modal fade CategoryModal" id="editfeatureModal" tabindex="-1" aria-labelledby="editfeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editfeatureModalLabel">Edit Feature</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editfeatureForm" method="POST" class="modal-body">
                @csrf

                <div class="form-group">
                    <label class="form-label">Feature Name</label>
                    <input type="text" name="name" id="editName" class="form-input"
                        placeholder="Enter feature name" required>
                </div>

                <div class="form-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                            type="button" id="editIconDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="editSelectedIcon">
                                <i class="fa-solid fa-icons me-2"></i>Select Icon
                            </span>
                        </button>

                        <ul class="dropdown-menu w-100" aria-labelledby="editIconDropdown" style="max-height: 250px; overflow-y: auto;">
                            {{-- Same icon list as Add --}}
                            <li>
                                <a class="dropdown-item edit-icon-option" data-value="flaticon-government" href="#">
                                    <i class="flaticon-government me-2"></i> Home
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item edit-icon-option" data-value="flaticon-chef" href="#">
                                    <i class="flaticon-chef me-2"></i> User
                                </a>
                            </li>
                        </ul>

                        <input type="hidden" name="icon" id="editIconInput">
                    </div>
                </div>

                <div class="form-group-inline">
                    <div>
                        <label class="form-label">Active Status</label>
                        <p class="form-help text-muted">Set the feature as active or inactive</p>
                    </div>

                    <label class="switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="editActive" name="is_active" value="1">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Feature</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ✅ ADD MODAL: icon select
        document.querySelectorAll('.icon-option').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();

                const val = this.getAttribute('data-value') || '';

                const iconInput = document.getElementById('iconInput');
                const selectedIcon = document.getElementById('selectedIcon');

                if (iconInput) iconInput.value = val;
                if (selectedIcon) selectedIcon.innerHTML = this.innerHTML;
            });
        });

        // ✅ EDIT: open modal fill data + set action url
        document.querySelectorAll('.btn-edit').forEach(function(btn) {
            btn.addEventListener('click', function() {

                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name') || '';
                const icon = this.getAttribute('data-icon') || '';
                const active = this.getAttribute('data-active') === '1';

                const editName = document.getElementById('editName');
                const editIconInput = document.getElementById('editIconInput');
                const editActive = document.getElementById('editActive');
                const editSelectedIcon = document.getElementById('editSelectedIcon');

                if (editName) editName.value = name;
                if (editIconInput) editIconInput.value = icon;
                if (editActive) editActive.checked = active;

                // show selected icon in edit dropdown button
                if (editSelectedIcon) {
                    if (icon) {
                        editSelectedIcon.innerHTML = `<i class="${icon} me-2"></i>${icon}`;
                    } else {
                        editSelectedIcon.innerHTML = `<i class="fa-solid fa-icons me-2"></i>Select Icon`;
                    }
                }

                // set edit form action
                let url = `{{ route('superadmin.feature.update', ':id') }}`;
                url = url.replace(':id', id);

                const editForm = document.getElementById('editfeatureForm');
                if (editForm) editForm.action = url;
            });
        });

        // ✅ EDIT MODAL: icon select
        document.querySelectorAll('.edit-icon-option').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();

                const val = this.getAttribute('data-value') || '';

                const editIconInput = document.getElementById('editIconInput');
                const editSelectedIcon = document.getElementById('editSelectedIcon');

                if (editIconInput) editIconInput.value = val;
                if (editSelectedIcon) editSelectedIcon.innerHTML = this.innerHTML;
            });
        });

    });
</script>


@endsection