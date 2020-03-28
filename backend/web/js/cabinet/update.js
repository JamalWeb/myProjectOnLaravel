$(document).ready(function () {
    let form = $('#profileForm'),
        submitButton = form.find('.save');

    $(document).on('click', '.save', function (e) {
        e.preventDefault();

        let data = form.serialize();
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            beforeSend: function () {
                submitButton.addClass('disabled');
                submitButton.attr('disabled', true);
            },
            complete: function () {
                submitButton.removeClass('disabled');
                submitButton.removeAttr('disabled')
            },
            data: data,
            success: function (data) {
                console.log(data);
                swal("Good job!", "You clicked the button!", "success");
            },
            error: function (jqXHR, errMsg) {
                alert(errMsg);
            }
        });
        return false;
    });
});
