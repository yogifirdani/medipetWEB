<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();

            return view('pages.admin.product.index', compact('products'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function add()
    {
        return view('pages.admin.product.add');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "category" => "required|in:grooming,vaksin,item",
                "stok" => "required|numeric",
                "price" => "required|numeric",
                "deskripsi" => "required",
                'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('/product'), $fileName);

            Product::create([
                "name" => $request->name,
                "category" => $request->category,
                "stok" => $request->stok,
                "price" => $request->price,
                "deskripsi" => $request->deskripsi,
                "image" => $fileName,
            ]);

            return redirect()->route('products.index')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('pages.admin.product.show', compact('product'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('pages.admin.product.edit', compact('product'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                // "category" => "required|in:grooming,vaksin,item",
                "stok" => "required",
                "price" => "required",
                "deskripsi" => "required",
                'image' => 'mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $product = Product::findOrFail($id);

            $data = $request->only(['name', 'category', 'stok', 'price', 'deskripsi']);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('/product'), $fileName);
                $data['image'] = $fileName;
                if ($product->image) {
                    unlink(public_path('/product/' . $product->image));
                }
            }

            $product->update($data);

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->image) {
                unlink(public_path('/product/' . $product->image));
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
