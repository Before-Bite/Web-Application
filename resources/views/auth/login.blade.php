@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')



<div class="auth-wrapper auth-cover" style="background-color: #10163a;">
    <div class="auth-inner row m-0">
        <!-- Brand logo-->
        <a class="brand-logo" href="#">
            <img src="{{ url('public/images/logo/logo.png') }}" style="height: 100px;width: 150px;margin: 0 50px 0 50px;" alt="LOGO" srcset="">
        </a>
        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                @if($configData['theme'] === 'dark')
                    <img class="img-fluid" src="{{asset('images/pages/login-v2-dark.svg')}}" alt="Login V2" />
                @else
                    <img class="img-fluid" src="{{asset('images/pages/login-v2.svg')}}" alt="Login V2" />
                @endif
            </div>
        </div>
        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h2 class="card-title fw-bold mb-1">Welcome to BeforeBite! 👋</h2>
                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                @if(\Session::has('success'))
                    <div class="alert alert-primary">
                        {{\Session::get('success')}}
                    </div>
                @endif
                <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-1">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="text" name="email" placeholder="example@example.com" aria-describedby="email" autofocus="" tabindex="1" />
                    </div>

                    <div class="mb-1">
                        <div class="d-flex justify-content-between">
                        <label class="form-labe">Password</label>
                        <!--<a href="{{url("auth/forgot-password-cover")}}">-->
                        <!--    <small>Forgot Password?</small>-->
                        <!--</a>-->
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="2" />
                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger w-100" tabindex="4">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
@endsection



