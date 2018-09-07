@extends('layouts.app')
@include('partials.meta_static')
@section('content')


    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Manage Blogs</h1>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h3>Published</h3>
                <hr>
                @foreach($publishedBlogs as $blog)
                    <h2><a href={{ route('blogs.show', $blog->id) }}>{{ $blog->title }}</a></h2>
                    {!! str_limit($blog->body, 100) !!}
                    <form action="{{ route('blogs.update', $blog->id) }}" method="post">
                        {{ method_field('patch') }}
                        <input type="checkbox" name="status" value="0" checked style="display:none">
                        <button class="btn btn-warning btn-xs" type="submit" name="button">Save as Draft</button>

                        {{ csrf_field() }}
                    </form>
                @endforeach
            </div>
            <div class="col-sm-6">
                <h3>Draft</h3>
                <hr>
                @foreach($draftBlogs as $blog)
                    <h2><a href={{ route('blogs.show', $blog->id) }}>{{ $blog->title }}</a></h2>
                    {!! str_limit($blog->body, 100) !!}
                    <form action="{{ route('blogs.update', $blog->id) }}" method="post">
                        {{ method_field('patch') }}
                        <input type="checkbox" name="status" value="1" checked style="display:none">
                        <button class="btn btn-success btn-xs" type="submit" name="button">Publish</button>

                        {{ csrf_field() }}
                    </form>
                @endforeach
            </div>
        </div>

    </div>

@endsection
