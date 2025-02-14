$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        let email = $("#email").val();
        let password = $("#password").val();

        $.post({
            url: '/api/login',
            contentType: 'application/json',
            data: JSON.stringify({ email: email, password: password }),
            success: function (response) {
                console.log("Login bem-sucedido!", response);
                window.location.href = "/dashboard";
            },
            error: function (xhr) {
                const error = xhr.responseJSON.message;
                $('#errorsSection').empty();
                $('#errorsSection').append('<p>' + error + '</p>')
            }
        });
    });
});
