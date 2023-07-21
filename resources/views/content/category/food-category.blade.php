@extends('layouts/contentLayoutMaster')

@section('title', 'Categories')

@section('content')
<!-- Basic Tables start -->
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            
            <div class="table-responsive p-5">
                <div class="card-header">
                    <h4 class="card-title"> All Categories</h4>
                    <a href="{{ url('add_food_category') }}" class="btn btn-success btn-sm">Add Food Category</a>
                </div>
                <table class="table table-bordered myTable" id="myTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Images</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($FoodCategory as $FoodCategorys)
                            <tr>
                                <td>{{ $FoodCategorys->food_category_name }}</td>
                                <td><img src="{{asset($FoodCategorys->images)}}" alt="Avatar" height="26" width="26" /></td>
                                <td>
                                    <form method="POST" action="{{ url('deleteFoodCategory', $FoodCategorys->id) }}">
                                        @csrf
                                        <button type="button" data-id="{{$FoodCategorys->id}}" data-food_category_name="{{$FoodCategorys->food_category_name}}" data-image="{{$FoodCategorys->images}}" class="btn btn-primary btn-sm waves-effect editFoodCategory" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                            Edit
                                        </button>
                                        <a href="" class="btn btn-danger btn-sm show_confirm">Delete</a>

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
                <h1 class="text-center mb-1" id="addNewCardTitle">Edit Category</h1>
                <!-- form -->
                <form id="addNewCardValidation" class="row gy-1 gx-2 mt-75" action="{{ url('add_category_to_db') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <input type="hidden" name="id" id="id">
                        <label class="form-label" for="first-name-column">Food Category Name</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="edit-name" class="form-control" placeholder="Food Category Name" name="name" />
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="first-name-column">Food Category Image</label>
                        <div class="input-group input-group-merge">
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Food Category Image" name="image" />
                        </div>
                    </div>

                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body al"><strong>Food Category Name</strong> Field Is Required</div>
                    </div>

                    <div class="mb-1" id="FoodCategoryImage">
                        
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
