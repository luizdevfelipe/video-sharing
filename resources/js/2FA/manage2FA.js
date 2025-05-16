import { getRoutes } from '@/js/routes.js';
var routes = getRoutes();

$(document).ready(function () {

    $('#getCodes').on('click', function (e) {
        $.get(routes['two-factor.recovery-codes']
        ).done(function (response) {
            $('#getCodes').remove();
            $('#manageCodes').append('<ul id="codeList" class="text-dark text-center dark:text-white" style="font-family: monospace;"></ul>');
            $('#codeList').empty();
            response.forEach(code => {
                $('#codeList').append('<li>' + code + '</li>');
            });
        });
    });

    $('#remove2FA').on('click', function (e) {
        $.post({
            url: routes['two-factor.disable'],
            data: {
            _method: 'DELETE',
            },
        })
            .done(function () {
                location.reload();
            });
    });

    $('#newCodes').on('click', function (e) {
        $.post(routes['two-factor.newCodes']).done(function (response) {
            $.get(routes['two-factor.recovery-codes']
            ).done(function (response) {
                $('#getCodes').remove();
                $('#manageCodes').append('<ul id="codeList" class="text-dark text-center dark:text-white" style="font-family: monospace;"></ul>');
                $('#codeList').empty();
                response.forEach(code => {
                    $('#codeList').append('<li>' + code + '</li>');
                });
            });
        });
    });


});