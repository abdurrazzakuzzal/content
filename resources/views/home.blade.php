@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <img src="{{ asset('image/' . $user->avatar) }}" height="100" width="100"
                            style="border-radius: 3px" />
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h1>{{ $user->name }}</h1>
                        <h3>{{ $user->email }}</h3>
                        <a type="button" class="btn btn-info text-white" href="{{ route('edit.profile') }}">Edit Profile</a>
                    </div>
                </div>
                <br>
                <div class="card align-self-center">
                    <div class="card-header">
                        Write Post
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('post.story') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="section"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Section') }}</label>

                                <div class="col-md-8">
                                    <input id="section" type="text"
                                        class="form-control @error('section') is-invalid @enderror" name="section" required
                                        autocomplete="section" autofocus>

                                    @error('section')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tags" class="col-md-2 col-form-label text-md-right">{{ __('Tags') }}</label>

                                <div class="col-md-8">
                                    <input id="tags" type="text" class="form-control @error('tags') is-invalid @enderror"
                                        name="tags" required autocomplete="title" autofocus>

                                    @error('tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="story" class="col-md-2 col-form-label text-md-right">{{ __('Story') }}</label>

                                <div class="col-md-8">
                                    <textarea id="story" class="form-control @error('story') is-invalid @enderror"
                                        name="story" required autocomplete="story" autofocus></textarea>

                                    @error('story')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="images" class="col-md-2 col-form-label text-md-right">{{ __('Images') }}</label>

                                <div class="col-md-8">
                                    <input id="images" type="file"
                                        class="form-control @error('images') is-invalid @enderror" name="images"
                                        autocomplete="images" autofocus>

                                    @error('images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-2 offset-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Post') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                @foreach ($stories as $story)
                    <div class="card align-self-center">
                        <div class="card-header">
                            <p class="card-text">
                                <img src="{{ asset('image/' . $user->avatar) }}" height="50" width="50"
                                    style="border-radius: 3px" />
                                <b class="h3"><strong>{{ $user->name }}</strong></b>
                                <span class="h6 float-right">{{ $story->created_at }}</span>
                                <a type="button" class="btn btn-info text-white float-right"
                                    href="{{ route('edit.story', $story->id) }}">Edit Story</a>
                            </p>
                        </div>
                        <img class="card-img-top" src="{{ asset('image/' . $story->images) }}" alt="Card image cap"
                            height="400" width="100">
                        <div class="card-body">
                            <h5 class="card-title"><b>Title:</b><br> {{ $story->title }}</h5>
                            <p class="card-text"><b>Section:</b><br> {{ $story->section }}</p>
                            <p class="card-text"><b>Story:</b><br> {{ $story->body }}</p>
                            <p class="card-text"><b>Tags:</b><br> {{ $story->tags }}</p>
                            @if ($story->approved == '1')
                                <p class="card-text p-3 mb-2 bg-success text-white">Approved</p>
                                @foreach ($likes as $like)
                                    @if ($like->story_id == $story->id)
                                        <a href="{{ route('like', $story->id) }}"
                                            class="btn btn-primary text-white">{{ $like->likes }} Like</a>
                                            @break
                                    @elseif ($loop->last)
                                        <a href="{{ route('like', $story->id) }}"
                                            class="btn btn-primary text-white">Like</a>
                                    @endif
                                @endforeach
                                <hr />
                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                    data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    View Comments
                                </button>

                                <div class="collapse" id="collapseExample">
                                    @foreach ($comments as $comment)
                                        @if ($story->id == $comment->story_id)
                                            <div class="display-comment" @if ($comment->parent_id != null) style="margin-left:40px;"
                                        @endif>
                                        <p>
                                            <img src="{{ asset('image/' . $story->avatar) }}" height="25" width="25"
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

        @else
            <p class="card-text p-3 mb-2 bg-warning text-dark">Approval Pending</p>
            @endif
        </div>
    </div>
    <br>
    @endforeach

    <br>
    <h3>Shared Stories</h3>
    <hr />
    @foreach ($sharedStories as $story)
        <div class="card align-self-center">
            <div class="card-header">
                <p class="card-text">
                    <img src="{{ asset('image/' . $story->avatar) }}" height="50" width="50" style="border-radius: 3px" />
                    <b class="h3"><strong>{{ $story->name }}</strong></b>
                    <span class="h6 float-right">{{ $story->created_at }}</span>
                </p>
            </div>
            <img class="card-img-top" src="{{ asset('image/' . $story->images) }}" alt="Card image cap" height="400"
                width="100">
            <div class="card-body">
                <h5 class="card-title"><b>Title:</b><br> {{ $story->title }}</h5>
                <p class="card-text"><b>Section:</b><br> {{ $story->section }}</p>
                <p class="card-text"><b>Story:</b><br> {{ $story->body }}</p>
                <p class="card-text"><b>Tags:</b><br> {{ $story->tags }}</p>
                @foreach ($likes as $like)
                    @if ($like->story_id == $story->id)
                        <a href="{{ route('like', $story->id) }}" class="btn btn-primary text-white">{{ $like->likes }}
                            Like</a>
                            @break
                    @elseif ($loop->last)
                        <a href="{{ route('like', $story->id) }}"
                            class="btn btn-primary text-white">Like</a>
                    @endif
                @endforeach
                <hr />
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                    aria-expanded="false" aria-controls="collapseExample">
                    View Comments
                </button>

                <div class="collapse" id="collapseExample">
                    @foreach ($comments as $comment)
                        @if ($story->id == $comment->story_id)
                            <div class="display-comment" @if ($comment->parent_id != null)
                                style="margin-left:40px;"
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
    </div>
    <br>
    @endforeach
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
