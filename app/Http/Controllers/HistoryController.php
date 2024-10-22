<?php

namespace App\Http\Controllers;

use App\Models\ManageOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $manage_orders = ManageOrder::where('id_cust', $user->id)->get();

        return view('pages.app.history.index', compact('manage_orders', 'user'));
    }
}
