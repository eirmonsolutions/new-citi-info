<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('superadmin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'icon'       => ['nullable', 'string', 'max:255'],
            'logoFile'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'  => ['nullable', 'in:0,1'],
        ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->icon = $data['icon'] ?? null;
        $category->is_active = (bool)($data['is_active'] ?? 0);

        if ($request->hasFile('logoFile')) {
            $category->image = $request->file('logoFile')->store('categories', 'public');
        }

        $category->save();

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'icon'       => ['nullable', 'string', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'  => ['nullable', 'in:0,1'],
        ]);

        $category->name = $data['name'];
        $category->icon = $data['icon'] ?? null;
        $category->is_active = (bool)($data['is_active'] ?? 0);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {

        
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();

        return back()->with('success', 'Status updated!');
    }
}
