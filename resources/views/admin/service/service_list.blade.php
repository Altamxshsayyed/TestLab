@extends('admin.layouts.app')
@section('onPageCss')
<!-- DataTables -->
<style>

</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.bootstrap5.min.css">

@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><span class="text-muted fw-light">Service /</span> Service List</h4>
        <a id={{base64_encode('-1')}} href="add_service/{{base64_encode('-1')}}" class="btn btn-primary">Add Service</a>
    </div>
    <div class="">
        <!-- Category List Table -->
        <div class="ajax-msg mt-1 mb-1"></div>
        <div class="card mb-3">
            <div class="card-header border-bottom">
                <div class="alert alert-success d-flex align-items-center table-msg-alert d-none" id="table-msg" role="alert">
                    <span class="alert-icon text-success me-2">
                        <i class="ti ti-check ti-xs"></i>
                    </span>
                    <p class="alert-heading mb-0" id="table-msg-content"></p>
                </div>
                <h5 class="card-title mb-3">Search Filter</h5>
                <form name="filterData" id="filterData" method="POST">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="" />
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="selectpicker w-100" name="status" data-style="btn-default">
                                <option selected value="">select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary mt-4 submit_filter">Search</button>
                            <a class="btn btn-warning mt-4 reset_filter" href="{{url('service')}}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="service_table" class="table responsive dataTable table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="noExport">Action</th>
                        </tr>
                    </thead>
                    <tbody id="service-sortable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@section('javascript')
<!-- jQuery DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/rowReorder.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{url('public/admin/js/service_list.js?v=0.11')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Service.handleList();
    });
</script>
@endsection
