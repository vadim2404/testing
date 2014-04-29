(function ($, window, Routing) {           
    var init = function () {
            var TYPE_CHECKBOX = 3,
                TYPE_RADIO = 4,
                TYPE_LOGIC_SEQUENCE = 5,
                TYPE_PAIRED = 6,
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
                if (type === TYPE_PAIRED) {
                    $('form').submit(function () {
                        $list.find('li').each(function () {
                            var $this = $(this),
                                $inputs = $this.find('input'),
                                $first = $inputs.first(),
                                $last = $inputs.last(),
                                key = $first.val(),
                                value = $last.val(),
                                obj = {};
                            obj[key] = value;
                            $first.val(JSON.stringify(obj));
                            $last.remove();
                        });
                    });
                }
                $('#add-another-variant').click(function () {
                    var $newNode = $('<li class="form-group" />').html(node.replace(/__name__/g, counter++));
                    if (type === TYPE_PAIRED) {
                        $newNode.find('input').after('<input type="text" class="form-control" required="required"/>');
                    }
                    appendLink.call($newNode);
                    $newNode.appendTo($list);
                    if (type === TYPE_LOGIC_SEQUENCE || type === TYPE_PAIRED) {
                        $answer.val($list.find('li').length);
                    }
                    return false;
                });
                $list.on('click', '.variants-field-delete', function () {
                    $(this).closest('li').remove();
                    if (type === TYPE_LOGIC_SEQUENCE || type === TYPE_PAIRED) {
                        $answer.val($list.find('li').length);
                    }
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
                initTinyMCE();
            },
            dataType: 'html'
        });
    };
}(jQuery, window, Routing));