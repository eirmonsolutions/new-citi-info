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
            'name'          => ['required', 'string', 'max:255'],
            'categoryimage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // icon image
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // category image
            'is_active'     => ['nullable', 'in:0,1'],
        ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->is_active = (bool)($data['is_active'] ?? 0);

        // ✅ icon image
        if ($request->hasFile('categoryimage')) {
            $category->categoryimage = $request->file('categoryimage')->store('category-icon', 'public');
        }

        // ✅ category image
        if ($request->hasFile('image')) {
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->save();

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id); // ✅ same row

        $category->name = $request->name;
        $category->is_active = $request->is_active ?? 0;

        if ($request->hasFile('categoryimage')) {
            $category->categoryimage = $request->file('categoryimage')->store('category-icon', 'public');
        }

        if ($request->hasFile('image')) {
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

        if ($category->categoryimage && Storage::disk('public')->exists($category->categoryimage)) {
            Storage::disk('public')->delete($category->categoryimage);
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
