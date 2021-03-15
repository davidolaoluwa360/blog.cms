@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Edit Tags
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
            <form method="POST" action="{{route("tags.update", ["tag" => $tag->id])}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{$tag->name}}" id="name" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Update Tag</button>
                </div>
            </form>
        </div>
    </div>
@endsection
