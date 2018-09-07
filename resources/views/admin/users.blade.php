@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Manage Users</h1>
        </div>

        <div class="col-md-12">
            <div class="row">
            @foreach ($users as $user)
                <div class="col-md-4">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        {{ method_field('patch') }}
                        <div class="form-group">
                            <input class="form-control" disabled value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="role_id">
                                <option selected>{{ $user->role->name }}</option>
                                <option value="2">Author</option>
                                <option value="3">Subscriber</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" disabled value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <input class="form-control" disabled value="{{ $user->created_at->diffForHumans() }}">
                        </div>
                        <button class="btn btn-primary btn-xs pull-left col-md-12" type="submit">Update</button>
                        {{ csrf_field() }}
                    </form>

                    <form action="{{ route('users.destroy', $user) }}" method="post">
                        {{ method_field('delete') }}
                        <button type="submit" class="btn btn-danger btn-xs pull-left col-md-12 mt-1 mb-1">Delete</button>
                        {{ csrf_field() }}
                    </form>
                </div>

                @endforeach
            </div>
        </div>
    </div>

@endsection
