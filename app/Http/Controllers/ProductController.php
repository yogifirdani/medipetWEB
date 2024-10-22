<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = $request->input('q');
            if ($query) {
                $products = Product::where('nama_produk', 'like', '%' . $query . '%')
                    ->orWhere('kategori', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $products = Product::all();
            }

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
                "nama_produk" => "required|string",
                "jenis_hewan" => "required|string",
                "kategori" => "required|string",
                "merek" => "required",
                "berat" => "required|string",
                "stok" => "required|numeric",
                "harga" => "required|numeric",
                "deskripsi" => "required",
                "kadaluarsa" => "required",
                'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('/product'), $fileName);

            Product::create([
                "nama_produk" => $request->nama_produk,
                "jenis_hewan" => $request->jenis_hewan,
                "kategori" => $request->kategori,
                "merek" => $request->merek,
                "berat" => $request->berat,
                "stok" => $request->stok,
                "harga" => $request->harga,
                "deskripsi" => $request->deskripsi,
                "kadaluarsa" => $request->kadaluarsa,
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
                "nama_produk" => "required",
                // "kategori" => "required|in:grooming,vaksin,item",
                "stok" => "required",
                "harga" => "required",
                "deskripsi" => "required",
                "kadaluarsa" => "required",
                'image' => 'mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $product = Product::findOrFail($id);

            $data = $request->only(['nama_produk', 'stok', 'harga', 'deskripsi', 'kadaluarsa']);
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
