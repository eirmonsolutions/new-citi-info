<?php

// app/Http/Controllers/Admin/FAQController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\FAQItem;
use App\Models\BusinessListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::with(['listing'])->latest()->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        $admin = auth()->user();

        // ✅ Sirf login admin ki listings
        $listings = \App\Models\BusinessListing::select('id', 'business_name')
            ->where('user_id', $admin->id)
            ->orderBy('business_name')
            ->get();

        return view('admin.faq.create', compact('listings'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_id'   => ['required', 'integer', 'exists:business_listings,id'],
            'listing_name' => ['required', 'string', 'max:255'],

            'faq_items'               => ['required', 'array', 'min:1'],
            'faq_items.*.question'    => ['required', 'string', 'max:255'],
            'faq_items.*.answer'      => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {

            $faq = FAQ::create([
                'listing_id'   => $validated['listing_id'],
                'listing_name' => $validated['listing_name'],
            ]);

            $rows = [];
            foreach ($validated['faq_items'] as $i => $item) {
                $rows[] = [
                    'faq_id'      => $faq->id,
                    'question'    => $item['question'],
                    'answer'      => $item['answer'] ?? null,
                    'sort_order'  => $i,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            FAQItem::insert($rows);
        });

        return redirect()->route('admin.faq.index')->with('success', 'FAQ saved successfully.');
    }

    public function edit(FAQ $faq)
    {
        $admin = auth()->user();

        // ✅ Sirf login admin ki listings
        $listings = \App\Models\BusinessListing::select('id', 'business_name')
            ->where('user_id', $admin->id)
            ->orderBy('business_name')
            ->get();

        $faq->load('items');

        return view('admin.faq.edit', compact('faq', 'listings'));
    }


    public function update(Request $request, FAQ $faq)
    {
        $validated = $request->validate([
            'listing_id'   => ['required', 'integer', 'exists:business_listings,id'],
            'listing_name' => ['required', 'string', 'max:255'],

            'faq_items'               => ['required', 'array', 'min:1'],
            'faq_items.*.question'    => ['required', 'string', 'max:255'],
            'faq_items.*.answer'      => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $faq) {

            $faq->update([
                'listing_id'   => $validated['listing_id'],
                'listing_name' => $validated['listing_name'],
            ]);

            // easy & safe: delete old items then insert new
            $faq->items()->delete();

            $rows = [];
            foreach ($validated['faq_items'] as $i => $item) {
                $rows[] = [
                    'faq_id'      => $faq->id,
                    'question'    => $item['question'],
                    'answer'      => $item['answer'] ?? null,
                    'sort_order'  => $i,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            FAQItem::insert($rows);
        });

        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully.');
    }
}
