<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\manage_order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::where('role_id', 2)->count();
        $totalProducts = Product::count();
        $totalLayanan = Booking::count();
        $totalOrders = manage_order::count();

        $user = Auth::user()->name;
        return view('pages.admin.dashboard');
    }
}
