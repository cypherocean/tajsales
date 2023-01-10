@extends('admin.layouts.app')

@section('meta')
@endsection

@section('title')
    User View
@endsection

@section('styles')
<link href="{{ asset('backend/assets/css/dropify.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Users</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user') }}" class="text-muted">Users</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">View</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" name="form" id="form" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ??'' }}" disabled>
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Plese enter email" value="{{ $data->email ??'' }}" disabled>
                                <span class="kt-form__help error email"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone" value="{{ $data->phone ??'' }}" disabled>
                                <span class="kt-form__help error phone"></span>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="photo">Profile Image</label>
                                <input type="file" class="dropify" id="photo" data-default-file="{{ $data->photo ??'' }}" name="photo" data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M" disabled>
                                <span class="kt-form__help error photo"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.user') }}" class="btn waves-effect waves-light btn-rounded btn-outline-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('backend/assets/js/dropify.min.js') }}"></script>

<script>
    $(document).ready(function(){
        var drEvent = $('.dropify').dropify();
    });
</script>
@endsection

