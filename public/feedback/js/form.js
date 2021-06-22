$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addModel(model, data) {
    $.ajax({
        type: 'POST',
        url: base_url + model,
        data: data,
        dataType : 'json',

        success: function (response) {
            successResponse(response);
        },
        error: function (e) {
            errorResponse(e)
        }
    });
}

function updateModel(model, data) {
    $.ajax({
        type: 'PUT',
        url: base_url + model,
        data: data,
        dataType: 'json',
        success: function (response) {
            successResponse(response);
        },
        error: function (e) {
            errorResponse(e)
        }
    });
}


// 

function successResponse(response) {
    $("*").removeClass('is-invalid');

    $('.invalid-feedback').remove();

    messageResponse('success', response.mess);
}

function errorResponse(e) {

    if (e.responseJSON.errors != null) {
        errors = e.responseJSON.errors;

        $("*").removeClass('is-invalid');

        $('.invalid-feedback').remove();

        $.each(errors, function (key, value) {
            // console.log(key + ": " + value[0]);
            $('.sp-' + key).remove();
            $('#' + key).addClass('is-invalid');
            $('#' + key).after("<span class='invalid-feedback'>"+ value[0] +"</span>");
        });
    }

    messageResponse('danger', e.responseJSON.mess);
}

// 

function messageResponse(status, mess) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

    var message = "<div class='notice notice-"+ status +"'><div class='notice-header'><p>Thông báo</p><i class='fas fa-times'></i>" +
        "</div><div class='notice-body'><p>";
        // <!-- <i class="fas fa-exclamation-triangle"></i> -->
        // <!-- <i class="fas fa-check-circle"></i> -->

    if (status == 'success') {
        message += "<i class='fas fa-check'></i>"+ mess +"</p></div></div>";
    } else if (status == 'danger') {
        message += "<i class='fas fa-exclamation-triangle'></i>"+ mess +"</p></div></div>";
    } else {
        message += "<i class='fas fa-check-circle'></i>"+ mess +"</p></div></div>";
    }

    if ($('.notice')) {
        $('.notice').remove();
    }

    $('.main-content').after(message);

    $('.notice').fadeIn();

    $('.notice').delay(2500).fadeOut();

}

$(document).on('click', '.notice .fa-times', function (e) {
    $('.notice').fadeOut();
});