<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::take(4)->get();
        // dd($products);
        return view('pages.app.cust', compact('products'));
    }

}
