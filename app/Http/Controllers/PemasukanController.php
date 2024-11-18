<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ManageOrder;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use PDF;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $data_type = $request->input('data_type');

        $month = $request->input('month');
        $year = $request->input('year');

        $bookingsQuery = Booking::with('category');
        if ($month) {
            $bookingsQuery->whereMonth('created_at', $month);
        }
        if ($year) {
            $bookingsQuery->whereYear('created_at', $year);
        }
        $bookings = $bookingsQuery->get();

        $ordersQuery = ManageOrder::query();
        if ($month) {
            $ordersQuery->whereMonth('created_at', $month);
        }
        if ($year) {
            $ordersQuery->whereYear('created_at', $year);
        }
        $orders = $ordersQuery->with('product')->get();

        if ($data_type == 'services') {
            // Ambil data layanan dari model
            $bookings = Booking::with('category')->get(); // Pastikan relasi category ada
        } elseif ($data_type == 'products') {
            // Ambil data produk dari model
            $orders = ManageOrder::with('product')->get(); // Pastikan relasi product ada
        }

        return view('pages.admin.laporan.pemasukan', compact('data_type', 'bookings', 'orders'));
    }

    public function generatePDF(Request $request)
    {
        $data_type = $request->input('data_type');

        if ($data_type == 'services') {
            $bookings = Booking::with('category')->get();
            $pdf = PDF::loadView('pages.admin.laporan.pemasukan_services', compact('bookings'));
        } elseif ($data_type == 'products') {
            $orders = ManageOrder::with('product')->get();
            $pdf = PDF::loadView('pages.admin.laporan.pemasukan_products', compact('orders'));
        } else {
            return redirect()->route('pages.admin.laporan.pemasukan')->with('error', 'Silakan pilih jenis data yang ingin dicetak.');
        }

        return $pdf->download('laporan-penjualan.pdf');
    }
}
