function date_format(timestamp, timezone, format)
{
    if (timezone) {
        return (moment.unix(timestamp).tz(timezone).format(format ? format : 'DD-MM-YYYY HH:mm:ss'));
    }
    return (moment.unix(timestamp).format(format ? format : 'DD-MM-YYYY HH:mm:ss'));
}

$(function ()
{
    $(document).on('keyup', '.counter', function ()
    {
        var ins = $($(this).data('output'));
        if (ins.length) {
            ins.text($(this).attr('maxlength') - $(this).val().length);
        }
    }).find('.counter').trigger('keyup');

    $(document).on('change', '.panel .checkbox input', function ()
    {
        var panel = $(this).closest('.panel');
        if ($(this).hasClass('checker')) {
            panel.find('.checkbox input').prop('checked', $(this).is(':checked'));
        }
        panel.find('.btn-auto-active').prop('disabled', !panel.find('.checkbox input:not(.checker):checked').length);
    }).find('.panel .checkbox input').trigger('change');

    $(document).on('click', 'button[name="schedule"]', function ()
    {
        if (!$(this).hasClass('timezone')) {
            var objDate = $(this).closest('#schedule').find('.datetimepicker:first').data('DateTimePicker').date(),
                app     = $('body').data(),
                url     = location.href.replace('/' + app.controller + '/' + app.action,
                    '/' + app.controller + '/sync');

            $.get(url, $.proxy(function (objDate, response)
            {
                var date    = moment(objDate).format('DD-MM-YYYY HH:mm'),
                    of_date = moment(objDate).tz(response.timezone).format('DD-MM-YYYY HH:mm');

                $(this).val(date + '=' + of_date).addClass('timezone').click();
            }, this, objDate), 'json');
        }

        return ($(this).hasClass('timezone'));
    });

    $(document).on('change', '[type="checkbox"].use-voice', function ()
    {
        $(this).closest('.form-group').find('textarea')
            .val($(this).is(':checked') ? 'TONE: ' : '').trigger('keyup').focus();
    });

    /* switch elements for events */
    $(document).on('change', '[data-toggle-group]', function ()
    {
        var $toggle_group = $('[data-group="' + $(this).data('toggleGroup') + '"]').addClass('hidden');
        $toggle_group.find('.required').prop('required', false);

        if (!$(this).closest('.form-group').hasClass('hidden')) {
            $toggle_group.filter('[data-id="' + $(this).val() + '"]').removeClass('hidden')
                .find('.required').prop('required', true);
        }

        $toggle_group.find('[data-toggle-group]').trigger('change');
    }).on('reset', 'form', function ()
    {
        setTimeout(function ()
        {
            $('[data-toggle-group], .counter').trigger('change').trigger('keyup');
        }, 50);
    }).find('[data-toggle-group]').trigger('change');
    /* END switch elements for events */

    /* expression test modal */
    $(document).on('keyup', '#expression_rule, #expression_text', function ()
    {
        var $text       = $('#expression_text'),
            $rule       = $('#expression_rule'),
            has_success = false;

        try {
            has_success = (new RegExp($rule.val().replace('*', '.*'))).test($text.val());
        } catch (e) {
        }

        $rule.closest('.form-group')
            .removeClass('has-success has-error').addClass((has_success ? 'has-success' : 'has-error'))
            .find('.form-control-feedback')
            .removeClass('glyphicon-ok glyphicon-remove').addClass(has_success ? 'glyphicon-ok' : 'glyphicon-remove');
    }).on('show.bs.modal', '#expression_test', function (event)
    {
        var $rule = $(event.relatedTarget).closest('.form-group').find('.expression');
        $('#expression_rule').val($rule.val()).data('input', $rule.attr('name')).trigger('keyup');
    }).on('click', '#expression_test .btn-apply', function ()
    {
        var $rule = $('#expression_rule');
        $('.expression[name="' + $rule.data('input') + '"]').val($rule.val());
    });
    /* END expression test modal */

    $('.datetimepicker').each(function ()
    {
        $(this).datetimepicker($(this).data());
    });

    $('[data-timestamp]').each(function () {
        var timestamp = $(this).data('timestamp'),
            timezone = $(this).data('timezone');

        if (timestamp) {
            $(this).text(date_format(timestamp, timezone));
        }
    });

    setInterval(function ()
    {
        var app = $('body').data(),
            url = location.href.replace('/' + app.controller + '/' + app.action, '/' + app.controller)
			    + (location.href.indexOf(app.controller) === -1 ? app.controller : '');

        $.get(url + '/sync', function (response)
        {
            var id = $('.container > .page-header').data('id');
            if (!$.isEmptyObject(response) && id in sync_pages) {
                sync_pages[id].call($('#main-content'), response);
            }
        }, 'json');

        $.ajax({
                url    : url,
                headers: {
                    'X-Requested-With': 'XMLHttpRequestFalse'
                }
            }
        ).then(function (response)
            {
                $(response).find('.badge').each(function ()
                {
                    var badge_id = $(this).closest('a').attr('href'),
                        $badge   = $('a[href^="' + badge_id + '"] .badge');

                    if (parseInt($(this).text()) > parseInt($badge.text())) {
                        $badge.text($(this).text()).addClass('new');
                    }
                });
            });

    }, 5000);
});

