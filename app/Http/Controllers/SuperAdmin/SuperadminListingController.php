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
            $query->where('status', $status);
        }

        $listings = $query->paginate(10)->withQueryString();

        $counts = [
            'all'       => BusinessListing::count(),
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
        // trash me jaate hi homepage se bhi hata do
        if ($listing->show_on_homepage) {
            $listing->show_on_homepage = 0;
            $listing->save();
        }

        $listing->delete();

        return back()->with('success', 'Listing moved to Trash!');
    }

    public function restore($id)
    {
        $listing = BusinessListing::withTrashed()->findOrFail($id);
        $listing->restore();

        return redirect()
            ->route('superadmin.listing.index', ['status' => 'all'])
            ->with('success', 'Listing restored successfully!');
    }

    public function pendingCount()
    {
        $count = BusinessListing::where('status', 'pending')->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function toggleAllow(BusinessListing $listing)
    {
        $listing->is_allowed = !$listing->is_allowed;

        // agar disallow hua to homepage se bhi hata do
        if (!$listing->is_allowed && $listing->show_on_homepage) {
            $listing->show_on_homepage = 0;
        }

        $listing->save();

        $message = $listing->is_allowed
            ? 'Listing allowed successfully!'
            : 'Listing disallowed successfully!';

        return back()->with('success', $message);
    }

    public function toggleHomepage(BusinessListing $listing)
    {
        // sirf published + allowed listing hi homepage par ja sake
        if ($listing->status !== 'published' || !$listing->is_allowed) {
            return back()->with('error', 'Only published and allowed listings can be shown on homepage.');
        }

        // agar abhi OFF hai aur ON karna hai to max 6 check karo
        if (!$listing->show_on_homepage) {
            $homepageCount = BusinessListing::where('show_on_homepage', 1)
                ->where('status', 'published')
                ->where('is_allowed', 1)
                ->count();

            if ($homepageCount >= 6) {
                return back()->with('error', 'Maximum 6 listings can be shown on homepage.');
            }
        }

        $listing->show_on_homepage = !$listing->show_on_homepage;
        $listing->save();

        $message = $listing->show_on_homepage
            ? 'Listing added to homepage successfully!'
            : 'Listing removed from homepage successfully!';

        return back()->with('success', $message);
    }
}
