<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Restock;
use App\Models\Booking;
use App\Models\ManageOrder;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua transaksi
    $transactions = Transaction::with(['category'])->get();

    // Jika ada filter bulan
    if ($request->has('month')) {
        $month = $request->input('month');
        $transactions = $transactions->whereMonth('date', $month);
    }

    // Menghitung saldo akumulasi
    $balance = 0;
    foreach ($transactions as $transaction) {
        $balance += $transaction->income;
        $balance -= $transaction->expense;
        $transaction->balance = $balance; // Menyimpan saldo saat ini di setiap transaksi
    }
    // return $transaction;

    return view('pages.admin.laporan.index', compact('transactions'));
}

public function storeBooking(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email',
        'service_type' => 'required|string',
        'pet_name' => 'required|string',
        'total_price' => 'required|numeric',
        'booking_date' => 'required|date',
    ]);

    // Simpan data booking
    $booking = Booking::create($request->all());

    // Rekam transaksi sebagai pemasukan
    Transaction::create([
        'booking_id' => $booking->id,
        'date' => $booking->booking_date,
        'description' => 'Booking for ' . $booking->pet_name,
        'income' => $booking->total_price,
        'expense' => 0, // Tidak ada pengeluaran
    ]);

    return redirect()->back()->with('success', 'Booking berhasil dibuat!');
}

public function storeRestock(Request $request)
{
    // Validasi input
    $request->validate([
        'id_product' => 'required|integer',
        'quantity' => 'required|integer',
        'harga_satuan' => 'required|numeric',
        'total_harga' => 'required|numeric',
        'tanggal_pembelian' => 'required|date',
    ]);

    // Simpan data restock
    $restock = Restock::create($request->all());

    // Rekam transaksi sebagai pengeluaran
    Transaction::create([
        'restock_id' => $restock->id_restock,
        'date' => $restock->tanggal_pembelian,
        'description' => 'Restock of ' . $restock->nama_produk,
        'income' => 0, // Tidak ada pemasukan
        'expense' => $restock->total_harga,
    ]);

    return redirect()->back()->with('success', 'Restock berhasil dibuat!');
}

public function storeManageOrder(Request $request)
{
    // Validasi input
    $request->validate([
        'id_cust' => 'required|integer',
        'id_product' => 'required|integer',
        'jumlah_pembelian' => 'required|integer',
        'total_harga' => 'required|numeric',
        'status_pesanan' => 'required|string',
    ]);

    // Simpan data manage order
    $manageOrder = ManageOrder::create($request->all());

    // Rekam transaksi sebagai pemasukan
    Transaction::create([
        'manage_order_id' => $manageOrder->id_orders,
        'date' => now(), // Tanggal saat ini
        'description' => 'Order for Product ID ' . $manageOrder->id_product,
        'income' => $manageOrder->total_harga,
        'expense' => 0, // Tidak ada pengeluaran
    ]);

    return redirect()->back()->with('success', 'Order berhasil dibuat!');
}

public function generatePDF(Request $request)
{
    $month = $request->get('month');
    $transactions = Transaction::when($month, function ($query, $month) {
        return $query->whereMonth('date', $month);
    })->get();

    $pdf = PDF::loadView('pages.admin.transactions.pdf', compact('transactions'));
    return $pdf->download('laporan_keuangan.pdf');
}

}
