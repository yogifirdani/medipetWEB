<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('q')) {
            $query->where('nama_supplier', 'like', '%' . $request->q . '%')
                  ->orWhere('alamat', 'like', '%' . $request->q . '%')
                  ->orWhere('kontak', 'like', '%' . $request->q . '%');
        }

        $suppliers = $query->get();
        return view('pages.admin.supplier.index', compact('suppliers'));
    }

    // Menampilkan halaman form tambah supplier
    public function create()
    {
        return view('pages.admin.supplier.add');
    }

    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string',
            'alamat' => 'required',
            'kontak' => 'required|numeric',
            'atm' => 'required',
            'norek' => 'required|numeric',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier tidak ditemukan.');
        }

        return view('pages.admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('suppliers.index')->with('error', 'Supplier tidak ditemukan.');
        }

        $request->validate([
            'nama_supplier' => 'required|string',
            'alamat' => 'required',
            'kontak' => 'required|numeric',
            'atm' => 'required',
            'norek' => 'required|numeric',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    // Menghapus data supplier
    public function destroy($id)
    {
        // Ambil data supplier yang ingin dihapus
        $supplier = Supplier::find($id);

        // Cek apakah supplier ditemukan
        if ($supplier) {
            // Simpan ID yang baru untuk penggunaan berikutnya
            $newSupplierId = Supplier::max('id') + 1;

            // Hapus supplier
            $supplier->delete();

            // Update ID supplier lain untuk menggantikan ID yang dihapus (jika diperlukan)
            Supplier::where('id', '>', $id)
                    ->decrement('id', 1);

            

            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
        }

        return redirect()->route('suppliers.index')->with('error', 'Supplier tidak ditemukan!');
    }
}
