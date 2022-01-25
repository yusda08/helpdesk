require('bootstrap');
window.$ = window.jQuery = require('jquery');
const Swal = window.Swal = require('sweetalert2');
require('select2');

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});

$('.select2').select2({
    theme: 'bootstrap-5'
})
