@extends('admin.layouts.app')

@section('meta')
@endsection

@section('title')
    User Update
@endsection

@section('styles')
<link href="{{ asset('backend/assets/css/dropify.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/css/sweetalert2.bundle.css') }}" rel="stylesheet">
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
                        <li class="breadcrumb-item text-muted active" aria-current="page">Update</li>
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
                    <form action="{{ route('admin.user.update') }}" name="form" id="form" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ??'' }}">
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Plese enter phone" value="{{ $data->phone ??'' }}">
                                <span class="kt-form__help error phone"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Plese enter email" value="{{ $data->email ??'' }}">
                                <span class="kt-form__help error email"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Plese enter password">
                                <span class="text-danger">* Leave blank for not update password</span>
                                <span class="kt-form__help error password"></span>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="photo">Profile Image</label>
                                <input type="file" class="form-control dropify" id="photo" data-default-file="{{ $data->photo ??'' }}" name="photo" data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M">
                                <span class="kt-form__help error photo"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-primary">Submit</button>
                            <a href="{{ route('admin.user') }}" class="btn waves-effect waves-light btn-rounded btn-outline-secondary">Cancel</a>
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
<script src="{{ asset('backend/assets/js/promise.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/sweetalert2.bundle.js') }}"></script>

<script>
    $(document).ready(function(){
        var drEvent = $('.dropify').dropify();

        var dropifyElements = {};
        $('.dropify').each(function () {
            dropifyElements[this.id] = false;
        });

        drEvent.on('dropify.beforeClear', function(event, element){
            id = event.target.id;
            if(!dropifyElements[id]){
                var url = "{!! route('admin.user.profile.remove') !!}";
                <?php if(isset($data) && isset($data->id)){ ?>
                    var id_encoded = "{{ base64_encode($data->id) }}";

                    Swal.fire({
                        title: 'Are you sure want delete this image?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function (result){
                        if (result.value){
                            $.ajax({
                                url: url,
                                type: "POST",
                                data:{
                                    id: id_encoded,
                                    _token: "{{ csrf_token() }}"
                                },
                                dataType: "JSON",
                                success: function (data){
                                    if(data.code == 200){
                                        Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                                        dropifyElements[id] = true;
                                        element.clearElement();
                                    }else{
                                        Swal.fire('', 'Failed to delete', 'error');
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    Swal.fire('', 'Failed to delete', 'error');
                                }
                            });
                        }
                    });

                    return false;
                <?php } else { ?>
                    Swal.fire({
                        title: 'Are you sure want delete this image?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function (result){
                        if (result.value){
                            Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                            dropifyElements[id] = true;
                            element.clearElement();
                        }else{
                            Swal.fire('Cancelled', 'Discard Last Operation.', 'error');
                        }
                    });
                    return false;
                <?php } ?>
            } else {
                dropifyElements[id] = false;
                return true;
            }
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#phone").keypress(function(e){
            var keyCode = e.keyCode || e.which;
            var $this = $(this);
            //Regex for Valid Characters i.e. Numbers.
            var regex = new RegExp("^[0-9\b]+$");

            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            // for 10 digit number only
            if ($this.val().length > 9) {
                e.preventDefault();
                return false;
            }
            if (e.charCode < 54 && e.charCode > 47) {
                if ($this.val().length == 0) {
                    e.preventDefault();
                    return false;
                } else {
                    return true;
                }
            }
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
    });
</script>

<script>
    $(document).ready(function () {
        var form = $('#form');
        $('.kt-form__help').html('');
        form.submit(function(e) {
            $('.help-block').html('');
            $('.m-form__help').html('');
            $.ajax({
                url : form.attr('action'),
                type : form.attr('method'),
                data: new FormData($(this)[0]),
                dataType: 'json',
                async: false,
                processData: false,
                contentType: false,
                success : function(json){
                    return true;
                },
                error: function(json){
                    if(json.status === 422) {
                        e.preventDefault();
                        var errors_ = json.responseJSON;
                        $('.kt-form__help').html('');
                        $.each(errors_.errors, function (key, value) {
                            $('.'+key).html(value);
                        });
                    }
                }
            });
        });
    });
</script>
@endsection

