<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('superadmin.category', compact('categories'));
    }

    private function compressAndStoreImage($file, string $folder, int $maxKb = 500, int $maxWidth = 1200): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        // resize down (keep aspect ratio)
        $image->scaleDown(width: $maxWidth);

        $filename = uniqid('cat_') . '.jpg';
        $path = $folder . '/' . $filename;

        // compress loop
        $quality = 85;
        do {
            $encoded = $image->toJpeg($quality);
            $quality -= 5;
        } while (strlen((string) $encoded) > ($maxKb * 1024) && $quality > 30);

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
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
            $category->categoryimage = $this->compressAndStoreImage(
                $request->file('categoryimage'),
                'category-icon',
                200,
                400
            );
        }

        // ✅ main category image (500KB, width 1200)
        if ($request->hasFile('image')) {
            $category->image = $this->compressAndStoreImage(
                $request->file('image'),
                'categories',
                500,
                1200
            );
        }

        $category->save();

        return back()->with('success', 'Category added successfully!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'categoryimage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active'     => ['nullable', 'in:0,1'],
        ]);

        $category->name = $request->name;
        $category->is_active = $request->is_active ?? 0;

        // ✅ icon image update (delete old + save new compressed)
        if ($request->hasFile('categoryimage')) {
            if ($category->categoryimage && Storage::disk('public')->exists($category->categoryimage)) {
                Storage::disk('public')->delete($category->categoryimage);
            }

            $category->categoryimage = $this->compressAndStoreImage(
                $request->file('categoryimage'),
                'category-icon',
                200,
                400
            );
        }

        // ✅ main image update (delete old + save new compressed)
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->image = $this->compressAndStoreImage(
                $request->file('image'),
                'categories',
                500,
                1200
            );
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
