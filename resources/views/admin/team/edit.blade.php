@extends('admin.layouts.app')

@section('meta')
@endsection

@section('title')
Product Edit
@endsection

@section('styles')
<link href="{{ asset('backend/assets/css/dropify.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/css/sweetalert2.bundle.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/css/select2.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/css/select2_bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/extra-libs/prism/prism.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Product</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}" class="text-muted">Product</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Edit</li>
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
                    <form action="{{ route('admin.team.update') }}" name="form" id="form" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="row">
                        <div class="form-group col-sm-12">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Plese enter name" value="{{ $data->name ??'' }}">
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="photo">Image</label>
                                <input type="file" class="form-control dropify" id="photo" name="photo" data-default-file="{{ $data->image ??'' }}" data-allowed-file-extensions="jpg png jpeg" data-max-file-size-preview="2M">
                                <span class="kt-form__help error photo"></span>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="facebook_url">Facebook URL</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="form-control" placeholder="Plese enter Facebook URL" value="{{ $data->facebook_url ??'' }}">
                                <span class="kt-form__help error facebook_url"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="instagram_url">Instagram URL</label>
                                <input type="url" name="instagram_url" id="instagram_url" class="form-control" placeholder="Plese enter Instagram URL" value="{{ $data->instagram_url ??'' }}">
                                <span class="kt-form__help error instagram_url"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="twitter_url">Twitter URL</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="form-control" placeholder="Plese enter Twitter URL" value="{{ $data->twitter_url ??'' }}">
                                <span class="kt-form__help error twitter_url"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="linked_in_url">Linked-in URL</label>
                                <input type="url" name="linked_in_url" id="linked_in_url" class="form-control" placeholder="Plese enter linked-in URL" value="{{ $data->linked_in_url ??'' }}">
                                <span class="kt-form__help error linked_in_url"></span>
                            </div>
                        </div>
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-primary">Submit</button>
                                <a href="{{ route('admin.team.index') }}" class="btn waves-effect waves-light btn-rounded btn-outline-secondary">Cancel</a>
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
<script src="{{ asset('backend/assets/js/select2.js') }}"></script>
<script src="{{ asset('backend/assets/extra-libs/prism/prism.js') }}"></script>
<script src="{{ asset('backend/assets/js/ckeditor.js') }}"></script>

<script>
    $(function() {
        $('#category').select2({
            placeholder: 'Select category',
            allowClear: true,
            theme: "bootstrap",
        });

        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop profile image here or click',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happended.'
            }
        });
      
        var drEvent = $('.dropify').dropify();

        var dropifyElements = {};
        $('.dropify').each(function () {
            dropifyElements[this.id] = false;
        });

        drEvent.on('dropify.beforeClear', function(event, element) {
            id = event.target.id;
            if (!dropifyElements[id]) {
                var url = "{!! route('admin.team.image.remove') !!}";
                <?php if (isset($data) && isset($data->id)) { ?>
                    var id_encoded = "{{ base64_encode($data->id) }}";

                    Swal.fire({
                        title: 'Are you sure want delete this image?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: "POST",
                                data: {
                                    id: id_encoded,
                                    _token: "{{ csrf_token() }}"
                                },
                                dataType: "JSON",
                                success: function(data) {
                                    if (data.code == 200) {
                                        Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                                        dropifyElements[id] = true;
                                        element.clearElement();
                                    } else {
                                        Swal.fire('', 'Failed to delete', 'error');
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
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
                    }).then(function(result) {
                        if (result.value) {
                            Swal.fire('Deleted!', 'Deleted Successfully.', 'success');
                            dropifyElements[id] = true;
                            element.clearElement();
                        } else {
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
    $(function() {
        var form = $('#form');
        $('.kt-form__help').html('');
        form.submit(function(e) {
            $('.help-block').html('');
            $('.m-form__help').html('');
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: new FormData($(this)[0]),
                dataType: 'json',
                async: false,
                processData: false,
                contentType: false,
                success: function(json) {
                    return true;
                },
                error: function(json) {
                    if (json.status === 422) {
                        e.preventDefault();
                        var errors_ = json.responseJSON;
                        $('.kt-form__help').html('');
                        $.each(errors_.errors, function(key, value) {
                            $('.' + key).html(value);
                        });
                    }
                }
            });
        });
    });
</script>
@endsection