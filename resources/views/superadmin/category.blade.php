@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')



<main class="main-dashboard">

    <div class="top-heading">
        <h1>Category List</h1>
        <button type="button" class="theme-btn" data-bs-toggle="modal" data-bs-target="#CategoryModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Category
        </button>
    </div>


    <section class="table-section table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Image</th>
                    <th>Category Name</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                @foreach($categories as $index => $cat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="category-img">
                            <img src="{{ $cat->image ? asset('storage/'.$cat->image) : asset('assets/images/saloon.jpg') }}" alt="">
                        </div>
                    </td>
                    <td>{{ $cat->name }}</td>
                    <td>
                        <div class="category-icon">
                            @if($cat->icon)
                            <i class="{{ $cat->icon }}"></i>
                            @else
                            -
                            @endif
                        </div>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('superadmin.category.toggle-status', $cat->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge {{ $cat->is_active ? 'bg-label-success' : 'bg-label-danger' }}" style="border:0;">
                                {{ $cat->is_active ? 'Active' : 'InActive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button
                                class="btn-icon btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal"
                                data-id="{{ $cat->id }}"
                                data-name="{{ $cat->name }}"
                                data-icon="{{ $cat->icon }}"
                                data-active="{{ $cat->is_active ? 1 : 0 }}"
                                data-image="{{ $cat->image ? asset('storage/'.$cat->image) : '' }}">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>

                            <form method="POST" action="{{ route('superadmin.category.destroy', $cat) }}" class="deleteCategoryForm">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-icon btn-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
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

                @endforeach

            </tbody>
        </table>
    </section>

</main>



<!-- Modal -->
<div class="modal fade CategoryModal" id="CategoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryModalLabel">Add New Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" method="POST" action="{{ route('superadmin.category.store') }}" enctype="multipart/form-data" class="modal-body">
                @csrf
                <div class="form-group">
                    <label for="categoryName" class="form-label">Category Name</label>
                    <input type="text" id="categoryName" name="name" class="form-input" placeholder="Enter category name" required="">
                </div>


                <div class="form-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                            type="button" id="iconDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectedIcon"><i class="fa-solid fa-icons me-2"></i>Select Icon</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="iconDropdown" style="max-height: 250px; overflow-y: auto;">
                            <li><a class="dropdown-item icon-option" data-value="flaticon-government" href="#"><i class="flaticon-government me-2"></i> Home</a></li>
                            <li><a class="dropdown-item icon-option" data-value="flaticon-chef" href="#"><i class="flaticon-chef me-2"></i> User</a></li>
                        </ul>
                        <input type="hidden" name="icon" id="iconInput">
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoryImg" class="form-label">Category Image</label>
                    <div class="category-img-upload" id="categoryImg">
                        <div class="upload-area">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload">
                                <path d="M12 13v8" />
                                <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                                <path d="m8 17 4-4 4 4" />
                            </svg>
                            <p class="upload-text">Drop logo here or click</p>
                        </div>
                        <input type="file" id="logoFile" name="logoFile" accept="image/*" hidden="">
                    </div>
                </div>



                <div class="form-group-inline">
                    <div>
                        <label class="form-label">Active Status</label>
                        <p class="form-help text-muted">Set the category as active or inactive</p>
                    </div>
                    <label class="switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="categoryStatus" name="is_active" value="1" checked="">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for editing categories -->

<div class="modal fade CategoryModal" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryModalLabel">Edit Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data" class="modal-body">
                @csrf
                <div class="form-group">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" id="editName" class="form-input" placeholder="Enter category name" required="">
                </div>


                <div class="form-group">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex align-items-center justify-content-between"
                            type="button" id="iconDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="editSelectedIcon"><i class="fa-solid fa-icons me-2"></i>Select Icon</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="iconDropdown" style="max-height: 250px; overflow-y: auto;">
                            <li><a class="dropdown-item edit-icon-option" data-value="flaticon-government" href="#"><i class="flaticon-government me-2"></i> Home</a></li>
                            <li><a class="dropdown-item edit-icon-option" data-value="flaticon-chef" href="#"><i class="flaticon-chef me-2"></i> User</a></li>
                        </ul>
                        <input type="hidden" name="icon" id="editIconInput">
                    </div>
                </div>

                <div class="form-group">
                    <label for="categoryImg" class="form-label">Category Image</label>
                    <div class="category-img-upload" id="editUploadBox">
                        <div class="upload-area">
                            <img id="editPreview" src="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload">
                                <path d="M12 13v8" />
                                <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242" />
                                <path d="m8 17 4-4 4 4" />
                            </svg>
                            <p class="upload-text">Drop logo here or click</p>
                        </div>
                        <input type="file" id="editImage" name="image" accept="image/*" hidden>
                    </div>
                </div>



                <div class="form-group-inline">
                    <div>
                        <label class="form-label">Active Status</label>
                        <p class="form-help text-muted">Set the category as active or inactive</p>
                    </div>
                    <label class="switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="editActive" name="is_active" value="1" checked="">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    // ADD MODAL: icon select
    document.querySelectorAll('.icon-option').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const val = this.dataset.value;
            document.getElementById('iconInput').value = val;
            document.getElementById('selectedIcon').innerHTML = this.innerHTML;
        });
    });

    // ADD MODAL: image upload click
    document.getElementById('categoryImg')?.addEventListener('click', () => {
        document.getElementById('logoFile').click();
    });

    // EDIT: open modal fill data + set action url
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const icon = this.dataset.icon || '';
            const active = this.dataset.active === '1';
            const image = this.dataset.image || '';

            document.getElementById('editName').value = name;
            document.getElementById('editIconInput').value = icon;
            document.getElementById('editActive').checked = active;

            // show selected icon text
            if (icon) {
                document.getElementById('editSelectedIcon').innerHTML = `<i class="${icon} me-2"></i>${icon}`;
            } else {
                document.getElementById('editSelectedIcon').innerHTML = `<i class="fa-solid fa-icons me-2"></i>Select Icon`;
            }

            // preview
            const preview = document.getElementById('editPreview');
            if (image) {
                preview.src = image;
                preview.style.display = 'inline-block';
            } else {
                preview.style.display = 'none';
            }

            // set form action
            let url = `{{ route('superadmin.category.update', ':id') }}`;
            url = url.replace(':id', id);

            document.getElementById('editCategoryForm').action = url;
        });
    });

    // EDIT modal icon select
    document.querySelectorAll('.edit-icon-option').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            const val = this.dataset.value;
            document.getElementById('editIconInput').value = val;
            document.getElementById('editSelectedIcon').innerHTML = this.innerHTML;
        });
    });

    // EDIT image click
    document.getElementById('editUploadBox')?.addEventListener('click', () => {
        document.getElementById('editImage').click();
    });

    // EDIT preview on change
    document.getElementById('editImage')?.addEventListener('change', function() {
        const file = this.files?.[0];
        if (!file) return;
        const preview = document.getElementById('editPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'inline-block';
    });
</script>




@endsection