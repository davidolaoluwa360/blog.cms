@extends('layouts.app');

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route("posts.create")}}" class="btn btn-success">Add Post</a>
    </div>

    <div class="card card-default">
        <div class="card-header">
            Posts
        </div>

        @if($posts->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                </thead>

                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td><img width="100px" height="60px" class="img-fluid" src="{{asset("storage/".$post->image)}}" alt="{{$post->title}}"></td>
                            <td>{{$post->title}}</td>
                            <td class="text-info">{{$post->categories->toArray()[0]["name"]}}</td>
                            <td>
                                <a href="{{route("posts.edit", ["post" => $post->id])}}" class="btn btn-info btn-sm">Edit</a>
                            </td>
                            <td>
                                <form method="POST" action="{{route("posts.destroy", ["post" => $post->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Trash</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center">No Post Yet</h3>
        @endif
@endsection

