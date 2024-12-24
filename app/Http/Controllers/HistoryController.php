<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\ManageOrder;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->get('filter');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $data = collect();

        if ($filter === 'layanan') {
            $query = Booking::where('user_id', $user->id);

            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            }
            if ($tahun) {
                $query->whereYear('created_at', $tahun);
            }

            $data = $query->get();
        } elseif ($filter === 'produk') {
            $query = ManageOrder::with(['co', 'detail.product'])
                ->where('id_cust', $user->id);

            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            }
            if ($tahun) {
                $query->whereYear('created_at', $tahun);
            }

            $data = $query->get()->groupBy('id_orders');
        } else {
            $layanan = Booking::where('user_id', $user->id);
            $produk = ManageOrder::with(['detail.product', 'co'])
                ->where('id_cust', $user->id);

            if ($bulan) {
                $layanan->whereMonth('created_at', $bulan);
                $produk->whereMonth('created_at', $bulan);
            }
            if ($tahun) {
                $layanan->whereYear('created_at', $tahun);
                $produk->whereYear('created_at', $tahun);
            }

            $data = collect()
                ->merge($layanan->get())
                ->merge($produk->get());
        }

        return view('pages.app.history.index', compact('data', 'filter', 'user'));
    }

    public function nota($id)
    {
        try {
            $user = auth()->user();

            $order = ManageOrder::with(['detail.product', 'co'])->where('id_orders', $id)->firstOrFail();

            if (!$order->co) {
                throw new \Exception('Checkout data not found for this order.');
            }

            return view('pages.app.history.invoice', compact('user', 'order'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function kwitansi($id)
    {
        $booking = Booking::with('category')->findOrFail($id);

        return view('pages.app.bookings.detail', compact('booking'));
    }

    public function printReceipt($id)
    {
        $booking = Booking::findOrFail($id);
        $category = Category::findOrFail($booking->service_type);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $html = view('pages.app.bookings.receipt', compact('booking', 'category'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('kwitansi_pemesanan_' . $booking->id . '.pdf');
    }

}
