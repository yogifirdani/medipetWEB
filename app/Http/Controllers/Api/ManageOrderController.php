<?php

namespace App\Http\Controllers;

use App\Models\manage_order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

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
        $products = Product::all();
        return view('pages.admin.manage_order.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_product' => 'required|exists:product,id',
            'jumlah_pembelian' => 'required|integer|min:1',
            'total_harga' => 'required|numeric',
            'atm' => 'required|string',
            'no_rekening' => 'required|numeric',
            'status_pesanan' => 'required|in:ditolak,proses,dikirim,lunas',
        ]);

        $product = Product::findOrFail($request->id_product);

        if ($product->stok < $request->jumlah_pembelian) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $totalHarga = $product->harga * $request->jumlah_pembelian;

        DB::beginTransaction();
        try {
            $data = manage_order::create([
                'id_cust' => Auth::user()->id,
                'id_product' => $request->id_product,
                'jumlah_pembelian' => $request->jumlah_pembelian,
                'total_harga' => $totalHarga,
                'atm' => $request->atm,
                // 'no_rekening' => $request->no_rekening,
                'status_pesanan' => 'lunas',
            ]);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Order berhasil dibuat dan stok produk telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(manage_order $manage_order)
    {
        return view('pages.admin.manage_order.show', compact('manage_order'));
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

    public function getProductPrice($id)
    {
        $product = Product::findOrFail($id);
        return response()->json(['harga' => $product->harga]);
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
