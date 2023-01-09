function start_button_loader(formbtn) {
    $("#" + formbtn).addClass("spinner-border spinner-border-sm");
    $("#" + formbtn).attr("disabled", true);
    $("#" + formbtn).attr("aria-hidden", false);
}
function close_button_loader(formbtn) {
    $("#" + formbtn).removeClass("spinner-border spinner-border-sm");
    $("#" + formbtn).attr("disabled", false);
    $("#" + formbtn).attr("aria-hidden", true);
}

function block_page() {
    $.blockUI({
        message: '<div class="spinner-border text-white" role="status"></div>',
        css: {
            backgroundColor: "transparent",
            border: "0",
        },
        overlayCSS: {
            opacity: 0.5,
        },
    });
}
function unblock_page() {
    $.unblockUI();
}
$(".summernote").summernote({
    height: 200,
});
$(document).ready(function () {
    $(".summernote").summernote({
        height: 150,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "italic", "underline", "clear"]],
            ["fontname", ["fontname"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["table", ["table"]],
            ["insert", ["link", "picture", "hr"]],
            ["help", ["help"]],
        ],
    });
});
$(".flatpickr-basic").flatpickr({ dateFormat: "d-m-Y" });
$("input.numbers").keypress(function (event) {
    return /\d/.test(String.fromCharCode(event.keyCode));
});

$("input.alpha").keypress(function (event) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(
        !event.charCode ? event.which : event.charCode
    );
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});
$(".no").on("input", function () {
    if (/^0/.test(this.value)) {
        this.value = this.value.replace(/^0/, " ").length == 0;
    }
});

$(document).ready(function () {
    $(".length").attr("maxlength", "10");
    $(".length").keypress(function (e) {
        var kk = e.which;
        if (kk < 48 || kk > 57) e.preventDefault();
    });
});
function show_toastr(type, message, title) {
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: false,
        positionClass: "toast-top-center",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "2000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };
    if (type == "success") {
        toastr.success(message, title);
    } else if (type == "error") {
        toastr.error(message, title);
    } else if (type == "info") {
        toastr.info(message, title);
    }
}

function block_page() {
    $.blockUI({
        message: '<div class="spinner-border text-white" role="status"></div>',
        css: {
            backgroundColor: "transparent",
            border: "0",
        },
        overlayCSS: {
            opacity: 0.5,
        },
    });
}
function unblock_page() {
    $.unblockUI();
}
