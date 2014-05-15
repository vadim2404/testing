(function ($, document, window) {
    $(document).ready(function () {
        $('.js-logic-sequence').each(function () {
            var $this = $(this),
                items = $.parseJSON($this.val()),
                $holder = $('<ul class="b-draggable"/>').insertAfter($this);
                
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
                $keysHolder = $('<ul class="b-draggable b-paired"/>').insertAfter($this),
                $valuesHolder = $('<ul class="b-draggable b-paired"/>').insertAfter($keysHolder),
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
            
            $this.siblings('label').css({
                display: 'block',
                textAlign: 'left'
            });
            
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
            var $this = $(this),
                $form = $this.closest('form');
            $this.closest('.form-group').find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
            e.preventDefault();
            $.post($form.attr('action'), $form.serializeArray(), function (data) {
            });
        });
        
        window.CountdownLabels = {
            second 	: "СЕКУНДЫ",
            minute 	: "МИНУТЫ",
            hour	: "ЧАСЫ",
            day 	: "ДНИ",
            month 	: "МЕСЯЦЫ",
            year 	: "ГОДЫ"	
        };
    });
})(jQuery, document, window);