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
        
        $('.js-paired').each(function () {
            var $this = $(this),
                items = $.parseJSON($this.val()),
                $keysHolder = $('<ul/>').insertAfter($this),
                $valuesHolder = $('<ul/>').insertAfter($keysHolder),
                onUpdateListener = function () {
                    var items = {
                        keys: [],
                        values: []
                    };
                    $keysHolder.find('li').each(function () {
                        items.keys.push($(this).text());
                    });
                    $valuesHolder.find('li').each(function () {
                        items.values.push($(this).text());
                    });
                    $this.val(JSON.stringify(items));
                };
            
            $this.attr('type', 'hidden');
            
            for (var i = 0, l = items.keys.length; i < l; ++i) {
                $('<li/>').text(items.keys[i]).appendTo($keysHolder);
                $('<li/>').text(items.values[i]).appendTo($valuesHolder);
            }
            
            $keysHolder.sortable({
                update: onUpdateListener
            });
            
            $valuesHolder.sortable({
                update: onUpdateListener
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