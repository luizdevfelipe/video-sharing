import { getRoutes } from '@/js/routes.js';

var routes = getRoutes();

$(document).ready(function () {
    $('#twoFactorForm').submit(function (e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.post(url)
        .done(function () {
            activateTwoFactor();
        }).fail(function (error) {
           window.location.href = routes['password.confirm'];
        });

        function activateTwoFactor() {
            $.get(routes['two-factor.qr-code'], function (response) {
                $('#twoFactorForm').html(response.svg);
                $('#twoFactorForm').append('<p class="text-center dark:text-white">Scan the QR code with your authenticator app.</p>');
            });
        }
    });
});
