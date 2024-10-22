<?php

namespace App\Http\Controllers;

use App\Models\checkout;
use App\Models\manage_order;
use App\Models\ManageOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $totalPrice = $this->TotalPrice($cart);

        return view('pages.app.Shopping.index', compact('cart', 'totalPrice'));
    }

    public function show()
    {
        $cart = session()->get('cart', []);

        return view('pages.app.Shopping.index', compact('cart'));
    }

    public function addtocart(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'id' => $product->id,
                    'image' => $product->image,
                    'nama' => $product->nama,
                    'harga' => $product->harga,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }

            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function removeitem($id)
    {
        $cart = session()->get('cart', []);

        try {
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        return view('pages.app.Shopping.index');
    }

    public function checkout(Request $request)
    {
        try {
            $selectedItems = json_decode($request->input('selected_items', '[]'), true);
            $cart = session()->get('cart', []);

            // Filter dan hitung total harga dari item yang dipilih
            $selectedCart = array_filter($cart, function ($key) use ($selectedItems) {
                return in_array($key, array_column($selectedItems, 'id'));
            }, ARRAY_FILTER_USE_KEY);

            foreach ($selectedItems as $item) {
                if (isset($selectedCart[$item['id']])) {
                    $selectedCart[$item['id']]['quantity'] = $item['quantity'];
                }
            }

            $totalPrice = $this->TotalPrice($selectedCart);

            foreach ($selectedItems as $item) {
                $order = new ManageOrder();
                $order->id_cust = Auth::user()->id;
                $order->id_product = $item['id'];
                $order->jumlah_pembelian = $item['quantity'];
                $order->total_harga = $totalPrice;
                $order->status_pesanan = 'proses';
                $order->save();
            }

            // $co= new Checkout();
            // $co->atm = $request->atm;
            // $co->no_rekening = $request->no_rekening;
            // $co->save();

            // dd($order);

            return view('pages.app.Shopping.co', compact('selectedCart', 'totalPrice'));
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    private function TotalPrice($cart)
    {
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['harga'] * $item['quantity'];
        }
        return $totalPrice;
    }

    public function pembelian(Request $request)
    {
        $request->validate([
            'atm' => 'required',
            'no_rekening' => 'required'
        ]);

        $cart = session()->get('cart', []);
        $orders = json_decode($request->orders, true);

        // dd($request->all());

        foreach ($orders as $order) {
            Checkout::create([
                'id_orders' => $order['id'],
                'id_cust' => Auth::user()->id,
                'atm' => $request->atm,
                'no_rekening' => $request->no_rekening,
                'check_in_date' => Carbon::now()
            ]);

            $products = Product::find($order['id']);
            if ($products) {
                $products->stok -= $order['quantity'];
                $products->save();
            }

            if (isset($cart[$order['id']])) {
                unset($cart[$order['id']]);
            }
        }
        session()->put('cart', $cart);
        return view('pages.app.Shopping.success');
    }

    public function success()
    {
        return view('pages.app.Shopping.success');
    }
}
