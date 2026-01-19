@extends('layouts.superadmin')

@section('title', 'Listing')

@section('content')

<main class="main-dashboard">

    <div class="top-heading">
        <h1>Listing List</h1>
    </div>

    {{-- FILTER BAR --}}
    <div class="d-flex gap-2 flex-wrap mb-3">

        <a href="{{ route('superadmin.listing.index', ['status' => 'all']) }}"
            class="theme-btn {{ $status == 'all' ? 'active' : '' }}">
            All ({{ $counts['all'] ?? 0 }})
        </a>

        <a href="{{ route('superadmin.listing.index', ['status' => 'published']) }}"
            class="theme-btn {{ $status == 'published' ? 'active' : '' }}">
            Published ({{ $counts['published'] ?? 0 }})
        </a>

        <a href="{{ route('superadmin.listing.index', ['status' => 'pending']) }}"
            class="theme-btn {{ $status == 'pending' ? 'active' : '' }}">
            Pending ({{ $counts['pending'] ?? 0 }})
        </a>

        <a href="{{ route('superadmin.listing.index', ['status' => 'expired']) }}"
            class="theme-btn {{ $status == 'expired' ? 'active' : '' }}">
            Expired ({{ $counts['expired'] ?? 0 }})
        </a>

        <a href="{{ route('superadmin.listing.index', ['status' => 'trash']) }}"
            class="theme-btn {{ $status == 'trash' ? 'active' : '' }}">
            Trash ({{ $counts['trash'] ?? 0 }})
        </a>




    </div>

    <section class="table-section table-responsive">
        <table class="table">
            <thead>
                <tr>
                    @if(in_array($status, ['all','published']))
                    <th>Allow</th>
                    @endif
                    <th>#</th>
                    <th>Business Name</th>
                    <th>Category</th>
                    <th>Location (City)</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($listings as $i => $listing)
                <tr>

                    @if(in_array($status, ['all','published']))
                    <td>
                        <form method="POST" action="{{ route('superadmin.listing.toggleAllow', $listing) }}">
                            @csrf
                            @method('PATCH')

                            <label class="switch">
                                <input type="checkbox" onchange="this.form.submit()" {{ $listing->is_allowed ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </form>
                    </td>
                    @endif

                    <td>{{ $listings->firstItem() + $i }}</td>

                    <td>
                        {{ $listing->business_name ?? '-' }}
                    </td>

                    <td>
                        {{ $listing->categoryRel->name ?? '-' }}
                    </td>

                    <td>
                        {{ $listing->cityRel->name ?? '-' }}
                    </td>

                    <td>
                        @php
                        $st = $listing->status ?? 'pending';
                        $badgeClass = match($st) {
                        'published' => 'bg-label-success',
                        'pending' => 'bg-label-warning',
                        'expired' => 'bg-label-danger',
                        'trash' => 'bg-label-danger',
                        default => 'bg-label-secondary',
                        };
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($st) }}
                        </span>
                    </td>

                    <td>
                        <div class="action-buttons">

                            {{-- Pending -> View + Approve --}}
                            @if(($listing->status ?? 'pending') === 'pending' && !$listing->trashed())

                            {{-- View --}}
                            <a href="{{ route('superadmin.listing.view', $listing->id) }}"
                                class="btn-icon btn-edit"
                                title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>

                            {{-- Approve --}}
                            <form method="POST"
                                action="{{ route('superadmin.listing.approve', $listing->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="theme-btn"
                                    style="padding:8px 14px;">
                                    Approve
                                </button>
                            </form>


                            {{-- If in Trash -> Restore button --}}
                            @elseif($listing->trashed())
                            <form method="POST" action="{{ route('superadmin.listing.restore', $listing->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="theme-btn" style="padding:8px 14px;">Restore</button>
                            </form>

                            {{-- Published/All/Expired -> View (A TAG) + Delete(soft) --}}
                            @else
                            {{-- View --}}
                            <a href="{{ route('superadmin.listing.view', $listing->id) }}" class="btn-icon btn-edit" title="View">
                                {{-- Eye icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>

                            {{-- Delete => Trash (soft delete) --}}
                            <form method="POST" action="{{ route('superadmin.listing.destroy', $listing->id) }}" class="deleteListingForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No listings found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-3">
            {{ $listings->links() }}
        </div>
    </section>

</main>

@endsection