(function ($, document) {
    $(document).ready(function () {
        $('.js-answer-button').click(function (e) {
            var $form = $(this).closest('form');
            e.preventDefault();
            $.post($form.attr('action'), $form.serializeArray(), function (data) {
                console.log(data);
            });
        });
    });
})(jQuery, document);