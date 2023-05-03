jQuery(document).ready(function ($) {
    jQuery('.modal.sud-modal-open')
    .modal('show')
    .on('hide.bs.modal', function () {
        window.history.pushState('', '', sud_js_obj.page_url.replace(/\/?$/, '/'));
    });
});
