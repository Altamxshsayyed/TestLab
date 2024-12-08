<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{URL::to('public/frontend/images/favicon.ico')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.0/dist/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <link href="{{url('public/frontend/css/style.css')}}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @yield('onPageCss')

    <style>

    </style>

</head>

<body>
    <!-- Sidebar-->
    @php
    $active = $active ?? 'dashboard';
    $subactive = $subActive ?? '';
    @endphp
    <!-- <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Student Management</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3 active" href="{{url('/')}}">Students</a>
            </div>
        </div> -->
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/register')}}">Register</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        @yield('content')
        <!-- /.Content -->
    </div>
</body>


</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<!-- <script src="{{url('public/admin/js/custom.js')}}"></script> -->
<script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });


    $(document).ready(function() {
        window.app_base_path = "{{url('/')}}";
        window.asset_url = "{{URL::to('public/frontend/images/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $("#ajax_form").on("submit", function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        var route = $(this).attr("route");

        var fd = new FormData(this);

        $.ajax({
            url: app_base_path + "/" + route,
            type: "POST",
            dataType: "json",
            data: fd,
            processData: false,
            contentType: false,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, "fast");
                    console.log(data);

                    if (data.success === false) {
                        $("#" + form_id)
                            .find(".ajax-msg")
                            .html(
                                '<div class="alert alert-danger d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="fas fa-ban ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                            );
                        $(".ajax-msg").fadeOut(2000, function() {});
                    } else {
                        $("#" + form_id)
                            .find(".ajax-msg")
                            .html(
                                '<div class="alert alert-success d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="fas fa-check ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                            );
                        $(".ajax-msg").fadeOut(2000, function() {
                            window.location.href = data.redirect_url;
                        });
                    }
                } else {
                    printErrorMsg(data.error);
                }
            },
            error: function(err) {
                console.log(err);
            },
        });

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                const keys = key.split(".")[0];
                $("." + keys + "_err").text(value);
            });
        }
    });
</script>

@yield('javascript')
