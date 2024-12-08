var ajax_table;
var tableContainer;
var ServiceForm = (function () {
    ////////////////////////// Begins Action Events /////////////////////////
    var initFormComponents = function () {
        $("#formFile").on("change", function () {
            var el = $(this)[0];
            var formData = new FormData();
            var totalfiles = el.files.length;

            for (var index = 0; index < totalfiles; index++) {
                formData.append("files[]", el.files[index]);
            }

            let _this = $(this);
            var route = $(this).attr("route");

            $.ajax({
                url: app_base_path_admin + "/common/" + route,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener(
                        "progress",
                        function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete =
                                    (evt.loaded / evt.total) * 100;
                                $("#progressBar").val(percentComplete);
                            }
                        },
                        false
                    );
                    return xhr;
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json) {
                        if (json.status == 1) {
                            json?.data?.map((image, index) => {
                                _this
                                    .closest(".ajax-field")
                                    .find(".image-preview")
                                    .html(
                                        `<div class="dz-preview dz-file-preview"><div class="dz-details"><div class="dz-thumbnail"><img data-dz-thumbnail src="${image.filePath}" class="img-thumbnail" /><input type="hidden" name="image" value="${image.fileName}" /><div class="dz-success-mark"><div class="progress"><div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div></div></div></div><div class="dz-filename" data-dz-name=""></div><a class="dz-remove file-remove-btn" href="javascript:undefined;">Remove file</a></div></div>`
                                    );
                            });
                        } else {
                            $("#message").text(json.error);
                        }
                    }
                },
                error: function () {
                    $("#message").text("Error uploading file.");
                },
            });
        });

        $(document).on("click", ".file-remove-btn", function (e) {
            e.preventDefault();
            $(this).closest(".dz-preview").remove();
        });

        //point Clone
        $(document).on("click", ".clonebtn", function () {
            var ytBox = $(this).closest(".yt-box").clone();

            ytBox.find("input").val("");
            var removeBtn =
                '<span class="icon clonebtn-remove" style="color: #fff"> - </span>';
            ytBox.find(".clonebtn").replaceWith(removeBtn);
            $(this).closest(".clone-div").append(ytBox);
        });

        $(document).on("click", ".clonebtn-remove", function () {
            $(this).closest(".yt-box").remove();
        });

        //Form repeater
        $(document).on("click", ".cloneForm", function () {
            var formBox = $(".form-repeat:last").clone();
            formBox.find("#sub_title").val("");
            formBox.find("#desc").val("");
            formBox.find(".point").val("");

            var removeForm =
                '<div class="btn btn-label-danger removeForm"><i class="ti ti-x ti-xs me-1"></i><span class="align-middle">Delete</span></div>';
            formBox.find(".cloneForm").replaceWith(removeForm);
            formBox.insertAfter(".form-repeat:last");

            $(".form-repeat").each(function (index) {
                $(this)
                    .find("#sub_title")
                    .attr("name", "sub_title[" + index + "]");
                $(this)
                    .find("#desc")
                    .attr("name", "description[" + index + "]");
                $(this)
                    .find(".point")
                    .attr("name", "point[" + index + "][]");
            });
        });

        //Remove Form Repeater
        $(document).on("click", ".removeForm", function () {
            $(this).closest(".form-repeat").remove();
        });

        const previewTemplate = `<div class="dz-preview dz-file-preview">
  <div class="dz-details">
    <div class="dz-thumbnail">
      <img data-dz-thumbnail>
      <span class="dz-nopreview">No preview</span>
      <div class="dz-success-mark"></div>
      <div class="progress">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
      </div>
    </div>
    <div class="dz-filename" data-dz-name></div>
    <div class="dz-size" data-dz-size></div>
  </div>
  </div>`;

        // Basic Dropzone
        // --------------------------------------------------------------------
        const dropzoneBasic = document.querySelector("#dropzone-basic");
        if (dropzoneBasic) {
            const myDropzone = new Dropzone(dropzoneBasic, {
                previewTemplate: previewTemplate,
                parallelUploads: 1,
                maxFilesize: 5,
                addRemoveLinks: true,
                maxFiles: 1,
            });
        }
    };

    return {
        handleFormValid: function () {
            initFormComponents();
        },
    };
})();
