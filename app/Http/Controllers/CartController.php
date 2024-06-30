<?php

namespace App\Http\Controllers;

use App\Models\checkout;
use App\Models\manage_order;
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

            // DB::beginTransaction();
            foreach ($selectedItems as $item) {
                if (isset($selectedCart[$item['id']])) {
                    $selectedCart[$item['id']]['quantity'] = $item['quantity'];

                    // Simpan ke tabel manage_order
                    // Simpan ke tabel checkout
                    // $checkout = new checkout();
                    // $checkout->id_orders = $order->id_orders;
                    // $checkout->id_cust = $user->id;
                    // $checkout->atm = 'bri';
                    // $checkout->no_rekening = '634565757';
                    // $checkout->check_in_date = Carbon::now();
                    // $checkout->save();

                }
            }

            $totalPrice = $this->TotalPrice($selectedCart); // Hitung total harga

            foreach ($selectedItems as $item) {
                $order = new manage_order();
                $order->id_cust = Auth::user()->id;
                $order->id_product = $item['id'];
                $order->jumlah_pembelian = $item['quantity'];
                $order->total_harga = $totalPrice;
                $order->status_pesanan = 'belum_bayar';
                $order->save();
            }
            // dd($order);
            // DB::commit();

            // $RekAdmin = '1234567890';
            //     return redirect()->route('cart.success')->with(([
            //     'message' => 'Pesanan Berhasil!! Silahkan Lakukan Pembayaran Ke Nomor rekening Berikut:',
            //     'RekAdmin' => $RekAdmin
            // ]));

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

    // public function checkout(Request $request)
    // {
    //     $cart = session()->get('cart', []);
    //     $totalPrice = $this->TotalPrice($cart);
    //     $user = auth()->user();
    //     // $selectedItems = json_decode($request->input('selected_items', '[]'), true);

    //     // $selectedCart = array_filter($cart, function ($key) use ($selectedItems) {
    //     //     return in_array($key, array_column($selectedItems, 'id'));
    //     // }, ARRAY_FILTER_USE_KEY);

    //     DB::beginTransaction();

    //     $order = manage_order::where('status_pesanan', 'belum bayar');

    //     try {

    //             // $order = new manage_order();
    //             // $order->id_cust = $user->id;
    //             // $order->id_product = $id;
    //             // $order->jumlah_pembelian = $item['quantity'];
    //             // $order->total_harga = $item['harga'] * $item['quantity'];
    //             // $order->status_pesanan = 'belum_bayar';
    //             // $order->save();



    //             $checkout = new checkout();
    //             $checkout->id_orders = $order->id_orders;
    //             $checkout->id_cust = $user->id;
    //             $checkout->atm = 'bri';
    //             $checkout->no_rekening = '634565757';
    //             $checkout->check_in_date = Carbon::now();
    //             $checkout->save();

    //     }catch (\Exception $e) {
    //             // DB::rollBack();
    //             return back()->withError($e->getMessage())->withInput();
    //     }
    // }
    public function success()
    {
        return view('pages.app.Shopping.success');
    }
}
