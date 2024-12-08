// delete record ajax
$(document).on("click", ".delete_record", function (e) {
    e.preventDefault();
    var id = $(this).attr("id");
    var route = $(this).attr("route");
    var tabel_id = $(this).attr("table_id");
    if (id != " ") {
        bootbox.confirm({
            message: "Are you sure you want to delete it?",
            size: "small",
            buttons: {
                confirm: {
                    label: "Yes",
                    className: "btn-success bg-glow",
                },
                cancel: {
                    label: "No",
                    className: "btn-danger bg-glow",
                },
            },
            callback: function (result) {
                if (result == 1) {
                    $.ajax({
                        type: "GET",
                        url: route + "/" + id,
                        success: function (result) {
                            $("#table-msg-content").html(
                                "Record deleted successfully"
                            );
                            $(".table-msg-alert").removeClass("d-none");
                            setTimeout(function () {
                                $(".table-msg-alert").addClass("d-none");
                            }, 2000);
                            scrollTo($(".table-msg-alert"), -200);
                            ajax_table.ajax.reload();
                        },
                    });
                }
            },
        });
    }
});

// Submit normal form start
$("#ajax_form").on("submit", function (e) {
    e.preventDefault();

    var form_id = $(this).attr("id");
    var route = $(this).attr("route");

    var fd = new FormData(this);

    $.ajax({
        url: app_base_path_admin + "/" + route,
        type: "POST",
        dataType: "json",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            if ($.isEmptyObject(data.error)) {
                $("html, body").animate({ scrollTop: 0 }, "fast");
                console.log(data);

                if (data.success === false) {
                    $("#" + form_id)
                        .find(".ajax-msg")
                        .html(
                            '<div class="alert alert-danger d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="ti ti-ban ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                        );
                    $(".ajax-msg").fadeOut(2000, function () {});
                } else {
                    $("#" + form_id)
                        .find(".ajax-msg")
                        .html(
                            '<div class="alert alert-success d-flex align-items-center" role="alert"><span class="alert-icon text-success me-2"><i class="ti ti-check ti-xs"></i></span>' +
                                data.msg +
                                "</div>"
                        );
                    $(".ajax-msg").fadeOut(2000, function () {
                        window.location.href = data.redirect_url;
                    });
                }
            } else {
                printErrorMsg(data.error);
            }
        },
        error: function (err) {
            console.log(err);
        },
    });

    function printErrorMsg(msg) {
        $.each(msg, function (key, value) {
            console.log(key);
            const keys = key.split(".")[0];
            $("." + keys + "_err").text(value);
        });
    }

    jQuery(function ($) {
        $(".sidebar-dropdown > a").click(function () {
            $(".sidebar-submenu").slideUp(200);
            if ($(this).parent().hasClass("active")) {
                $(".sidebar-dropdown").removeClass("active");
                $(this).parent().removeClass("active");
            } else {
                $(".sidebar-dropdown").removeClass("active");
                $(this).next(".sidebar-submenu").slideDown(200);
                $(this).parent().addClass("active");
            }
        });

        $("#close-sidebar").click(function () {
            $(".page-wrapper").removeClass("toggled");
        });

        $("#show-sidebar").click(function () {
            $(".page-wrapper").addClass("toggled");
        });
    });
});
