@extends('layouts.admin')

@section('title', 'Listing')

@section('content')

<main class="main-dashboard">

    <div class="top-heading d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Listing List</h1>

        <a href="{{ route('admin.listings.create') }}" class="btn btn-primary">
            + Add Listing
        </a>
    </div>


    <section class="table-section table-responsive">
        <table class="table">
            <thead>
                <tr>
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
                    <td>{{ $listings->firstItem() + $i }}</td>

                    <td>{{ $listing->business_name ?? '-' }}</td>

                    <td>{{ $listing->categoryRel->name ?? '-' }}</td>

                    <td>{{ $listing->cityRel->name ?? '-' }}</td>

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
                            {{-- Edit --}}
                            <a href="{{ route('admin.listing.edit', $listing->id) }}"
                                class="btn-icon btn-edit"
                                title="Edit">
                                Edit
                            </a>

                            {{-- View (optional) --}}
                            {{-- <a href="{{ route('admin.listing.view', $listing->id) }}" class="btn-icon btn-view" title="View">View</a> --}}

                            {{-- Delete (optional - soft delete) --}}
                            {{--
                                <form action="{{ route('admin.listing.destroy', $listing->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                            </form>
                            --}}
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


    </section>

</main>

@endsection