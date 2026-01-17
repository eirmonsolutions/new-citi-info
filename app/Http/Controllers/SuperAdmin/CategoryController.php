<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('superadmin.category', compact('categories'));
    }

    public function toggleHome($id)
    {
        $cat = Category::findOrFail($id);

        // if turning ON, check max 6
        if (!$cat->is_home) {
            $count = Category::where('is_home', 1)->count();
            if ($count >= 8) {
                return back()->with('error', 'You can select only 6 categories for homepage.');
            }
        }

        $cat->is_home = !$cat->is_home;
        $cat->save();

        return back()->with('success', 'Homepage categories updated!');
    }


    // ✅ ONLY for main category image (compress to <= 500KB)
    private function compressAndStoreMainImage(
        UploadedFile $file,
        string $folder = 'categories',
        int $maxKb = 500,
        int $maxWidth = 1200
    ): string {
        $manager = new ImageManager(new Driver());
        $image   = $manager->read($file->getPathname());

        // resize down (keep aspect ratio)
        $image->scaleDown(width: $maxWidth);

        $filename = uniqid('cat_') . '.jpg';
        $path     = $folder . '/' . $filename;

        // compress loop
        $quality = 85;
        do {
            $encoded = $image->toJpeg($quality);
            $quality -= 5;
        } while (strlen((string)$encoded) > ($maxKb * 1024) && $quality > 30);

        Storage::disk('public')->put($path, (string)$encoded);

        return $path;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'categoryimage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // ✅ NO compress
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // allow bigger, we compress anyway
            'is_active'     => ['nullable', 'in:0,1'],
        ]);

        $category = new Category();
        $category->name      = $data['name'];
        $category->is_active = (bool)($data['is_active'] ?? 0);

        // ✅ ICON IMAGE (NO COMPRESS) -> normal store
        if ($request->hasFile('categoryimage')) {
            $category->categoryimage = $request->file('categoryimage')->store('category-icon', 'public');
        }

        // ✅ MAIN CATEGORY IMAGE (COMPRESS to <= 500KB)
        if ($request->hasFile('image')) {
            $category->image = $this->compressAndStoreMainImage(
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
            'categoryimage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // ✅ NO compress
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // allow bigger, we compress anyway
            'is_active'     => ['nullable', 'in:0,1'],
        ]);

        $category->name      = $request->name;
        $category->is_active = $request->is_active ?? 0;

        // ✅ ICON IMAGE update (NO COMPRESS)
        if ($request->hasFile('categoryimage')) {
            if ($category->categoryimage && Storage::disk('public')->exists($category->categoryimage)) {
                Storage::disk('public')->delete($category->categoryimage);
            }
            $category->categoryimage = $request->file('categoryimage')->store('category-icon', 'public');
        }

        // ✅ MAIN IMAGE update (COMPRESS)
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->image = $this->compressAndStoreMainImage(
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
