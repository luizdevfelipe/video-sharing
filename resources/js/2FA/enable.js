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
                if (url == routes['two-factor.confirm']) {
                    $('#twoFactorForm').html(`<p class="text-center dark:text-white">${translations.success2FA}</p>`);
                } else {
                    activateTwoFactor();
                }
            }).fail(function (error) {
                if (url == routes['two-factor.confirm']) {
                    $('#twoFactorForm').html(`<p class="text-center dark:text-white">${translations.invalid2FACode}</p>`);
                } else {
                    window.location.href = routes['password.confirm'];
                }
            });

        function activateTwoFactor() {
            $.get(routes['two-factor.qr-code'], function (response) {
                $('#twoFactorForm').html(`<div class="m-auto w-55"><div class="flex justify-center bg-white p-2">${response.svg}</div></div>`);
                $('#twoFactorForm').attr('action', routes['two-factor.confirm']);
                $('#twoFactorForm').append(`<p class="text-center dark:text-white">${translations.enable2FACode}</p>`);
                $('#twoFactorForm').append(`<div class="mb-5 size-64 m-auto h-20"><label for="icode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">${translations.code}</label><input type="text" id="icode" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required autofocus /></div>`);

                $('#twoFactorForm').append(`<div class="flex justify-center"><button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">${translations.submit}</button></div>`);
            });
        }
    });
});
