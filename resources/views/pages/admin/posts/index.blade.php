@extends('layouts.app')

@section('title', 'Consultation')

@push('style')
    {{-- CSS Libraries --}}
@endpush

@section('main')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Konsultasi</h1>
            </div>

            <div class="section-body" style="display: flex; align-items: start;">
                @foreach ($posts as $post)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card chat-box card-success" id="mychatbox2">
                            <div class="card-header">
                                <h4><i class="fas fa-circle text-success mr-2" title="Online" data-toggle="tooltip"></i> Chat with Admin</h4>
                            </div>
                            <div class="card-body chat-content">
                                <h5 class="card-title" style="text-align: start">{{ $post['title'] }}</h5>
                                <p class="card-text">{{ $post['deskripsi'] }}</p>
                                <div>
                                    <p>Komen ({{ count($post['comments']) }})</p>
                                    <div>
                                        @foreach ($post['comments'] as $comment)
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 style="font-size: 12px !important; text-align: start">
                                                        {{ $comment['users']['name'] }}</h5>
                                                    <p>{{ $comment['deskripsi'] }}</p>
                                                </div>
                                                <form action="/comments/{{ $comment['id'] }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer chat-form">
                                <form id="chat-form2" action="/comments" method="POST">
                                    @csrf
                                    <input type="text" style="display: none" value="{{ $post['id'] }}" name="id_post" id="id_post">
                                    <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Type a message">
                                    <button type="submit" class="btn btn-primary"><i class="far fa-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
@endpush
