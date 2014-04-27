(function ($, window, Routing) {           
    var init = function () {
            var TYPE_CHECKBOX = 3,
                TYPE_RADIO = 4,
                $list = $('#variants-field-list'),
                node,
                counter,
                $deleteLink = $('<a class="variants-field-delete" href="#">Delete link</a>'),
                appendLink = function () {
                    $deleteLink.clone().appendTo(this);
                },
                type,
                $answer;
            if ($list.length) {
                node = $list.data('prototype');
                counter = $list.find('li').each(appendLink).length;
                type = +$(':radio[name="bstu_bundle_testorganizationbundle_question[type]"]:checked').val();
                $answer = $('#bstu_bundle_testorganizationbundle_question_answer');
                if (type === TYPE_CHECKBOX || type === TYPE_RADIO) {
                    $list.selectable({
                        cancel: '.variants-field-delete, input',
                        filter: 'li',
                        stop: function () {
                            var values = [];
                            if (type === TYPE_RADIO) {
                                $list.find('.ui-selected:not(:first)').removeClass('ui-selected');
                            }
                            $list.find('.ui-selected').each(function () {
                                values.push($(this).index());
                            });
                            $answer.val(values.join(','));
                        }
                    });
                    for (var arr = $answer.val().split(','), i = arr.length - 1; i >= 0; --i) {
                        $list.find('li').eq(+arr[i]).addClass('ui-selected');
                    }
                }
                $('#add-another-variant').click(function () {
                    var $newNode = $('<li/>').html(node.replace(/__name__/g, counter++));
                    appendLink.call($newNode);
                    $newNode.appendTo($list);
                    return false;
                });
                $list.on('click', '.variants-field-delete', function () {
                    $(this).closest('li').remove();
                    return false;
                });
            }
        };
    
    init();
    
    window.rerenderCreateForm = function () {
        $.ajax({
            url: Routing.generate('question_new', { questionType: +$(':radio[name="bstu_bundle_testorganizationbundle_question[type]"]:checked').val() }),
            success: function (data) {
                $('form').replaceWith(data);                
                init();
            },
            dataType: 'html'
        });
    };
}(jQuery, window, Routing));