@extends('layouts/contentLayoutMaster')

@section('title', 'Categories')

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
                            <th>Food Category</th>
                            <th>Food Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Foods as $Food)
                            <tr>
                                <td>{{ $Food->FoodCategory->food_category_name }}</td>
                                <td>{{ $Food->food_name }}</td>
                                <td>
                                    
                                    <form method="POST" action="{{ url('deleteFood', $Food->id) }}">
                                        @csrf
                                        <button type="button" data-id="{{$Food->id}}" data-food_category_name="{{$Food->category_id}}" data-food_name="{{$Food->food_name}}" class="btn btn-primary btn-sm waves-effect editFood" data-bs-toggle="modal" data-bs-target="#addNewCard">
                                            Edit
                                        </button>
                                        <a href="" class="btn btn-danger btn-sm delete_food">Delete</a>

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
                <form id="FoodForm" class="row gy-1 gx-2 mt-75" action="{{ url('add_food_to_db') }}" method="post">
                    @csrf
                    <div class="mb-1">
                        <input type="hidden" name="id" id="id">
                        <label class="form-label" for="first-name-column">Food Category Name</label>
                        <select name="food_category" class="form-control "  id="edit_food_categorys">
                            <option disabled selected value="">Select</option>
                            @foreach($FoodCategorys as $FoodCategory)
                                <option value="{{ $FoodCategory->id }}">{{ $FoodCategory->food_category_name }}</option>
                            @endforeach
                        </select>
                        <div class="alert alert-danger edit_food_category" role="alert">
                            <div class="alert-body"><strong>Food Category Name</strong> Field Is Required</div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="first-name-column">Food Name</label>
                        <input type="text" id="edit_names" class="form-control " placeholder="Food Name" name="name" />
                        <div class="alert alert-danger edit_name" role="alert" >
                            <div class="alert-body"><strong>Food Name</strong> Field Is Required</div>
                        </div>
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
