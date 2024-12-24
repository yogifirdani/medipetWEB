<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Category;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $prices = $this->getPrices($categories);

        return view('pages.app.bookings.create', compact('categories', 'prices'));
    }

    public function getServiceTime($id)
    {
        $category = Category::with('serviceTimes')->find($id);

        if ($category) {
            $serviceTime = $category->serviceTimes->pluck('service_time');
            return response()->json([
                'status' => 'success',
                'serviceTime' => $serviceTime
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Layanan tidak ditemukan.'], 404);
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
        $booking = Booking::with('category')->findOrFail($id);
        return view('pages.app.bookings.detail', compact('booking'));
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
            'take_date' => 'nullable|date',
            'start_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Tentukan nilai default untuk $take_date
        $take_date = $request->take_date ? $request->take_date : $request->booking_date;

        // Ambil harga layanan berdasarkan kategori
        $category = Category::findOrFail($request->service_type);
        $pricePerDay = $category->price;

        // Hitung total harga berdasarkan tanggal
        $startDate = new \DateTime($request->booking_date);
        $endDate = new \DateTime($take_date);
        $daysDifference = ceil(($endDate->getTimestamp() - $startDate->getTimestamp()) / (60 * 60 * 24));
        $daysDifference = max(1, $daysDifference); // Minimal 1 hari
        $totalPrice = $pricePerDay * $daysDifference;

        // Simpan data ke database
        $data = $request->all();
        $data['total_price'] = $totalPrice;
        $data['user_id'] = Auth::user()->id;
        $data['take_date'] = $take_date;

        // Debugging data
        // dd($data);

        // Simpan data ke tabel bookings
        $booking = Booking::create($data);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Booking created successfully.');
    }


    public function printReceipt($id)
    {
        $booking = Booking::findOrFail($id);
        $category = Category::findOrFail($booking->service_type);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);

        $html = view('pages.app.bookings.receipt', compact('booking', 'category'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('kwitansi_pemesanan ' . $booking->id . '.pdf');
    }
}
