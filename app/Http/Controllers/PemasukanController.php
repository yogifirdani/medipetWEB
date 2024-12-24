<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Product;
use App\Models\ManageOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Ambil data penjualan produk berdasarkan bulan dan tahun
        $ordersQuery = DetailOrder::with('product')
            ->select('id_product', DB::raw('SUM(jumlah_pembelian) as total_quantity'), DB::raw('SUM(harga) as total_revenue'))
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('created_at', $month);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })
            ->groupBy('id_product'); // Group by product ID

        $productOrders = $ordersQuery->get();

        // Hitung total pendapatan
        $totalRevenue = $productOrders->sum('total_revenue');

        // Ambil data layanan berdasarkan bulan dan tahun
        $bookingsQuery = Booking::with('category')
            ->select('service_type', DB::raw('COUNT(*) as total_bookings'))
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('booking_date', $month);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('booking_date', $year);
            })
            ->groupBy('service_type');

        $serviceBookings = $bookingsQuery->get();

        // Ambil produk yang belum terjual
        $allProducts = Product::all();
        $soldProductIds = $productOrders->pluck('id_product')->toArray();
        $unsoldProducts = $allProducts->whereNotIn('id', $soldProductIds);

        // Ambil layanan yang belum terjual
        $allServices = Category::all();
        $soldServiceIds = $serviceBookings->pluck('service_type')->toArray();
        $unsoldServices = $allServices->whereNotIn('id', $soldServiceIds);

        return view('pages.admin.laporan.pemasukan', compact('productOrders', 'serviceBookings', 'totalRevenue', 'unsoldProducts', 'unsoldServices', 'month', 'year'));
    }


    public function generatePDF(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        // Ambil data penjualan produk
        $ordersQuery = DetailOrder::with('product')
            ->select('id_product', DB::raw('SUM(jumlah_pembelian) as total_quantity'), DB::raw('SUM(harga) as total_revenue'))
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('created_at', $month);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })
            ->groupBy('id_product');

        $productOrders = $ordersQuery->get();

        // Hitung total pendapatan
        $totalRevenue = $productOrders->sum('total_revenue');

        // Hitung total pembelian produk
        $totalProductPurchases = $productOrders->sum('total_quantity');

        // Ambil data layanan
        $bookingsQuery = Booking::with('category')
            ->select('service_type', DB::raw('COUNT(*) as total_bookings'), DB::raw('SUM(total_price) as total_revenue')) // Pastikan ada kolom price di Booking
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('booking_date', $month);
            })
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('booking_date', $year);
            })
            ->groupBy('service_type');

        $serviceBookings = $bookingsQuery->get();

        // Hitung total pendapatan layanan
        $totalServiceRevenue = $serviceBookings->sum('total_revenue');

        // Hitung total pembelian layanan
        $totalServicePurchases = $serviceBookings->sum('total_bookings');

        // Total pendapatan dan total pembelian
        $totalRevenue += $totalServiceRevenue;
        $totalPurchases = $totalProductPurchases + $totalServicePurchases;

        // Ambil produk yang belum terjual
        $allProducts = Product::all();
        $soldProductIds = $productOrders->pluck('id_product')->toArray();
        $unsoldProducts = $allProducts->whereNotIn('id', $soldProductIds);

        // Ambil layanan yang belum terjual
        $allServices = Category::all();
        $soldServiceIds = $serviceBookings->pluck('service_type')->toArray();
        $unsoldServices = $allServices->whereNotIn('id', $soldServiceIds);

        // Generate PDF
        $pdf = PDF::loadView('pages.admin.laporan.pemasukan_pdf', compact('productOrders', 'serviceBookings', 'totalRevenue', 'totalPurchases', 'unsoldProducts', 'unsoldServices', 'month', 'year'));
        return $pdf->download('laporan_pemasukan.pdf');
    }
}
