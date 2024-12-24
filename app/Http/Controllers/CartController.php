<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\DetailOrder;
use App\Models\ManageOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $totalPrice = $this->TotalPrice($cart);

        return view('pages.app.Shopping.index', compact('cart', 'totalPrice'));
    }

    // public function show()
    // {
    //     $cart = session()->get('cart', []);

    //     return view('pages.app.Shopping.index', compact('cart'));
    // }

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
                    'nama_produk' => $product->nama_produk,
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
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');

        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }

        // return view('pages.app.Shopping.index');
    }

    private function TotalPrice($cart)
    {
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['harga'] * $item['quantity'];
        }
        return $totalPrice;
    }

    public function co(Request $request)
    {
        $selectedItems = json_decode($request->input('selected_items', '[]'), true);
        session()->put('selected_items', $selectedItems);
        $cart = session()->get('cart', []);

        $selectedCart = array_filter($cart, function ($key) use ($selectedItems) {
            return in_array($key, array_column($selectedItems, 'id'));
        }, ARRAY_FILTER_USE_KEY);

        foreach ($selectedItems as $item) {
            if (isset($selectedCart[$item['id']])) {
                $selectedCart[$item['id']]['quantity'] = $item['quantity'];
            }
        }

        $totalPrice = $this->TotalPrice($selectedCart);

        return view('pages.app.Shopping.co', compact('selectedCart', 'totalPrice'));
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            $selectedItems = json_decode($request->input('orders', '[]'), true);
            $cart = session()->get('cart', []);

            $selectedCart = array_filter($cart, function ($key) use ($selectedItems) {
                return in_array($key, array_column($selectedItems, 'id'));
            }, ARRAY_FILTER_USE_KEY);

            foreach ($selectedItems as $item) {
                if (isset($selectedCart[$item['id']])) {
                    $selectedCart[$item['id']]['quantity'] = $item['quantity'];
                }
            }

            $manageOrder = ManageOrder::create([
                'id_cust' => Auth::user()->id,
                'nama' => Auth::user()->name,
                'telepon' => Auth::user()->phone,
                'status_pesanan' => 'proses',
            ]);

            foreach ($selectedCart as $item) {
                DetailOrder::create([
                    'id_orders' => $manageOrder->id_orders,
                    'id_product' => $item['id'],
                    'jumlah_pembelian' => $item['quantity'],
                    'harga' => $item['harga'],
                ]);
            }

            Checkout::create([
                'id_orders' => $manageOrder->id_orders,
                'id_cust' => Auth::user()->id,
                'atm' => $request->atm,
                'no_rekening' => $request->no_rekening,
                'check_in_date' => Carbon::now(),
            ]);

            foreach ($selectedCart as $item) {
                $product = Product::find($item['id']);
                if ($product && $product->stok >= $item['quantity']) {
                    $product->stok -= $item['quantity'];
                    $product->save();
                } else {
                    throw new \Exception("Stok tidak mencukupi untuk produk: {$product->nama_produk}");
                }
            }

            session()->forget(['cart', 'selected_items']);

            DB::commit();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function success()
    {
        return view('pages.app.Shopping.success');
    }

}
