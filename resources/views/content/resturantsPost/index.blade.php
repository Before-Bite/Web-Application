@extends('layouts/contentLayoutMaster')

@section('title', 'Posts')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            
            <div class="table-responsive p-5">
                <div class="card-header">
                    <h4 class="card-title">All Foods</h4>
                    <a href="{{ url('add_food') }}" class="btn btn-success btn-sm">Add Foods</a>
                </div>
                <table class="table table-bordered myTable" id="myTable">
                    <thead>
                        <tr>
                            <th>Resturant Name</th>
                            <th>Categories</th>
                            <th>Foods</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($post as $posts)
                            <tr>
                                <td>{{ $posts->restaurant_name }}</td>
                                <td>{{ $posts->food_category }}</td>
                                <td>{{ $posts->food_item }}</td>
                                <td>{{ $posts->rating }}</td>
                                <td>{{ $posts->review }}</td>
                                @if($posts->dish_picture != NULL)
                                    <td><img src="{{asset($posts->dish_picture)}}" alt="Avatar" height="40" width="40" /></td>
                                @else
                                    <td class="text-danger">NO IMAGE</td>
                                @endif 
                                <td>
                                    <form method="POST" action="{{ url('deletePost', $posts->id) }}">
                                        @csrf
                                        <button type="button" data-id="{{$posts->id}}" data-review="{{$posts->review}}" data-dish_picture="{{$posts->dish_picture}}" class="btn btn-primary btn-sm waves-effect editResturantsPost" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                            Edit
                                        </button>
                                        <a href="" class="btn btn-danger btn-sm delete_Post">Delete</a>

                                    </form>   
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Edit Model -->
<div class="modal fade" id="addNewCard" tabindex="-1" aria-labelledby="addNewCardTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">Edit Food</h1>
                <!-- form -->
                <form id="FoodForm" class="row gy-1 gx-2 mt-75" action="{{ url('edit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-1">
                        <input type="hidden" name="id" id="id">
                        <label class="form-label" for="first-name-column">Review</label>
                        <input type="text" id="review" name="review" class="form-control">
                        <div class="alert alert-danger edit_food_category" role="alert">
                            <div class="alert-body"><strong>Food Category Name</strong> Field Is Required</div>
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label" for="first-name-column">Images</label>
                        <input type="file" id="img" name="img" class="form-control">
                    </div>

                    <div class="mb-1" id="ddd">
                        
                    </div>
    
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-1 mt-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal" aria-label="Close">
                        Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Model  -->

@endsection
