<?php

namespace App\Http\Controllers;

use App\Models\manage_order;
use Illuminate\Http\Request;

class ViewOrderController extends Controller
{
    public function show(manage_order $manage_order)
    {
        $manage_orders = manage_order::all();
        $user = auth()->user();

        return view('pages.app.view.index', compact('manage_order', 'user'));
    }
}
