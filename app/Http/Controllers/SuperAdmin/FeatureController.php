<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('id', 'desc')->get();
        return view('superadmin.feature', compact('features'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'icon'      => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        Feature::create([
            'name'      => $data['name'],
            'icon'      => $data['icon'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? 0),
        ]);

        return back()->with('success', 'Feature added successfully!');
    }


    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'icon'      => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        $feature->update([
            'name'      => $data['name'],
            'icon'      => $data['icon'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? 0),
        ]);

        return back()->with('success', 'Feature updated successfully!');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return back()->with('success', 'Feature deleted successfully!');
    }

    public function toggleStatus(Feature $feature)
    {
        $feature->is_active = !$feature->is_active;
        $feature->save();

        return back()->with('success', 'Status updated!');
    }
}
