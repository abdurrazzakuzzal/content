@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card align-self-center">
                    <div class="card-header">
                        Edit Post
                        <a href="{{ route('delete.story', $story->id ) }}" class="btn btn-danger float-right">
                            {{ __('Delete') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update.story') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ $story->title }}" required autocomplete="title" autofocus>

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
                                        class="form-control @error('section') is-invalid @enderror" name="section"
                                        value="{{ $story->section }}" required autocomplete="section" autofocus>

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
                                        name="tags" value="{{ $story->tags }}" required autocomplete="title" autofocus>

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
                                        name="story" required autocomplete="story"
                                        autofocus>{{ $story->body }}</textarea>

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
                                        value="{{ old('images') }}" autocomplete="images" autofocus>

                                    @error('images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ $story->id }}" autocomplete="id" autofocus hidden>
                            <div class="form-group row mb-0">
                                <div class="col-md-2 offset-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Done') }}
                                    </button>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
