<?php

namespace App\Http\Controllers;

use App\Models\ManageOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $query = ManageOrder::where('id_cust', $user->id);

    if ($request->has('bulan') && $request->has('tahun')) {
        $query->whereMonth('created_at', $request->bulan)
              ->whereYear('created_at', $request->tahun);
    }

    $manage_orders = $query->get();

    return view('pages.app.history.index', compact('manage_orders', 'user'));
}


    public function show()
    {
        $user = auth()->user();
        $manage_orders = ManageOrder::where('id_cust', $user->id)->get();

        return view('pages.app.history.index', compact('manage_orders', 'user'));
    }
}
