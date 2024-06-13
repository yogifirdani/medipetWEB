@extends('layouts.app')

@section('title', 'Comments')

@push('style')
    {{-- CSS Libraries --}}
@endpush

@section('main')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Comments</h1>
            </div>

            <div class="section-body" style="display: flex; flex-wrap: wrap;">
                @foreach ($comments as $comment)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card chat-box" id="mychatbox{{ $loop->index }}">
                            <div class="card-header">
                                <h4>Chat with edan {{ $comment->user->name ?? 'User' }}</h4>
                            </div>
                            <div class="card-body chat-content">
                                <p>{{ $comment->deskripsi }}</p>
                            </div>
                            <div class="card-footer chat-form">
                                <form action="/comments" method="POST">
                                    @csrf
                                    <input type="text" name="deskripsi" class="form-control" placeholder="Type a message">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="far fa-paper-plane"></i>
                                    </button>
                                </form>
                                <form action="{{ url('/comments/' . $comment->id) }}" method="POST" style="margin-top: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Form to add a new comment -->
            <div class="section-footer col-12 col-sm-6 col-lg-4">
                <div class="card chat-box" id="newCommentBox">
                    <div class="card-header">
                        <h4>Add a new comment</h4>
                    </div>
                    <div class="card-body chat-content">
                        <form action="{{ url('/comments') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="id_post">Post ID</label>
                                <input type="text" name="id_post" class="form-control" placeholder="Enter Post ID" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea name="deskripsi" class="form-control" placeholder="Type your comment" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-paper-plane"></i> Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection

@push('scripts')
    {{-- JS Libraries --}}
@endpush
