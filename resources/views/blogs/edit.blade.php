@extends('layouts.app')

@section('content')

@include('partials.tinymce')
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Edit | {{ $blog->title }}</h1>
        </div>
        <div class="col-md-12">
            <form action="{{ route('blogs.update', $blog->id) }}" method="post" enctype="multipart/form-data">
                @include('partials.error-message')
                {{ method_field('patch') }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title"  class="form-control" value="{{ $blog->title }}">
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <textarea name="body" class="form-control my-editor">{{ $blog->body }}</textarea>
                    {{-- <textarea name="body" class="form-control">{{ $blog->body }}</textarea> --}}
                </div>
                <div class="form-group form-check form-check-inline">
                    {{ $blog->category->count() ? 'Current Categories: ' : '' }} &nbsp;
                    @foreach($blog->category as $category)
                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input" checked>
                    <label class="form-check-label btn-margin-right">{{ $category->name }}</label>
                    @endforeach
                </div>

                <div class="form-group form-check form-check-inline">
                    {{ $filtered->count() ? 'Unused Categories: ' : '' }} &nbsp;
                    @foreach($filtered as $category)
                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input">
                    <label class="form-check-label btn-margin-right">{{ $category->name }}</label>
                    @endforeach
                </div>
                <div class="form-group">
                    <label class="btn btn-default">
                        <span class="btn btn-outline btn-sm btn-info">Featured Image</span>
                        <input class="form-control" type="file" name="featured_image" hidden>
                    </label>
                </div>
                <div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Blog</button>
                </div>

                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
