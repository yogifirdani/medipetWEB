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

        $serviceTime = $request->has('service_time') ? json_encode($request->service_time) : null;

        Category::create([
            'pet_category' => $request->pet_category,
            'service_category' => $request->service_category,
            'service_time' => $serviceTime,
            'take_status' => $request->take_status,
            'price' => $request->price
        ]);

        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $category->service_time = json_decode($category->service_time, true) ?? [];
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
        $category->pet_category = $request->pet_category;
        $category->service_category = $request->service_category;
        $category->service_time = json_encode($request->service_time); 
        $category->take_status = $request->take_status;
        $category->price = $request->price;

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
