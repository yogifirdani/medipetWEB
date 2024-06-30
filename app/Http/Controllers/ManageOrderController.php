<?php

namespace App\Http\Controllers;

use App\Models\manage_order;
use App\Models\Product;
use Illuminate\Http\Request;

class ManageOrderController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $category = $request->input('category');

        $query = manage_order::with(['user', 'product']);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($category && $category !== 'Semua') {
            $query->whereHas('product', function($q) use ($category) {
                $q->where('category', $category);
            });
        }

        $orders = $query->get();

        return view('pages.admin.manage_order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.manage_order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cust' => 'required|exists:users,id',
            'id_product' => 'required|exists:products,id',
            'jumlah_pembelian' => 'required|integer|min:1',
            'status_pesanan' => 'required|in:ditolak,belum_bayar,lunas',
        ]);

        $product = Product::findOrFail($request->id_product);

        if ($product->stock < $request->input('jumlah_pembelian')) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $total = $product->stok - $request->jumlah_pembelian;
        $product->update(['stok' => $total]);


        return redirect()->route('transaksi.index')->with('success', 'Order berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(manage_order $manage_order)
    {
        return view('pages.admin.manage_order.show', compact('manage_order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(manage_order $manage_order)
    {
        return view('pages.admin.manage_order.edit', compact('manage_order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $order = manage_order::find($id);

    if (!$order) {
        return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
    }

    $order->status_pesanan = $request->input('status_pesanan');
    $order->save();

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(manage_order $manage_order)
    {
        $manage_order->delete();

        return redirect('/transaksi')->with('success', 'Order berhasil dihapus.');
    }
}
