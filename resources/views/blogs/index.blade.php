@extends('layouts.app')
@include('partials.meta_static')
@section('content')


    <div class="container">
        @if (Session::has('blog_created_message'))
            <div class="alert alert-success">
                {{ Session::get('blog_created_message') }}
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        @endif

        @if (Session::has('contact_form_send'))
            <div class="alert alert-success">
                {{ Session::get('contact_form_send') }}
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        @endif
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('blogs') }}" method="get">
                <div class="form-group">
                    <input type="text" name="term" class="form-control" id="term">
                </div>
                <div class="text-center form-group">
                    <button type="submit" name="button" class="btn btn-primary"> Search </button>
                </div>
            </form>
        </div>
        @foreach($blogs as $blog)
            <div class="col-md-8 offset-md-2 text-center">
                <h2><a href={{ route('blogs.show', [$blog->slug]) }}>{{ $blog->title }}</a></h2>
                <div class="col-md-12">
                    @if($blog->featured_image)
                        <img class="img-responsive featured_image" src="/images/featured_image/{{ $blog->featured_image ? $blog->featured_image : '' }}" alt="{{ str_limit($blog->title, 50) }}" style="width:300px; height:auto;"><br>
                    @endif
                </div>
                <div class="lead">
                    {!! str_limit($blog->body, 200) !!}
                </div>

                @if ($blog->user)
                    Author: <a href="{{ route('users.show', $blog->user->name) }}">{{ $blog->user->name }}</a> | Posted: {{ $blog->created_at->diffForHumans() }}
                @endif
            </div>
            <br><hr><br>
        @endforeach
        <div class="text-center offset-md-2">
            {!! $blogs->links() !!}
        </div>
    </div>

@endsection
