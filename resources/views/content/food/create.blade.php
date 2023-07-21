@extends('layouts/contentLayoutMaster')

@section('title', 'Add Food')

@section('content')
<!-- Basic Tables start -->
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Food</h4>
                    <a href="{{ url('food') }}" class="btn btn-success btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ url('add_food_to_db') }}" method="post">
                        @csrf
                        <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-column">Food Category Name</label>
                                <select name="food_category" class="form-control"  id="food_category">
                                    <option disabled selected value="">Select</option>
                                    @foreach($FoodCategorys as $FoodCategory)
                                        <option value="{{ $FoodCategory->id }}">{{ $FoodCategory->food_category_name }}</option>
                                    @endforeach
                                </select>
                                @error('food_category')
                                    <div class="alert alert-danger" role="alert">
                                        <div class="alert-body"><strong>Food Category Name</strong> Field Is Required</div>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="first-name-column">Food Name</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Food Name" name="name" />
                                @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        <div class="alert-body"><strong>Food Name</strong> Field Is Required</div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
