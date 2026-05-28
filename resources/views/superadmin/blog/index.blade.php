@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')

<main class="main-dashboard">

    <div class="top-heading">
        <h1>Blog List</h1>

        {{-- FIX: target should be #featureModal --}}
        <button type="button" class="theme-btn" data-bs-toggle="modal" data-bs-target="#featureModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Blog
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
                
                <tr>
                    <td></td>

                    <td></td>

                    <td>
                        <div class="category-icon">
                           
                            <img
                                src=""
                                alt=""
                                >
                            
                        </div>
                    </td>

                    <td>
                        <form method="POST" action="">
                            
                            <button type="submit"
                                class="badge "
                                style="border:0;">
                                
                            </button>
                        </form>
                    </td>

                    <td>
                        <div class="action-buttons">
                            <button
                                type="button"
                                class="btn-icon btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editfeatureModal"
                                data-id=""
                                data-name=""
                                data-icon-image=""
                                data-active="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-pencil">
                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>

                            <form method="POST"
                                action=""
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
                <tr>
                    <td colspan="5" class="text-center">No features found.</td>
                </tr>
                
            </tbody>
        </table>

       
        <div class="pagination-wrap">
            <nav aria-label="Feature Pagination">
                <ul class="pagination">

                    <li class="page-item ">
                        <a class="page-link"
                            href=""
                            aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    
                    <li class="page-item ">
                        <a class="page-link" href=""></a>
                    </li>
                    

                    <li class="page-item ">
                        <a class="page-link"
                            href=""
                            aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
        
    </section>


</main>

@endsection