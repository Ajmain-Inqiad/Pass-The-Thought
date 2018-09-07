@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Create new category</h1>
        </div>
        <div class="col-md-12">
            <form action="{{ route('categories.store') }}" method="post">
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" required class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Create Category</button>
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection
