<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\ManageOrder;
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

        $query = ManageOrder::with(['user', 'product', 'co']);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($category && $category !== 'Semua') {
            $query->whereHas('product', function ($q) use ($category) {
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
        $request->validate([
            'id_product' => 'required|exists:product,id',
            'jumlah_pembelian' => 'required|integer|min:1',
            'atm' => 'required|string',
        ], [
            'id_product.required' => 'Pilih product terlebih dahulu',
            'jumlah_pembelian.required' => 'Jumlah pembelian wajib diisi',
            'jumlah_pembelian.min' => 'Jumlah produk minimal 1',
            'atm.required' => 'Metode pembayaran harus tercantum',
        ]);

        $product = Product::findOrFail($request->id_product);

        if ($product->stok < $request->jumlah_pembelian) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $totalHarga = $product->harga * $request->jumlah_pembelian;


        DB::beginTransaction();
        try {
            $manage_Order = ManageOrder::create([
                'id_product' => $request->id_product,
                'jumlah_pembelian' => $request->jumlah_pembelian,
                'total_harga' => $totalHarga,
                'status_pesanan' => 'lunas',
            ]);


            if (!$manage_Order->id_orders) {
                throw new \Exception('ID pesanan gagal disimpan.');
            }


            Checkout::create([
                'id_orders' => $manage_Order->id_orders,
            'id_cust' => null,
            'atm' => $request->atm,
            'check_in_date' => now(),
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
    public function show(ManageOrder $ManageOrder)
    {
        return view('pages.admin.ManageOrder.show', compact('ManageOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = ManageOrder::find($id);

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
    public function destroy(ManageOrder $ManageOrder)
    {
        $ManageOrder->delete();

        return redirect('/transaksi')->with('success', 'Order berhasil dihapus.');
    }
}
