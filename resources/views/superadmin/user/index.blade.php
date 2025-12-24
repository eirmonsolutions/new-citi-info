@extends('layouts.superadmin')

@section('title', 'Users')

@section('content')
<main class="main-dashboard">

    <div class="top-heading">
        <h1>User List</h1>
    </div>


    <section class="table-section table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Toggle</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td>{{ $users->firstItem() + $i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    <td>
                        @if($user->is_blocked)
                        <span class="badge bg-label-danger">Blocked</span>
                        @else
                        <span class="badge bg-label-success">Active</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ route('superadmin.user.toggleStatus', $user) }}">
                            @csrf
                            @method('PATCH')
                            <label class="switch">
                                <input type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $user->is_blocked ? '' : 'checked' }}>
                                <span class="slider"></span>
                            </label>
                        </form>
                    </td>

                    <td>
                        <form method="POST"
                            action="{{ route('superadmin.user.destroy', $user) }}"
                            onsubmit="return confirm('Delete this user permanently?');">
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

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </section>

</main>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.deleteUserForm').forEach((form) => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>


@endsection