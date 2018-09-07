@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Edit category</h1>
        </div>
        <div class="col-md-12">
            <form action="{{ route('categories.update', $category->id) }}" method="post">
                {{ method_field('patch') }}
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" required class="form-control" value="{{ $category->name }}">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update Category</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
