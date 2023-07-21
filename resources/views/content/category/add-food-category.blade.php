@extends('layouts/contentLayoutMaster')

@section('title', 'Add Food Categories')

@section('content')
<!-- Basic Tables start -->
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Food Categories</h4>
                    <a href="{{ url('category') }}" class="btn btn-success btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ url('add_category_to_db') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                            <label class="form-label" for="first-name-column">Food Category Name</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Food Category Name" name="name" />
                            @error('name')
                                <div class="alert alert-danger" role="alert">
                                    <div class="alert-body"><strong>Food Category Name</strong> Field Is Required</div>
                                </div>
                            @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-1">
                            <label class="form-label" for="first-name-column">Food Category Image</label>
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" placeholder="Food Category Image" name="image" />
                            @error('image')
                                <div class="alert alert-danger" role="alert">
                                    <div class="alert-body"><strong>Food Category Image</strong> Field Is Required</div>
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
