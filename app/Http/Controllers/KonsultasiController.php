<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        if ($searchTerm) {
            $konsultasi = Konsultasi::with(['user', 'comments'])->where('content', 'like', '%' . $searchTerm . '%')->get();
        } else {
            $konsultasi = Konsultasi::with(['user', 'comments'])->get();
        }

        return view('pages.konsultasi.index', compact('konsultasi'));
    }

    public function indexadmin(Request $request)
    {
        $searchTerm = $request->query('search');

        if ($searchTerm) {
            $konsultasi = Konsultasi::with(['user', 'comments'])->where('content', 'like', '%' . $searchTerm . '%')->get();
        } else {
            $konsultasi = Konsultasi::with(['user', 'comments'])->get();
        }

        return view('pages.admin.konsultasi.index', compact('konsultasi'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "content" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Konsultasi::create([
            "user_id" => auth()->id(),
            "content" => $request->content,
        ]);

        return redirect("/konsultasi")->with('success', 'Status posted successfully');
    }

    public function storeadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "content" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Konsultasi::create([
            "user_id" => auth()->id(),
            "content" => $request->content,
        ]);

        return redirect("/konsultasiadmin")->with('success', 'Status posted successfully');
    }

    public function storeComment(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            "content" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Comment::create([
            "konsultasi_id" => $id,
            "user_id" => auth()->id(),
            "content" => $request->content
        ]);

        return redirect("/konsultasiadmin")->with('success', 'Status posted comment successfully');
    }

    public function storeCommentadmin(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            "content" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Comment::create([
            "konsultasi_id" => $id,
            "user_id" => auth()->id(),
            "content" => $request->content
        ]);

        return redirect("/konsultasiadmin")->with('success', 'Status posted comment successfully');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('search');
        $konsultasi = Konsultasi::with(['user', 'comments'])->where('content', 'like', '%' . $searchTerm . '%')->get();

        return view('pages.konsultasi.index', compact('konsultasi'));
    }
}
