@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('My Profile') }}</div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 alert alert-danger">
                                    <ul class="list-group">
                                        @foreach($errors->all() as $error)
                                            <li class="list-group-item">{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form method="POST" action="{{route("users.update-profile", ["user" => Auth::user()->id])}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{Auth::user()->name}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="about">About Me</label>
                            <textarea name="about" id="about" cols="5" rows="5" class="form-control">{{Auth::user()->about}}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
