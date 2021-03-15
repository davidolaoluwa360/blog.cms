@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route("tags.create")}}" class="btn btn-success">Add Tag</a>
    </div>

    <div class="card card-default">
        <div class="card-header">
            Tags
        </div>

        @if($tags->count() > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Post Count</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{$tag->name}}</td>
                            <td>{{count($tag->posts)}}</td>
                            <td>
                                <a href="{{route("tags.edit", ["tag" => $tag->id])}}" class="btn btn-info btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{$tag->id}})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="deleteTagModal" tabindex="-1" aria-labelledby="deleteTagLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST">
                    @csrf
                    @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteCategoryLabel">Delete Tag</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this tag?
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
            <h3 class="text-center">No Tags Yet</h3>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id){
            $("#deleteTagModal").modal("show");
            const form = document.querySelector(".modal form");
            form.setAttribute("action",`/tags/${id}`);
        }
    </script>
@endsection
