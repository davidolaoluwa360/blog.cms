@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{route("categories.create")}}" class="btn btn-success">Add Category</a>
    </div>

    <div class="card card-default">
        <div class="card-header">
            Categories
        </div>

        @if($categories->count() > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>Post Count</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{count($category->posts)}}</td>
                            <td>
                                <a href="{{route("categories.edit", ["category" => $category->id])}}" class="btn btn-info btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{$category->id}})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST">
                    @csrf
                    @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteCategoryLabel">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this category?
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
            <h3 class="text-center">No Categories Yet</h3>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function handleDelete(id){
            $("#deleteCategoryModal").modal("show");
            const form = document.querySelector(".modal form");
            form.setAttribute("action",`/categories/${id}`);
        }
    </script>
@endsection
