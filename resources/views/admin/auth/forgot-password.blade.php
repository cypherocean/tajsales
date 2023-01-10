@extends('admin.auth.layout.app')

@section('meta')
@endsection

@section('title')
    Forget Password
@endsection

@section('styles')
@endsection

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative" style="background:url({{ asset('assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
    <div class="auth-box row">
        <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{ asset('assets/images/big/3.jpg') }});">
        </div>
        <div class="col-lg-5 col-md-7 bg-white">
            <div class="p-3">
                <div class="text-center">
                    <img src="{{ _logo() }}" alt="{{ _settings('SITE_TITLE') }}">
                </div>
                <h2 class="mt-3 text-center">Forgot password</h2>
                <p class="text-center">Enter your email address below and we'll send you password reset instructions.</p>
                <form id="forgot-form"  class="mt-4" action="{{ route('admin.password.forgot') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="text-dark" for="email">Email Address</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off">
                                @error('email')
                                    <div class="invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-block btn-dark">Reset Password</button>
                        </div>
                        <div class="col-lg-12 text-center mt-5">
                            Already have an account? <a href="{{ route('admin.login') }}" class="text-danger">Login</a>
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
