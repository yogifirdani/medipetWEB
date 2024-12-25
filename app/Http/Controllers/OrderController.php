<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Category;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $prices = $this->getPrices($categories);
        return view('pages.admin.orders.create', compact('categories', 'prices'));
    }

    private function getPrices($categories)
    {
        $prices = [];
        foreach ($categories as $category) {
            $prices[$category->service_category] = $category->price;
        }
        return $prices;
    }

    public function getServiceTime($id)
    {
        $category = Category::with('serviceTimes')->find($id);

        if ($category) {
            $serviceTime = $category->serviceTimes->pluck('service_time'); // Ambil waktu layanan sebagai array
            return response()->json([
                'status' => 'success',
                'serviceTime' => $serviceTime
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Layanan tidak ditemukan.'], 404);
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
            'notes' => 'nullable|string',
        ]);

        // Ambil harga layanan berdasarkan kategori
        $take_date = $request->take_date ? $request->take_date : $request->booking_date;
        $category = Category::findOrFail($request->service_type);
        $pricePerDay = $category->price;

        // Hitung total harga berdasarkan tanggal
        $startDate = new \DateTime($request->booking_date);
        $endDate = $take_date ? new \DateTime($take_date) : clone $startDate;
        $daysDifference = ($endDate->getTimestamp() - $startDate->getTimestamp()) / (60 * 60 * 24) + 1; // Tambahkan +1 untuk minimal 1 hari
        $daysDifference = $daysDifference > 0 ? $daysDifference : 0;
        $totalPrice = $pricePerDay * $daysDifference;

        $data = $request->all();
        $data['total_price'] = $totalPrice;

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
            'name' => 'required|string|max:255',
            'service_type' => 'required|exists:categories,id',
            'pet_type' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'take_date' => 'nullable|date|after_or_equal:booking_date',
            'start_time' => 'required',
            'total_price' => 'required|numeric|min:1',
            'status' => 'nullable|string',
        ]); // di sini ada perubahan

        $booking = Booking::find($id);

        if ($booking->status === 'Selesai') {
            return redirect()->route('orders.index')->with('error', 'Status cannot be changed as it is already marked as Selesai.');
        }

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

    public function generateInvoice($id)
    {
        $booking = Booking::findOrFail($id);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $html = view('pages.admin.orders.invoice', compact('booking'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('invoice_' . $booking->id . '.pdf');
    }
}
