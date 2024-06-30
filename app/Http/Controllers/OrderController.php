<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Category;

class OrderController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return view('pages.admin.orders.index', compact('bookings'));
    }

    public function create()
    {
        $categories = Category::all();
        $serviceTime = $this->extractServiceTime($categories);
        $prices = $this->getPrices($categories);
        return view('pages.admin.orders.create', compact('categories', 'serviceTime', 'prices'));
    }

    private function extractServiceTime($categories)
    {
        $serviceTime = [];
        foreach ($categories as $category) {
            if ($category->service_time) {
                $time = json_decode(stripslashes($category->service_time), true);
                if (is_array($time)) {
                    foreach ($time as $time) {
                        $cleanTime = trim($time);
                        if (!empty($cleanTime) && !in_array($cleanTime, $serviceTime)) {
                            $serviceTime[] = $cleanTime;
                        }
                    }
                }
            }
        }
        sort($serviceTime);
        return $serviceTime;
    }

    private function getPrices($categories)
    {
        $prices = [];
        foreach ($categories as $category) {
            $prices[$category->service_category] = $category->price;
        }
        return $prices;
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $category = Category::findOrFail($booking->service_type);
        return view('pages.app.bookings.detail', compact('booking', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'service_type' => 'required',
            'pet_name' => 'required',
            'pet_type' => 'required',
            'booking_date' => 'required|date',
            'take_date' => 'date|nullable',
            'start_time' => 'required',
            'status' => 'required',
            'notes' => 'nullable',
        ]);

        $booking = new Booking();

        $booking->name = $request->input('name');
        $booking->phone = $request->input('phone');
        $booking->email = $request->input('email');
        $booking->service_type = $request->input('service_type');
        $booking->pet_name = $request->input('pet_name');
        $booking->pet_type = $request->input('pet_type');
        $booking->booking_date = $request->input('booking_date');
        $booking->take_date = $request->input('take_date');
        $booking->start_time = $request->input('start_time');
        $booking->status = $request->input('status');
        $booking->notes = $request->input('notes');

        $category = Category::findOrFail($request->service_type);
        $data = $request->all();
        $data['total_price'] = $category->price;

        $booking = Booking::create($data);

        return redirect()->route('orders.index')->with('success', 'Booking created successfully.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $categories = Category::all();
        return view('pages.admin.orders.edit', compact('booking', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'service_type' => 'required',
            'pet_type' => 'required',
            'booking_date' => 'required|date',
            'take_date' => 'date|nullable',
            'start_time' => 'required',
            'total_price' => 'required',
            'status' => 'required',
        ]);

        $booking = Booking::find($id);

        $booking->name = $request->input('name');
        $booking->service_type = $request->input('service_type');
        $booking->pet_type = $request->input('pet_type');
        $booking->booking_date = $request->input('booking_date');
        $booking->take_date = $request->input('take_date');
        $booking->start_time = $request->input('start_time');
        $booking->total_price = $request->input('total_price');
        $booking->status = $request->input('status');

        $booking->save();

        return redirect()->route('orders.index')->with('success', 'Booking updated successfully!');
    }
}
