Date.prototype.toLocaleFormat = function (format)
{
    var types = {
        'y': this.getUTCFullYear(),
        'm': this.getUTCMonth() + 1,
        'd': this.getUTCDate(),
        'H': this.getUTCHours(),
        'M': this.getUTCMinutes(),
        'S': this.getUTCSeconds()
    };

    // format date input string
    for (var type in types) {
        if (types.hasOwnProperty(type)) {
            var findType = types[type];
            format = format.replace('%' + type, findType < 10 ? '0' + findType : findType);
        }
    }
    return (format);
};

var sync_pages = {
    inbox: function (response)
    {
        var $dataList = this.find('.table tbody');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                $('<tr>')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text((new Date(message.timestamp * 1000)).toLocaleFormat('%d-%m-%y %H:%M:%S')))
                    .append($('<td>').text(message.from))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);
            }
        }
    },

    turn: function (response)
    {
        var $dataList = this.find('.table tbody');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages + response.total_out_messages);

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

                $('<tr>')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text((new Date(message.timestamp * 1000)).toLocaleFormat('%d-%m-%y %H:%M:%S')))
                    .append($('<td>').text(message.to))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);
            }
        }
    },

    sent: function (response)
    {
        var $dataList = this.find('.table tbody');

        // update total message
        this.find('.panel-heading > span').text(response.total_messages);

        for (var message in response.messages) {
            if (response.messages.hasOwnProperty(message)) {
                message = response.messages[message];

                if ($dataList.find('.checkbox [value="' + message.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="messagesId[]" value="' + message.id + '" />');

                $('<tr>')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text((new Date(message.timestamp * 1000)).toLocaleFormat('%d-%m-%y %H:%M:%S')))
                    .append($('<td>').text(message.to))
                    .append($('<td>').text(message.text))
                    .appendTo($dataList);
            }
        }
    },

    phonecalls: function (response)
    {
        var $dataList = this.find('.table tbody');

        // update total message
        this.find('.panel-heading > span').text(response.total_calls);

        for (var call in response.calls) {
            if (response.calls.hasOwnProperty(call)) {
                call = response.calls[call];

                if ($dataList.find('.checkbox [value="' + call.id + '"]').length) {
                    continue;
                }

                var checkbox = $('<input type="checkbox" name="callsId[]" value="' + call.id + '" />');

                $('<tr>')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text((new Date(call.timestamp * 1000)).toLocaleFormat('%d-%m-%y %H:%M:%S')))
                    .append($('<td>').text(call.from))
                    .append($('<td>').text(call.text))
                    .appendTo($dataList);
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

                $('<tr>')
                    .append($('<td>').append($('<div class="checkbox">').append($('<label>').append(checkbox))))
                    .append($('<td>').text(template.to))
                    .append($('<td>').text(template.text))
                    .appendTo($dataList);
            }
        }
    }
};

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
        panel.find('.btn-auto-active').prop('disabled', !panel.find('.checkbox input:checked').length);
    }).find('.panel .checkbox input').trigger('change');

    $(document).on('click', 'button[name="schedule"]', function ()
    {
        var data = $(this).closest('#schedule').find('.datetimepicker:first').data("DateTimePicker").date();
        $(this).val(moment(data).format('DD-MM-YYYY HH:mm'));
    });

    $('.datetimepicker').each(function ()
    {
        $(this).datetimepicker($(this).data());
    });

    setInterval(function ()
    {
        var url = location.href.replace(location.search, '') + '?sync=1';
        $.get(url, function (response)
        {
            var id = $('.container > .page-header').data('id');
            if (!$.isEmptyObject(response) && id in sync_pages) {
                sync_pages[id].call($('#main-content'), response);
            }
        }, 'json');
    }, 3000);
});

