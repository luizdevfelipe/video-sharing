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
                $.get(routes['two-factor.qr-code'], function (response) {
                    $('#form').html(`<div class="m-auto w-55"><div class="flex justify-center bg-white p-2">${response.svg}</div></div>`);

                    $('#form').append(`<p class="text-center dark:text-white">${translations.enable2FACode}</p>`);
                    $('#form').append(`<div class="mb-5 size-64 m-auto h-20"><label for="icode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">${translations.code}</label><input type="text" id="icode" name="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required autofocus /></div>`);

                    $('#form').append(`<div class="flex justify-center"><button id="twoFactorConfirmCodeSubmit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">${translations.submit}</button></div>`);
                });
            }).fail(function (error) {
                window.location.href = routes['password.confirm'];
            });

    });

    // TODO: finalizar o post do formulário de confirmação do código 2FA
    $('#twoFactorConfirmCodeSubmit').click(function (e) {
        e.preventDefault();

        $.post(
            routes['two-factor.confirm'],

        )
            .done(function () {
                window.location.href = routes['two-factor.index'];
            }).fail(function (error) {
                if (error.status === 422) {
                    $('#twoFactorConfirmCode').html(`<div class="text-red-500">${translations.codeError}</div>`);
                } else {
                    window.location.href = routes['password.confirm'];
                }
            });
    })
});
