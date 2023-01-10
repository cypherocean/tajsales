@extends('admin.auth.layout.app')

@section('meta')
@endsection

@section('title')
    Error
@endsection

@section('styles')
@endsection

@section('content')
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url({{ asset('backend/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
        <div class="auth-box row">
            <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{ asset('assets/images/big/3.jpg') }});">
            </div>
            <div class="col-lg-5 col-md-7 bg-white">
                <div class="p-3">
                    <div class="text-center">
                        <img src="{{ _logo() }}" alt="{{ _settings('SITE_TITLE') }}">
                    </div>
                    <h2 class="mt-3 text-center">Sign In</h2>
                    <p class="text-center">Enter your email address or phone no. and password to access panel.</p>
                    <form id="form" class="mt-4" action="{{ route('signin') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="text-dark" for="email">Email OR Phone No.</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email Or Phone">
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="text-dark" for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    @error('password')
                                        <div class="invalid-feedback" style="display: block;">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-block btn-dark">Sign In</button>
                            </div>
                            <div class="col-lg-12 text-center mt-2">
                                <a href="{{ route('forgot.password') }}" class="text-danger">Forget Password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection