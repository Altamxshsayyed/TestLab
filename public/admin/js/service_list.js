var ajax_table;
var tableContainer;
var Service = (function () {
    var ServiceList = function () {
        $.fn.serializeObject = function () {
            var obj = {};
            $.each(this.serializeArray(), function (i, o) {
                var n = o.name,
                    v = o.value;

                obj[n] =
                    obj[n] === undefined
                        ? v
                        : $.isArray(obj[n])
                        ? obj[n].concat(v)
                        : [obj[n], v];
            });
            return obj;
        };
        tableContainer = $(".table-container").parent();
        ajax_table = $("#service_table").DataTable({
            ordering: false,
            // 'columnDefs': [{ 'orderable': false, 'targets': all }],
            select: false,
            searching: false,
            serverSide: true,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, 75, 100],
                [10, 25, 50, 75, 100], // change per page values here
            ],
            columnDefs: [{ target: 0, visible: false, searchable: false }],
            pageLength: 25,
            ajax: {
                url: "fetch_service",
                type: "POST",
                data: function (d) {
                    d.form = $("#filterData").serializeObject();
                },
                dataSrc: function (res) {
                    return res.data;
                },
                error: function () {},
            },
            lengthChange: true,
            createdRow: function (row, data, dataIndex) {
                var page = this.api().page.info().page + 1;
                var perPage = this.api().page.info().length;
                var dataIdValue = data[0] + "/" + page + "/" + perPage;
                $(row).attr("data-id", dataIdValue);
            },
        });

        // $(document).ready(function () {
        //     $("#service-sortable").sortable({
        //         helper: "clone", // Set helper option to 'clone'
        //         update: function (event, ui) {
        //             var newOrder = $(this).sortable("toArray", {
        //                 attribute: "data-id",
        //             });
        //             console.log({ order: newOrder });

        //             $.ajax({
        //                 url: "organize_service",
        //                 type: "POST",
        //                 data: { order: newOrder },
        //                 success: function (response) {
        //                     console.log(response.message);
        //                 },
        //                 error: function (xhr, status, error) {
        //                     console.error("AJAX request failed: " + error);
        //                 },
        //             });
        //         },
        //     });
        // });

        $(document).on("click", ".submit_filter", function (e) {
            ajax_table.ajax.reload();
            e.preventDefault();
        });
    };

    return {
        //some helper function
        handleList: function () {
            ServiceList();
        },
    };
})();
