<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.orders.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.admin.orders.categories.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_category' => 'required|string|max:255',
            'service_category' => 'required|string|max:255',
            'service_time' => 'nullable|array',
            'service_time.*' => 'nullable|date_format:H:i',
            'take_status' => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);

        // Simpan kategori
        $category = Category::create([
            'pet_category' => $request->pet_category,
            'service_category' => $request->service_category,
            'take_status' => $request->take_status,
            'price' => $request->price
        ]);

        // Simpan waktu layanan di tabel pivot
        if ($request->has('service_time')) {
            foreach ($request->service_time as $time) {
                $category->serviceTimes()->create(['service_time' => $time]);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = Category::with('serviceTimes')->findOrFail($id);

        $category->serviceTimes->each(function ($serviceTime) {
            $serviceTime->service_time = \Carbon\Carbon::parse($serviceTime->service_time)->format('H:i');
        });

        return view('pages.admin.orders.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pet_category' => 'required|string|max:255',
            'service_category' => 'required|string|max:255',
            'service_time' => 'nullable|array',
            'service_time.*' => 'nullable|date_format:H:i',
            'take_status' => 'required|string|max:255',
            'price' => 'required|numeric'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'pet_category' => $request->pet_category,
            'service_category' => $request->service_category,
            'take_status' => $request->take_status,
            'price' => $request->price
        ]);

        // Perbarui waktu layanan di tabel pivot
        $category->serviceTimes()->delete(); // Hapus waktu layanan lama
        if ($request->has('service_time')) {
            foreach ($request->service_time as $time) {
                $category->serviceTimes()->create(['service_time' => $time]);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
