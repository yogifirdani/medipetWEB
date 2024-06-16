@extends('layouts.app-cust')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
          href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Konsultasi Page</h1>
            </div>
        </section>

        <div class="container mt-5">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <p class="font-weight-bold">
                    {{ session('success') }}
                    </p>
                </div>
            @endif

                <div class="mb-3">
                    <form action="/konsultasi" method="GET" class="d-flex" role="search">
                        @csrf
                        <input class="form-control me-2" type="search" name="search" placeholder="Search Konsultasi" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>

            <form action="/konsultasi" method="POST" class="card mb-3 p-3">
                @csrf
                <div class="mb-2">
                    <label for="content">Tambah Konsultasi:</label>
                    <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success">Tambah Konsultasi</button>
            </form>

                @if(count($konsultasi) > 0)
            @foreach($konsultasi as $konsul)

            <div class="card mb-3">
                <div class="card-body pt-3">
                    <p class="card-text font-weight-bold">{{$konsul->content}}</p>
                    <p class="card-text"><small class="text-muted">{{$konsul->user->name}} - {{$konsul->created_at}}</small></p>
                </div>
                <div class="p-3">
                    <div style="display: flex; justify-content: space-between;">
                        <p class="font-weight-bold">Komentar</p>
                <p style="text-align: right;">Comments ({{count($konsul->comments)}})</p>
                    </div>
                    @foreach($konsul->comments as $comment)

                        <p>{{$comment->content}}</p>
                        <small class="text-muted">{{$konsul->user->name}} - {{$konsul->created_at}}</small>

                    @endforeach
                </div>

                <form action="/konsultasi/{{$konsul->id}}" method="POST" class="pr-3 pl-3 pb-3">
                    @csrf
                            <label for="content">Tambah Komentar:</label>
                    <div class="d-flex mb-2 align-items-start">
                        <div class="flex-grow-1 mr-2">
                            <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Comment</button>
                    </div>
                </form>

            </div>

            @endforeach
                @else
                    <h5 class="text-center">Konsultasi is empty</h5>
                @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
