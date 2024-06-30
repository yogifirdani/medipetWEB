<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Category;

class BookingController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        $serviceTime = $this->extractServiceTime($categories);
        $prices = $this->getPrices($categories);

        return view('pages.app.bookings.create', compact('categories', 'serviceTime', 'prices'));
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'service_type' => 'required|exists:categories,id',
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'take_date' => 'date|nullable',
            'start_time' => 'required',
            'total_price' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $category = Category::findOrFail($request->service_type);
        $data = $request->all();
        $data['total_price'] = $category->price;

        $booking = Booking::create($data);

        return redirect()->route('bookings.show', ['id' => $booking->id])->with('success', 'Booking created successfully.');
    }
}
