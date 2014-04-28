(function ($, document) {
    $(document).ready(function () {
        $('.js-logic-sequence').each(function () {
            var $this = $(this),
                items = $.parseJSON($this.val()),
                $holder = $('<ul/>').insertAfter($this);
                
            $this.attr('type', 'hidden');
            
            for (var i = 0, l = items.length; i < l; ++i) {
                $('<li/>').text(items[i]).appendTo($holder);
            }
            
            $holder.sortable({
                update: function () {
                    var items = [];
                    $holder.find('li').each(function () {
                        items.push($(this).text());
                    });
                    $this.val(JSON.stringify(items));
                }
            });
        });
        
        $('.js-answer-button').click(function (e) {
            var $form = $(this).closest('form');
            e.preventDefault();
            $.post($form.attr('action'), $form.serializeArray(), function (data) {
                console.log(data);
            });
        });
    });
})(jQuery, document);