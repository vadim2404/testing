(function ($, document) {
    $(document).ready(function () {
        $('#js-teacher-filters-btn').click(function (e) {
            e.preventDefault();
            $('#js-teacher-filters').toggleClass('hidden');
        });
    });
})(jQuery, document);