<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessListing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ListingAdminCredentialsMail;


class SuperadminListingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = BusinessListing::query()
            ->with(['categoryRel', 'cityRel'])
            ->orderBy('id', 'desc');

        if ($status === 'trash') {
            $query->onlyTrashed();
        } elseif ($status !== 'all') {
            $query->where('status', $status); // pending/published/expired
        }

        $listings = $query->paginate(10)->withQueryString();

        $counts = [
            'all'       => BusinessListing::count(), // default excludes trashed automatically when SoftDeletes enabled
            'published' => BusinessListing::where('status', 'published')->count(),
            'pending'   => BusinessListing::where('status', 'pending')->count(),
            'expired'   => BusinessListing::where('status', 'expired')->count(),
            'trash'     => BusinessListing::onlyTrashed()->count(),
        ];

        return view('superadmin.listing.index', compact('listings', 'status', 'counts'));
    }

    public function approve(BusinessListing $listing)
    {
        $listing->update([
            'status'      => 'published',
            'is_allowed'  => 1,
            'approved_at' => now(),
        ]);

        $user = User::find($listing->user_id);

        if ($user) {
            if ((bool) $user->is_auto_created === true) {
                $plainPassword = Str::random(10);

                $user->update([
                    'password' => Hash::make($plainPassword),
                    'role'     => 'admin',
                ]);

                Mail::to($user->email)->send(
                    new ListingAdminCredentialsMail($user, $plainPassword, $listing, true)
                );
            } else {
                $user->update([
                    'role' => 'admin',
                ]);

                Mail::to($user->email)->send(
                    new ListingAdminCredentialsMail($user, null, $listing, false)
                );
            }
        }

        return back()->with('success', 'Listing approved and published. Approval email sent successfully.');
    }


    public function show(BusinessListing $listing)
    {
        return view('superadmin.listing.view', compact('listing'));
    }

    public function destroy(BusinessListing $listing)
    {
        $listing->delete(); // ✅ soft delete
        return back()->with('success', 'Listing moved to Trash!');
    }

    public function restore($id)
    {
        $listing = BusinessListing::withTrashed()->findOrFail($id);
        $listing->restore();

        // 🔥 Redirect to ALL (or Published)
        return redirect()
            ->route('superadmin.listing.index', ['status' => 'all'])
            ->with('success', 'Listing restored successfully!');
    }


    // ✅ Allow/Disallow toggle
    public function toggleAllow(BusinessListing $listing)
    {
        $listing->is_allowed = !$listing->is_allowed;
        $listing->save();

        $message = $listing->is_allowed
            ? 'Listing allowed successfully!'
            : 'Listing disallowed successfully!';

        return back()->with('success', $message);
    }
}
