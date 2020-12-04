@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @auth
                    @if (Auth::user()->id == '1')
                        @foreach ($stories as $story)
                            <div class="card align-self-center">
                                <div class="card-header">
                                    <p class="card-text">
                                        <img src="{{ asset('image/' . $story->avatar) }}" height="50" width="50"
                                            style="border-radius: 3px" />
                                        <b class="h3"><strong>{{ $story->name }}</strong></b>
                                        <span class="h6 float-right">{{ $story->created_at }}</span>
                                    </p>
                                </div>
                                <img class="card-img-top" src="{{ asset('image/' . $story->images) }}" alt="Card image cap"
                                    height="100" width="100">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Title:</b><br> {{ $story->title }}</h5>
                                    <p class="card-text"><b>Section:</b><br> {{ $story->section }}</p>
                                    <p class="card-text"><b>Story:</b><br> {{ $story->body }}</p>
                                    <p class="card-text"><b>Tags:</b><br> {{ $story->tags }}</p>
                                    @if ($story->approved == '1')
                                        <a class="btn btn-success text-white"
                                            href="{{ route('unapprove.story', $story->id) }}">Unapprove</a>
                                    @else
                                        <a class="btn btn-primary" href="{{ route('approve.story', $story->id) }}">Approve</a>
                                    @endif
                                </div>
                            </div>
                            <br>
                        @endforeach
                    @else
                        @foreach ($stories as $story)
                            @if ($story->approved == '1')
                                <div class="card align-self-center">
                                    <div class="card-header">
                                        <p class="card-text">
                                            <img src="{{ asset('image/' . $story->avatar) }}" height="50" width="50"
                                                style="border-radius: 3px" />
                                            <b class="h3"><strong>{{ $story->name }}</strong></b>
                                            <span class="h6 float-right">{{ $story->created_at }}</span>
                                        </p>
                                    </div>
                                    <img class="card-img-top" src="{{ asset('image/' . $story->images) }}" alt="Card image cap"
                                        height="400">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Title:</b><br> {{ $story->title }}</h5>
                                        <p class="card-text"><b>Section:</b><br> {{ $story->section }}</p>
                                        <p class="card-text"><b>Story:</b><br> {{ $story->body }}</p>
                                        <p class="card-text"><b>Tags:</b><br> {{ $story->tags }}</p>
                                        @foreach ($likes as $like)
                                            @if ($like->story_id == $story->id)
                                                <a href="{{ route('like', $story->id) }}"
                                                    class="btn btn-primary text-white">{{ $like->likes }}
                                                    Like</a>
                                                @break
                                            @elseif ($loop->last)
                                                <a href="{{ route('like', $story->id) }}"
                                                    class="btn btn-primary text-white">Like</a>
                                            @endif
                                        @endforeach
                                        <a href="{{ route('share.story', $story->id) }}"
                                            class="btn btn-primary text-white">Share</a>
                                        <hr />
                                        @foreach ($comments as $comment)
                                            @if ($story->id == $comment->story_id)
                                                <div class="display-comment" @if ($comment->parent_id != null) style="margin-left:40px;"
                                            @endif>
                                            <p>
                                                <img src="{{ asset('image/' . $comment->avatar) }}" height="25" width="25"
                                                    style="border-radius: 3px" />
                                                <strong>{{ $comment->name }}</strong>
                                                {{ $comment->body }}
                                            </p>
                                            <a href="" id="reply"></a>
                                            <form method="post" action="{{ route('comments.store') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" name="body" class="form-control" />
                                                    <input type="hidden" name="story_id" value="{{ $story->id }}" />
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                                </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-warning" value="Reply" />
                                                </div>
                                            </form>
                                            @if ($comment->id == $comment->parent_id)
                                                <strong>{{ $comment->name }}</strong>
                                                <p>{{ $comment->body }}</p>
                                            @endif
                                    </div>
                            @endif
                        @endforeach
                        <form method="post" action="{{ route('comments.store') }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="body"></textarea>
                                <input type="hidden" name="story_id" value="{{ $story->id }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Add Comment" />
                            </div>
                        </form>
                </div>
            </div>
            <br>
            @endif
            @endforeach
            @endif
        @else
            @foreach ($stories as $story)
                @if ($story->approved == '1')
                    <div class="card align-self-center">
                        <div class="card-header">
                            <p class="card-text">
                                <img src="{{ asset('image/' . $story->avatar) }}" height="50" width="50"
                                    style="border-radius: 3px" />
                                <b class="h3"><strong>{{ $story->name }}</strong></b>
                                <span class="h6 float-right">{{ $story->created_at }}</span>
                            </p>
                        </div>
                        <img class="card-img-top" src="{{ asset('image/' . $story->images) }}" alt="Card image cap"
                            height="300">
                        <div class="card-body">
                            <h5 class="card-title"><b>Title:</b><br> {{ $story->title }}</h5>
                            <p class="card-text"><b>Section:</b><br> {{ $story->section }}</p>
                            <p class="card-text"><b>Story:</b><br> {{ $story->body }}</p>
                            <p class="card-text"><b>Tags:</b><br> {{ $story->tags }}</p>
                            @foreach ($likes as $like)
                                @if ($like->story_id == $story->id)
                                    <a class="btn btn-primary text-white">{{ $like->likes }} Like</i></a>
                                    @break
                                @elseif ($loop->last)
                                    <a class="btn btn-primary text-white">Like</a>
                                @endif
                            @endforeach
                            <a class="btn btn-primary text-white">Share</a>
                            <hr />
                            @foreach ($comments as $comment)
                                @if ($story->id == $comment->story_id)
                                    <div class="display-comment" @if ($comment->parent_id != null) style="margin-left:40px;"
                                @endif>
                                <p>
                                    <img src="{{ asset('image/' . $comment->avatar) }}" height="25" width="25"
                                        style="border-radius: 3px" />
                                    <strong>{{ $comment->name }}</strong>
                                    {{ $comment->body }}
                                </p>
                                @if ($comment->id == $comment->parent_id)
                                    <strong>{{ $comment->name }}</strong>
                                    <p>{{ $comment->body }}</p>
                                @endif
                        </div>
                @endif
            @endforeach
        </div>
        </div>
        <br>
        @endif
        @endforeach
    @endauth
    </div>
    </div>
    </div>
@endsection

<script>
    var msg = '{{ Session::get('
    alert ') }}';
    var exist = '{{ Session::has('
    alert ') }}';
    if (exist) {
        alert(msg);
    }

</script>
