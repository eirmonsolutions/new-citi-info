<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('listing')
            ->latest()
            ->get();

        return view('admin.announcement.index', compact('announcements'));
    }


    public function create()
    {

        $admin = auth()->user();

        // ✅ Sirf login admin ki listings
        $listings = \App\Models\BusinessListing::select('id', 'business_name')
            ->where('user_id', $admin->id)
            ->orderBy('business_name')
            ->get();

        return view('admin.announcement.create', compact('listings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_id'   => ['required', 'integer', 'exists:business_listings,id'],
            'listing_name' => ['required', 'string', 'max:255'],

            'icon'         => ['nullable', 'string', 'max:80'],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],

            'button_text'  => ['nullable', 'string', 'max:80'],
            'button_link'  => ['nullable', 'string', 'max:255'],

            'start_date'   => ['nullable', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],

            'is_active'    => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Announcement::create($validated);

        return redirect()->route('admin.announcement.index')->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        $listings = \App\Models\BusinessListing::select('id', 'business_name')
            ->orderBy('business_name')
            ->get();

        return view('admin.announcement.edit', compact('announcement', 'listings'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'listing_id'   => ['required', 'integer', 'exists:business_listings,id'],
            'listing_name' => ['required', 'string', 'max:255'],

            'icon'         => ['nullable', 'string', 'max:80'],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],

            'button_text'  => ['nullable', 'string', 'max:80'],
            'button_link'  => ['nullable', 'string', 'max:255'],

            'start_date'   => ['nullable', 'date'],
            'end_date'     => ['nullable', 'date', 'after_or_equal:start_date'],

            'is_active'    => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $announcement->update($validated);

        return redirect()->route('admin.announcement.index')->with('success', 'Announcement updated successfully.');
    }

    // status toggle (index table)
    public function toggle(Request $request, Announcement $announcement)
    {
        $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $announcement->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'success'   => true,
            'is_active' => (int) $announcement->is_active,
        ]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted successfully.');
    }
}
