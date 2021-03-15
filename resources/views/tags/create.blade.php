@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Create Tags
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach($errors->all() as $error)
                        <li class="list-group-item text-danger">{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <form method="POST" action="{{route("tags.store")}}">
                @csrf
                @method('post')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Add Tag</button>
                </div>
            </form>
        </div>
    </div>
@endsection
