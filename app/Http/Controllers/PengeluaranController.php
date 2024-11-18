<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Restock;
use Illuminate\Http\Request;
use PDF; // Import the PDF facade

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $pengeluarans = Pengeluaran::all();
        $restocks = Restock::with('product')->get();

        return view('pages.admin.laporan.pengeluaran', compact('pengeluarans', 'restocks'));
    }

    public function generatePDF(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $restocks = Restock::with('product');
        if ($month) {
            $restocks->whereMonth('tanggal_pembelian', $month);
        }

        if ($year) {
            $restocks->whereYear('tanggal_pembelian', $year);
        }

        $restocks = $restocks->get();

        $pdf = PDF::loadView('pages.admin.laporan.pengeluaran_pdf', compact('restocks', 'month', 'year'));

        return $pdf->download('laporan-pembelian.pdf');
    }
}
