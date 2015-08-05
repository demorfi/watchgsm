$(function ()
{
    $(document).on('keyup', '.counter', function ()
    {
        var ins = $($(this).data('output'));
        if (ins.length) {
            ins.text($(this).attr('maxlength') - $(this).val().length);
        }
    }).find('.counter').trigger('keyup');

    setInterval(function ()
    {
        var url = location.href.replace(location.search, '') + '?sync=1';
        $.get(url, function (response)
        {
            console.log(response);
        });
    }, 3000);
});

