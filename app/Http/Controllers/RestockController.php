<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Restock;
use Illuminate\Http\Request;

class RestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pencarian
        $query = $request->get('q');
$tanggal = $request->get('tanggal'); // Mengambil input tanggal dari request

$restocks = Restock::with('product')
    ->when($query, function ($queryBuilder) use ($query) {
        return $queryBuilder->whereHas('product', function ($q) use ($query) {
            $q->where('nama_produk', 'like', '%' . $query . '%');
        });
    })
    ->when($tanggal, function ($queryBuilder) use ($tanggal) {
        return $queryBuilder->whereDate('tanggal_pembelian', $tanggal); // Filter berdasarkan tanggal pembelian
    })
    ->get();

        return view('pages.admin.restock.index', compact('restocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();

        // Cek apakah ada produk yang tersedia
        if ($products->isEmpty()) {
            return redirect()->route('restocks.index')->with('error', 'Tidak ada produk yang tersedia. Silakan tambahkan produk terlebih dahulu.');
        }

        return view('pages.admin.restock.add', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_product' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
            'tanggal_pembelian' => 'required|date',
        ]);

        // Menghitung total harga
        $validatedData['total_harga'] = $validatedData['quantity'] * $validatedData['harga_satuan'];

        // Cek apakah produk ada
        $product = Product::find($request->id_product);
        if (!$product) {
            return redirect()->route('restocks.create')->with('error', 'Produk tidak ditemukan. Silakan pilih produk yang valid.');
        }

        $restock = Restock::create($request->all());
        // Mengupdate stok produk
        $product->stok += $request->quantity;
        $product->save();

        return redirect()->route('restocks.index')->with('success', 'Restock berhasil ditambahkan dan stok diperbarui.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Restock $restock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_restock)
    {
        $restock = Restock::findOrFail($id_restock);
        $products = Product::all();
        return view('pages.admin.restock.edit', compact('restock', 'products'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_restock)
    {
        $validatedData = $request->validate([
            'id_product' => 'required|exists:product,id',
            'quantity' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
            'tanggal_pembelian' => 'required|date',
        ]);

        // Update data restock
        $data = Restock::findOrFail($id_restock);
        $data->update($validatedData);

        return redirect()->route('restocks.index')->with('success', 'Data restock berhasil diperbarui.');
    }
}
