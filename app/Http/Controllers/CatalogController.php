<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('jenis_hewan', 'like', "%{$search}%")
                      ->orWhere('kategori', 'like', "%{$search}%")
                      ->orWhere('merek', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            $products = $query->paginate(10); // Pagination

            return view('pages.app.katalog.index', compact('products'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return view('pages.app.katalog.show', compact('product'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }


}
