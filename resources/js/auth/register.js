$(document).ready(function() {
    $('#registerForm').submit(function (event) {
        event.preventDefault();

        const name = $('#name').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const password_confirmation = $('#password-confirm').val();

        $.post({
            url: '/api/register',
            contentType: 'application/json',
            data: JSON.stringify({
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation
            }),
            success: function (response) {
                alert(response.message);
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.message;
                $('#errorsSection').empty();
                $.each(errors, function (key, value) {
                    $('#errorsSection').append('<p>' + value + '</p>')
                });
            }
        });
    });
});