var sync_pages = {
    inbox: function (response)
    {
        var $dataList = this.find('.table tbody'),
            $badge    = $('.navbar-nav .fa-inbox ~ .badge');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages);

        // update count badge
        $badge.text(response.total_messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(date_format(message.timestamp, response.timezone)))
                    .append($('<td>').text(message.from))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);

                $badge.addClass('new');
            }
        }
    },

    turn: function (response)
    {
        var $dataList = this.find('.table tbody'),
            $badge    = $('.navbar-nav .fa-turn').parent().find('.badge');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages + response.total_out_messages);

        // update count badge
        $badge.text(response.total_messages + response.total_out_messages);

        response.messages = $.merge(response.out_messages, response.messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                // disabled delete outgoing messages
                if (message.id == message.filename) {
                    checkbox.prop('disabled', true);
                }

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(date_format(message.timestamp, response.timezone)))
                    .append($('<td>').text(message.to))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);

                $badge.addClass('new');
            }
        }
    },

    sent: function (response)
    {
        var $dataList = this.find('.table tbody'),
            $badge    = $('.navbar-nav .fa-sent').parent().find('.badge');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages);

        // update count badge
        $badge.text(response.total_messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(date_format(message.timestamp, response.timezone)))
                    .append($('<td>').text(message.to))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);

                $badge.addClass('new');
            }
        }
    },

    failed: function (response)
    {
        var $dataList = this.find('.table tbody'),
            $badge    = $('.navbar-nav .fa-failed').parent().find('.badge');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages);

        // update count badge
        $badge.text(response.total_messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(date_format(message.timestamp, response.timezone)))
                    .append($('<td>').text(message.to))
                    .append($('<td>').text(message.reason))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);

                $badge.addClass('new');
            }
        }
    },

    phonecalls: function (response)
    {
        var $dataList = this.find('.table tbody'),
            $badge    = $('.navbar-nav .fa-phonecalls ~ .badge');

        // update total message
        this.find('.panel-heading > span').text(response.total_calls);

        // update count badge
        $badge.text(response.total_calls);

        for (var call in response.calls) {
            if (response.calls.hasOwnProperty(call)) {
                call = response.calls[call];

                if ($dataList.find('.checkbox [value="' + call.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="callsId[]" value="' + call.id + '" />');

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(date_format(call.timestamp, response.timezone)))
                    .append($('<td>').text(call.from))
                    .append($('<td>').text(call.text))
                    .appendTo($dataList);

                $badge.addClass('new');
            }
        }
    },

    templates: function (response)
    {
        var $dataList = this.find('.table tbody');

        // update total message
        this.find('.panel-heading > span').text(response.total_templates);

        for (var template in response.templates) {
            if (response.templates.hasOwnProperty(template)) {
                template = response.templates[template];

                if ($dataList.find('.checkbox [value="' + template.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="templatesId[]" value="' + template.id + '" />');

                $('<tr class="info">')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(template.to))
                    .append($('<td>').text(template.text))
                    .appendTo($dataList);
            }
        }
    }
};
