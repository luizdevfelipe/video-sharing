import './bootstrap';
import 'flowbite';
import.meta.glob([
    '../images/**'
]);
import $ from 'jquery';
window.$ = window.jQuery = $;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
