import { getRoutes } from '@/js/routes.js';
import { getTranslations } from '@/js/translations.js'

var routes = getRoutes();
var translations = getTranslations();

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
                $('#twoFactorForm').append(`<p class="text-center dark:text-white">${translations.enable2FACode}</p>`);
            });
        }
    });
});
