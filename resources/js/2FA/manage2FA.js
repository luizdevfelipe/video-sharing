import { getRoutes } from '@/js/routes.js';
var routes = getRoutes();

$(document).ready(function () {
    
    $('getCodes').on('click', function (e) {
        $.get({
            url: routes['two-factor.recovery-codes']
        });
    });
});