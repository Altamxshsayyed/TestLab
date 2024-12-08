@extends('admin.layouts.app')
@section('onPageCss')
<style>
    .image-preview {
        display: flex;
        margin-top: 5px;
    }

    .icon {
        padding: 8px 15px;
        background: #7367F0;
        color: #fff;
        border-radius: 4px;
        font-size: 15px;
        margin-left: 7px;
        cursor: pointer;
    }

    .clonebtn-remove {
        background: #ea5455;
    }
</style>
@endSection
@php
if(isset($edit) && !empty($edit)){
$title = $edit['title'];
$image = $edit['image'];
$status = $edit['status'];
$detail = json_decode($edit['detail'], true);
}else {
$title = '';
$image = '';
$detail = [];
$status = '';
}
@endphp
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url('admin/service')}}">Service</a>
                </li>
                <li class="breadcrumb-item active">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>

    <form class="form" id="ajax_form" method="POST" route="save_service">
        <div class="row">
            <div class="ajax-msg"></div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Service</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" value="{{$id}}">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ $title }}">
                                <span id="title_err" class="error title_err small" style="color:red;"></span>

                                <div class="mt-3 ajax-field">
                                    <label class="switch switch-success mt-1">
                                        <input type="checkbox" name="status" class="switch-input" {{ $status == true ? 'checked' : '' }} />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"><i class="ti ti-check"></i></span>
                                            <span class="switch-off"><i class="ti ti-x"></i></span>
                                        </span>
                                        <span class="switch-label">Status</span>
                                    </label>
                                    <span id="status_err" class="error status_err small" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 col-md-6 ajax-field">
                                <label for="formFile" class="form-label">Image <span class="text-danger">*</span></label>
                                <input class="form-control" name="" type="file" id="formFile" route="upload_files" />
                                <div class="image-preview mt-1">
                                    @if (isset($image) && !empty($image))
                                    <div class="dz-preview dz-file-preview">
                                        <div class="dz-details">
                                            <div class="dz-thumbnail">
                                                <img data-dz-thumbnail src="{{url('storage/app/uploads/Service/'.$image)}}" class="img-thumbnail" />
                                                <input type="hidden" name="image" value="{{$image}}" />
                                                <div class="dz-success-mark"></div>
                                            </div>
                                            <div class="dz-filename" data-dz-name=""></div>
                                            <a class="dz-remove file-remove-btn" href="javascript:undefined;">Remove file</a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <span id="image_err" class="error image_err small" style="color:red;"></span>
                            </div>
                        </div>
                        <hr>

                        @if (isset($detail) && !empty($detail))
                        @foreach ($detail as $key => $detailVal)
                        <div class="row form-repeat mt-4">
                            <div class="col-md-6">
                                <div class="col-lg-12 mb-3 ajax-field">
                                    <label class="form-label" for="sub_title">Sub Title</label>
                                    <input type="text" class="form-control" id="sub_title" placeholder="Sub Title" name="sub_title[]" value="{{$detailVal['sub_title']}}">
                                </div>
                                <div class="col-lg-12 mb-3 col-md-12 ajax-field">
                                    <label class="form-label" for="bootstrap-maxlength-example2">Description</label>
                                    <textarea id="desc" class="form-control bootstrap-maxlength-example" rows="7" name="description[]">{{$detailVal['description']}}</textarea>
                                    <span id="description_err" class="error description_err small" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="col-md-6 clone-div">
                                @if (isset($detailVal['point']) && !empty($detailVal['point']))
                                @foreach ($detailVal['point'] as $pointKey => $val)
                                <div class="col-lg-12 col-md-12 yt-box mb-3">
                                    <div class="form-group ajax-field">
                                        <label>Point</label>
                                        <div style="display: flex">
                                            <input type="text" class="form-control point" name="point[{{$key}}][]" value="{{$val}}">
                                            @if($pointKey == 0)
                                            <span class="icon clonebtn">+</span>'
                                            @else
                                            <span class="icon clonebtn-remove">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            @if ($key == 0)
                            <div class="mb-3">
                                <div class="btn btn-label-success cloneForm"><i class="ti ti-plus me-1"></i><span class="align-middle">Add</span></div>
                            </div>
                            @else
                            <div class="mb-3">
                                <div class="btn btn-label-danger removeForm"><i class="ti ti-x ti-xs me-1"></i><span class="align-middle">Delete</span></div>
                            </div>
                            @endif
                            <hr>
                        </div>
                        @endforeach
                        @else
                        <div class="row form-repeat mt-4">
                            <div class="col-md-6">
                                <div class="col-lg-12 mb-3 ajax-field">
                                    <label class="form-label" for="sub_title">Sub Title</label>
                                    <input type="text" class="form-control" id="sub_title" placeholder="Sub Title" name="sub_title[]" value="">
                                </div>
                                <div class="col-lg-12 mb-3 col-md-12 ajax-field">
                                    <label class="form-label" for="bootstrap-maxlength-example2">Description</label>
                                    <textarea id="desc" class="form-control bootstrap-maxlength-example" rows="3" name="description[]"></textarea>
                                    <span id="description_err" class="error description_err small" style="color:red;"></span>
                                </div>
                            </div>
                            <div class="col-md-6 clone-div">

                                <div class="col-lg-12 col-md-12 yt-box mb-3">
                                    <div class="form-group ajax-field">
                                        <label>Point</label>
                                        <div style="display: flex">
                                            <input type="text" class="form-control point" name="point[0][]">
                                            <span class="icon clonebtn">+</span>
                                        </div>
                                        <span id="point_err" class="error point_err small" style="color:red;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="btn btn-label-success cloneForm"><i class="ti ti-plus me-1"></i><span class="align-middle">Add</span>
                                </div>
                            </div>
                            <hr>
                        </div>
                        @endif

                        <div class="col-12">
                            <button type="submit" class="btn btn-success submit-button">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
@section('javascript')
<script src="{{url('public/admin/js/service_form.js?v=0.11')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        ServiceForm.handleFormValid();
    });
</script>
@endsection
