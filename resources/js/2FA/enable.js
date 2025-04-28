$(document).ready(function() {
    $('#twoFactorForm').submit(function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.post(url).done(
            function() {
                $.get('/user/two-factor-qr-code', function(response) {
                    $('#twoFactorForm').html(response.svg);
                });
            }
        ).fail(function(error) {
            console.error('Erro ao ativar 2FA:', error);
        });
    });
});
