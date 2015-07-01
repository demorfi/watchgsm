$(function ()
{
    $(document).on('keyup', '.counter', function ()
    {
        var ins = $($(this).data('output'));
        if (ins.length) {
            ins.text($(this).attr('maxlength') - $(this).val().length);
        }
    }).find('.counter').trigger('keyup');
});

