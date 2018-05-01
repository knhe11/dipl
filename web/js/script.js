function addItem(th,e)
{
    e.preventDefault();
    var url = $(th).attr('href'),
        check_value = $('#items-forms').find('input'),
        rows = $('#items-forms').find('tr');
    // влидация на пустые поля
    for(var i=0,l=check_value.length;i<l;i++)
    {
        if ($(check_value[i]).val() == '') {
            alert('Не все поля заполнены');
            return false;
        }
    }
    // валидация по размерам
    if (rows.length > 1)
        for(var r=1,l=rows.length;r<l;r++) {
            let width_row = $(rows[r]).find('[data-width]').val(),
                height_row = $(rows[r]).find('[data-height]').val(),
                param_height_error = true,
                param_width_error = true;
            if ((window.limit.maxHeight.height >= height_row) &&
                (window.limit.maxHeight.width >= width_row)) {
                param_height_error = false;
            }
            if ((window.limit.maxWidth.height >= height_row ) &&
                window.limit.maxWidth.width >= width_row) {
                param_width_error = false;
            }
            if (param_height_error && param_width_error) {
                alert('Ошибка ввода размеров детали ' + height_row + 'х' + width_row);
                return false;
            }
        }
    // валидация введеных параметров
    $.post(url,'',function(data){
        if (data.status == true)
        {
            $('#items-forms').find('tbody').append(data.form);
        }
    });
}
function rmItem(th,e)
{
    e.preventDefault();
    $(th).closest('tr').remove();
}
