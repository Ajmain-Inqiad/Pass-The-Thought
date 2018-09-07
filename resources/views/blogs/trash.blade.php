@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="jumbotron">
        <h1>Trashed Blogs</h1>
    </div>
    <div class="col-md-12">
        @foreach($trashedBlogs as $blog)

            <h2>{{ $blog->title }}</h2>
            <div>
                {!! $blog->body !!}
            </div>
            <div class="btn-group">
                <form class="" action="{{ route('blogs.restore', $blog->id) }}" method="get">
                    <button type="submit" name="button" class="btn btn-success btn-xs pull-left btn-margin-right">Restore</button>
                    {{ csrf_field() }}
                </form>
                <form class="" action="{{ route('blogs.permanent-delete', $blog->id) }}" method="post">
                    {{ method_field('delete') }}
                    <button type="submit" name="button" class="btn btn-danger btn-xs pull-left btn-margin-right">Permanent Delete</button>
                    {{ csrf_field() }}
                </form>
            </div>

        @endforeach
    </div>
</div>

@endsection
