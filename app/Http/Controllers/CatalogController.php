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

    // //keranjang
    // public function addToCart(Request $request, $id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);

    //         // Ambil keranjang dari sesi, atau buat baru jika tidak ada
    //         $cart = session()->get('cart', []);

    //         // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
    //         if (isset($cart[$id])) {
    //             $cart[$id]['quantity']++;
    //         } else {
    //             // Jika tidak ada, tambahkan produk dengan kuantitas 1
    //             $cart[$id] = [
    //                 "name" => $product->nama,
    //                 "price" => $product->harga,
    //                 "quantity" => 1,
    //                 "image" => $product->gambar // Sesuaikan atribut gambar jika ada
    //             ];
    //         }

    //         // Simpan kembali ke sesi
    //         session()->put('cart', $cart);

    //         return redirect()->route('catalogs.show', $id)->with('success', 'Produk ditambahkan ke keranjang!');
    //     } catch (\Exception $e) {
    //         return back()->withError($e->getMessage())->withInput();
    //     }
    // }

    // public function viewCart()
    // {
    //     $cart = session()->get('cart', []);
    //     return view('pages.app.katalog.cart', compact('cart'));
    // }
}
