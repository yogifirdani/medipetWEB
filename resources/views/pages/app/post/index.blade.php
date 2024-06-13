@extends('layouts.app')

@section('title', 'Posts')

@section('main')
    <section class="section">
        <div class="section-header">
            <h1>Posts</h1>
        </div>

        <div class="section-body">
            @auth
                <div class="card">
                    <div class="card-header">
                        <h4>Add a New Post</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Post title" required>
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea class="form-control" id="body" name="body" placeholder="Post something" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endauth

            @foreach($posts as $post)
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $post->title }}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ $post->body }}</p>
                        <small>Posted by {{ $post->user->name }} {{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="card-footer">
                        <h5>Comments</h5>
                        @foreach($post->comments as $comment)
                            <div class="media">
                                {{-- <img class="mr-3 rounded-circle" width="50" src="{{ asset('img/avatar/avatar-1.png') }}" alt="Avatar"> --}}
                                <div class="media-body">
                                    <h6 class="media-title">{{ $comment->user->name }}</h6>
                                    <p>{{ $comment->body }}</p>
                                </div>
                            </div>
                            <hr>
                        @endforeach

                        @auth
                            <form action="{{ route('posts.comment', $post) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" name="body" placeholder="Add a comment" required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Comment</button>
                                </div>
                            </form>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
