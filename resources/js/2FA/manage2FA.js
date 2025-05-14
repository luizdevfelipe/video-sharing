import { getRoutes } from '@/js/routes.js';
var routes = getRoutes();

$(document).ready(function () {
     
    $('#getCodes').on('click', function (e) {
        $.get(routes['two-factor.recovery-codes']
        ).done(function (response) {
            $('#getCodes').remove();
            $('#manageCodes').append('<ul id="codeList" class="text-dark dark:text-white"></ul>');
            response.forEach(code => {
                $('#codeList').append('<li>' + code + '</li>');
            });
        });
    });


});