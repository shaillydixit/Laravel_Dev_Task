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
        sAjaxSource: httpPath + "fetch-event",
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
    var pageForm = $("#event_form");
    if (pageForm.length) {
        pageForm.validate({
            rules: {
                title: {
                    required: true,
                },
                artist_id: {
                    required: true,
                },
                genre_id: {
                    required: true,
                },
                image: {
                    required: true,
                },
                short_description: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                date: {
                    required: true,
                },
                venue_id: {
                    required: true,
                },
            },
        });
    }
});

function add_event() {
    if (!$("#event_form").valid()) {
        return false;
    }
    $(".submit_btn").attr("disabled", true);
    $(".loader").show();
    var formData = new FormData($("#event_form")[0]);
    $.ajax({
        type: "POST",
        url: httpPath + "add-event",
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
                $("#event_form").trigger("reset");
                $(".select2").trigger("change");
                $(".image_view").hide();
                $("#datatable").DataTable().ajax.reload();
                show_toastr("success", "event Added Successfully.", "event");
            } else {
                $(".submit_btn").attr("disabled", false);
                $(".loader").hide();
                show_toastr("error", "Something is wrong.", "event");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        },
    });
}
function imageEvent(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image_view").show();
            $(".image_view").attr("src", e.target.result).width(120).height(80);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function editImageEvent(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".edit_image_view").show();
            $(".edit_image_view")
                .attr("src", e.target.result)
                .width(120)
                .height(80);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function edit_event(id) {
    block_page();
    $.ajax({
        url: httpPath + "edit-event",
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
            $("#edit_event_modal").modal("show");
            $("#edit_title").val(obj.title);
            $("#edit_artist_id").val(obj.artist_id).trigger("change");
            $("#edit_genre_id").val(obj.genre_id).trigger("change");
            $("#edit_amount").val(obj.amount);
            $("#edit_date").val(obj.date);
            $("#edit_short_description").val(obj.short_description);
            $("#edit_venue_id").val(obj.venue_id).trigger("change");
            $("#edit_id").val(id);
            if (obj.image != "") {
                $(".edit_image_view").show();
                $(".edit_image_view").attr("src", obj.image_path);
                $("#edit_image_name").val(obj.image);
            }
            $("#datatable").DataTable().ajax.reload();
            unblock_page();
        },
    });
}

$(function () {
    "use strict";
    var pageForm = $("#edit_event_form");
    if (pageForm.length) {
        pageForm.validate({
            rules: {
                title: {
                    required: true,
                },
                artist_id: {
                    required: true,
                },
                genre_id: {
                    required: true,
                },
                short_description: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                date: {
                    required: true,
                },
                venue_id: {
                    required: true,
                },
            },
        });
    }
});
function update_event() {
    console.log("hhhss");
    if (!$("#edit_event_form").valid()) {
        return false;
    }
    console.log("hhhss1");
    $(".edit_submit_btn").attr("disabled", true);
    $(".loader").show();
    var formData = new FormData($("#edit_event_form")[0]);
    console.log("hhhss22");

    $.ajax({
        type: "POST",
        url: httpPath + "update-event",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            console.log("hhh");
            var obj = JSON.parse(response);
            if (obj.res == 3) {
                $(".edit_submit_btn").attr("disabled", false);
                $(".loader").hide();
                $("#edit_event_modal").modal("hide");
                $("#datatable").DataTable().ajax.reload();
                show_toastr("success", "event Updated Successfully.", "event");
            } else {
                $(".submit_btn").attr("disabled", false);
                $(".loader").hide();
                show_toastr("error", "Something is wrong.", "event");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        },
    });
}

function delete_event(id) {
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
                url: httpPath + "delete-event",
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
                            "event Deleted Successfully.",
                            "event"
                        );
                        $("#datatable").DataTable().ajax.reload();
                    } else if (obj.res == "0") {
                        show_toastr("error", "Something is wrong.", "event");
                    }
                    unblock_page();
                },
            });
        }
    });
}
