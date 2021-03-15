@extends('layouts.app');

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="" class="btn btn-success">Add User</a>
    </div>

    <div class="card card-default">
        <div class="card-header">
            Users
        </div>

        @if($users->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><img width="40px" height="40px" style="border-radius:90px" src="{{Gravatar::src($user->email)}}" alt="{{$user->email}}"/></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            @if(!$user->isAdmin())
                                <form action="{{route("users.admin", ["user" => $user->id])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">Make Admin</button>
                                    </td>
                                </form>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center">No User Yet</h3>
        @endif
@endsection

