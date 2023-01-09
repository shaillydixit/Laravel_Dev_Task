$(document).ready(function () {
    datatable = $("#datatable").dataTable({
        bAutoWidth: false,
        bFilter: true,
        bStateSave: true,
        bSort: true,
        bProcessing: true,
        bServerSide: true,
        scrollX: "200px",
        oLanguage: {
            sLengthMenu: "_MENU_",
            sInfoFiltered: "",
            sProcessing: "Loading ...",
            sEmptyTable: "NO DATA ADDED YET !",
        },
        aLengthMenu: [
            [-1, 10, 20, 30, 50],
            ["All", 10, 20, 30, 50],
        ],
        iDisplayLength: 10,
        sAjaxSource: httpPath + "fetch-artist",
        fnServerParams: function (aoData) {
            aoData.push({ name: "mode", value: "fetch" });
        },
        fnDrawCallback: function (oSettings) {
            $('.ttip, [data-toggle="tooltip"]').tooltip();
        },
    });
    $(".dataTables_filter input")
        .addClass("form-control")
        .attr("placeholder", "Search");
    $(".dataTables_length select").addClass("form-control");
});

$(function () {
    "use strict";
    var pageForm = $("#artist_form");
    if (pageForm.length) {
        pageForm.validate({
            rules: {
                name: {
                    required: true,
                },
            },
        });
    }
});

function add_artist() {
    if (!$("#artist_form").valid()) {
        return false;
    }
    $(".submit_btn").attr("disabled", true);
    $(".loader").show();
    var formData = new FormData($("#artist_form")[0]);
    $.ajax({
        type: "POST",
        url: httpPath + "add-artist",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.res == 1) {
                $(".submit_btn").attr("disabled", false);
                $(".loader").hide();
                $("#artist_form").trigger("reset");
                $("#datatable").DataTable().ajax.reload();
                show_toastr("success", "Artist Added Successfully.", "Artist");
            } else {
                $(".submit_btn").attr("disabled", false);
                $(".loader").hide();
                show_toastr("error", "Something is wrong.", "Artist");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        },
    });
}

function edit_artist(id) {
    block_page();
    $.ajax({
        url: httpPath + "edit-artist",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        data: {
            id: id,
        },
        beforeSend: function () {},
        success: function (response) {
            var obj = JSON.parse(response);
            $("#edit_artist_modal").modal("show");
            $("#edit_name").val(obj.name);
            $("#edit_id").val(id);
            $("#datatable").DataTable().ajax.reload();
            unblock_page();
        },
    });
}

$(function () {
    "use strict";
    var pageForm = $("#edit_artist_form");
    if (pageForm.length) {
        pageForm.validate({
            rules: {
                name: {
                    required: true,
                },
                comment: {
                    required: true,
                },
                image: {
                    required: true,
                },
            },
        });
    }
});
function update_artist() {
    if (!$("#edit_artist_form").valid()) {
        return false;
    }
    $(".edit_submit_btn").attr("disabled", true);
    $(".loader").show();
    var formData = new FormData($("#edit_artist_form")[0]);
    $.ajax({
        type: "POST",
        url: httpPath + "update-artist",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.res == 3) {
                $(".edit_submit_btn").attr("disabled", false);
                $(".loader").hide();
                $("#edit_artist_modal").modal("hide");
                $("#datatable").DataTable().ajax.reload();
                show_toastr(
                    "success",
                    "Artist Updated Successfully.",
                    "Artist"
                );
            } else {
                $(".submit_btn").attr("disabled", false);
                $(".loader").hide();
                show_toastr("error", "Something is wrong.", "Artist");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        },
    });
}

function delete_artist(id) {
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        reverseButtons: false,
    }).then(function (result) {
        if (result.value) {
            block_page();
            $.ajax({
                url: httpPath + "delete-artist",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                data: {
                    id: id,
                },
                beforeSend: function () {},
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.res == "1") {
                        $("#datatable").DataTable().ajax.reload();
                        show_toastr(
                            "success",
                            "Artist Deleted Successfully.",
                            "Artist"
                        );
                        $("#datatable").DataTable().ajax.reload();
                    } else if (obj.res == "0") {
                        show_toastr("error", "Something is wrong.", "Artist");
                    }
                    unblock_page();
                },
            });
        }
    });
}
