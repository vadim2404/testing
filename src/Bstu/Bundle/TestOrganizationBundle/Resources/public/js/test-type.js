(function ($, document, Routing) {
    $(document).ready(function () {
        var firstTime = true;
        $('#bstu_bundle_testorganizationbundle_test_subject').change(function () {
            var $subject = $(this),
                $holder = $('#bstu_bundle_testorganizationbundle_test_themes'),
                params = {
                    id: $subject.val()
                };
            if (firstTime) {
                firstTime = false;
                params.test = $subject.data('test');
            }
            $.get(Routing.generate($subject.data('route'), params), function (data) {
                for (var item, $fragment = $(document.createDocumentFragment()), i = 0, l = data.length; i < l; ++i) {
                    item = data[i];
                    $('<option/>').val(item.id).text(item.name).prop('selected', item.selected).appendTo($fragment);
                }
                $holder.empty().append($fragment);
            }, 'json');
        }).change();
    });
}(jQuery, document, Routing));