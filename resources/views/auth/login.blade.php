@extends('layouts.default')
@section('content')
@include('elements.top-css')

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="auth-wrapper auth-basic px-2">
                        <div class="auth-inner my-2">
                            <!-- Login basic -->
                            <div class="card mb-0">
                                <div class="card-body">
                                    <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-1">
                                            <label for="email" class="form-label">Email</label> <span class="text-danger"> *</span>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="john@example.com" aria-describedby="email" tabindex="1" autofocus />
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-1">
                                            <!-- <div class="d-flex justify-content-start"> -->
                                            <label class="form-label" for="password">Password </label> <span class="text-danger">*</span>
                                            <span class="text-danger"></span>

                                            <!-- <a href="{{ route('password.request') }}">
                                            <small>Forgot Password?</small>
                                            </a> -->
                                            <!-- </div> -->
                                            <div class="input-group input-group-merge form-password-toggle">
                                                <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                                <span class="input-group-text cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg></span>
                                            </div>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- <div class="mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                                            </div>
                                        </div> -->
                                        <button type="submit" class="btn btn-warning w-100" tabindex="4">Sign
                                            in</button>
                                    </form>
                                    <!-- <p class="text-center mt-2">
                                        <span>New on our platform?</span>
                                        <a href="{{route('register')}}">
                                            <span>Create an account</span>
                                        </a>
                                    </p> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</body>
@include('elements.bottom-js')