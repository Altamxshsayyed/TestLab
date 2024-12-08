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
                                <h2 class="h3">Registration</h2>
                                <h3 class="fs-6 fw-normal text-secondary m-0">Enter your details to register</h3>
                            </div>
                        </div>
                    </div>
                    <form class="form" id="ajax_form" method="POST" route="save_register">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="ajax-msg"></div>
                            <div class="col-12 ajax-field">
                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                                <span id="firstname_err" class="error firstname_err small" style="color:red;"></span>
                            </div>
                            <div class="col-12 ajax-field">
                                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                                <span id="lastname_err" class="error lastname_err small" style="color:red;"></span>
                            </div>
                            <div class="col-12 ajax-field">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                                <span id="email_err" class="error email_err small" style="color:red;"></span>
                            </div>
                            <div class="col-12 ajax-field">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="phone" class="form-control" name="phone" id="phone">
                                <span id="phone_err" class="error phone_err small" style="color:red;"></span>
                            </div>
                            <div class="col-12 ajax-field">
                                <label for="profile_img" class="form-label">Profile <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="profile_img" id="profile_img">
                                <span id="profile_img_err" class="error profile_img_err small" style="color:red;"></span>
                            </div>

                            {{-- <div class="col-12 ajax-field">
                                <label class="form-label" for="status">Teacher</label>
                                <select class="selectpicker w-100" name="class_teacher_id" data-style="btn-default">
                                    @if(isset($teachers) && !empty($teachers))
                                    <option selected value="">select</option>
                                    @foreach($teachers as $t)
                                    <option {{ $t['id'] == $teacherId ? 'selected' : '' }} value="{{$t['id']}}">{{$t['teacher_name']}}</option>
                            @endforeach
                            @endif
                            <option value="">Altamash Saayed</option>
                            </select>

                            </select>
                            <span id="class_teacher_id_err" class="error class_teacher_id_err small" style="color:red;"></span>
                        </div> --}}

                        {{-- <div class="col-12 ajax-field">
                            <label class="form-label" for="yearly_fees">Admission Date</label>
                            <input type="text" class="form-control datepicker" id="admission_date" placeholder="Admission date" name="admission_date">
                            <span id="admission_date_err" class="error admission_date_err small" style="color:red;"></span>
                        </div> --}}

                        <div class="col-12 ajax-field">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" value="">
                            <span id="password_err" class="error password_err small" style="color:red;"></span>
                        </div>
                        <div class="col-12 ajax-field">
                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="">
                            <span id="confirm_password_err" class="error confirm_password_err small" style="color:red;"></span>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary" type="submit">Sign up</button>
                            </div>
                        </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-12">
                        <hr class="mt-5 mb-4 border-secondary-subtle">
                        <div class="col-12">
                            <p class="m-0 text-secondary text-center">Already have an account? <a href="{{url('/login')}}" class="link-primary text-decoration-none">Sign in</a></p>
                        </div>
                    </div>
                </div>
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
