@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                   <div class="row d-flex justify-content-center">
                       <div class="col-md-4">
                            <div class="post-count-wrapper p-5 bg-success d-flex justify-content-center align-items-center">
                                <p class="text-light text-center">{{$posts->count()}}</p>
                            </div>
                            <p class="text-center">Total Posts</p>
                       </div>

                       <div class="col-md-4">
                            <div class="category-count-wrapper p-5 bg-success d-flex justify-content-center align-items-center">
                                <p class="text-light text-center">{{$categories->count()}}</p>
                            </div>
                            <p class="text-center">Total Categories</p>
                       </div>

                       <div class="col-md-4">
                            <div class="tag-count-wrapper p-5 bg-success d-flex justify-content-center align-items-center">
                                <p class="text-light text-center">{{$tags->count()}}</p>
                            </div>
                            <p class="text-center">Total Tags</p>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

