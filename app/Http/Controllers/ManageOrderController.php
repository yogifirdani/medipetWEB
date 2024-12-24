<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\DetailOrder;
use App\Models\ManageOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->input('month');
        $year = $request->input('year');
        $kategori = $request->input('kategori');

        $query = ManageOrder::with(['user', 'co', 'detail.product']);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($kategori && $kategori !== 'Semua') {
            $query->whereHas('product', function ($q) use ($kategori) {
                $q->where('kategori', $kategori);
            });
        }

        $orders = $query->get();
        $groupedOrders = $orders->groupBy('id_orders');

        return view('pages.admin.manage_order.index', compact('groupedOrders'));
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
            'nama' => 'required|string',
            'telepon' => 'required|string|min:11|max:13|regex:/^[0-9]+$/',
            'id_product.*' => 'required|exists:product,id',
            'jumlah_pembelian.*' => 'required|integer|min:1',
            'atm' => 'required|string',
            'no_rekening' => 'nullable|min:9|max:15',
        ], [
            'id_product.required' => 'Pilih produk terlebih dahulu',
            'jumlah_pembelian.required' => 'Jumlah pembelian wajib diisi',
            'jumlah_pembelian.min' => 'Jumlah produk minimal 1',
            'atm.required' => 'Metode pembayaran harus tercantum',
        ]);

        DB::beginTransaction();

        try {
            $order = ManageOrder::create([
                'id_cust' => null,
                'nama' => $request->input('nama'),
                'telepon' => $request->input('telepon'),
                'status_pesanan' => 'lunas',
            ]);

            $totalHarga = 0;

            foreach ($request->input('id_product') as $key => $productId) {
                $product = Product::find($productId);
                $jumlah = $request->input('jumlah_pembelian')[$key];
                $harga = $product->harga;

                if ($product->stok >= $jumlah) {
                    $product->stok -= $jumlah;
                    $product->save();

                    DetailOrder::create([
                        'id_orders' => $order->id_orders,
                        'id_product' => $productId,
                        'jumlah_pembelian' => $jumlah,
                        'harga' => $harga,
                    ]);

                    $totalHarga += $jumlah * $harga;
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk tidak cukup untuk pesanan.');
                }
            }

            Checkout::create([
                'id_orders' => $order->id_orders,
                'atm' => $request->input('atm'),
                'no_rekening' => $request->input('no_rekening'),
                'check_in_date' => now(),
            ]);

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Order berhasil dibuat dan stok produk telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
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
