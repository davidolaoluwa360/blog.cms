@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            Trashed Posts
        </div>

        @if($trashed->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($trashed as $trash)
                        <tr>
                            <td><img class="img-fluid" width="100px" height="60px" src="{{asset("storage/".$trash->image)}}" alt="{{$trash->title}}"></td>
                            <td>{{$trash->title}}</td>
                            <td>
                                <a class="btn btn-info btn-sm" href="{{route("posts.restore", ["id" => $trash->id])}}">Restore</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{$trash->id}})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostlabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST">
                    @csrf
                    @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletePostLabel">Delete Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this Post?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <h3 class="text-center">No Post Yet</h3>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id){
            $("#deletePostModal").modal("show");
            const form = document.querySelector(".modal form");
            form.setAttribute("action",`/destroy-posts/${id}`);
        }
    </script>
@endsection
