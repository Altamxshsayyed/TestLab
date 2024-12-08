@extends('frontend.layouts.app')

@section('onPageCss')

<style>
    .bootstrap-select .dropdown-toggle {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        box-shadow: none !important;
        padding: 0.375rem 0.75rem !important;
    }

    .bootstrap-select .dropdown-menu {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
</style>

@endsection

@section('content')
<!-- Registration 2 - Bootstrap Brain Component -->
<div class="py-3 py-md-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-5">
                                <h2 class="h3">Login</h2>
                                <h3 class="fs-6 fw-normal text-secondary m-0">Enter your details to login</h3>
                            </div>
                        </div>
                    </div>

                    <form class="form" id="ajax_form" method="POST" route="verify_login">
                        <!-- Email input -->

                        <div class="ajax-msg"></div>

                        <div class="col-12 ajax-field mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                            <span id="email_err" class="error email_err small" style="color:red;"></span>
                        </div>

                        <!-- Password input -->
                        <div class="col-12 ajax-field mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" value="">
                            <span id="password_err" class="error password_err small" style="color:red;"></span>
                        </div>

                        <!-- 2 column grid layout for inline styling -->

                        <!-- Submit button -->
                        <div class="col-12 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary" type="submit">Sign In</button>
                            </div>
                        </div>

                        <!-- Register buttons -->
                        <div class="text-center">
                            <p>Not a member? <a href="{{url('/register')}}">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection

@section('javascript')
<script>
    $(document).ready(function() {
        flatpickr(".datepicker", {
            dateFormat: "d/m/Y",
        });
    });
</script>
@endSection
