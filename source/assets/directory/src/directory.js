jQuery(function ($) {
    $('#addBtn').click(() => {
        $('#modalTitle').html("Добавить элемент")
        $('#modalForm').trigger("reset")
        $('#modalForm').attr("action", urlAdd)
        $('#modal').modal('show')
        return false
    })
    $('[data-action="edit"]').click(clickEdit)
})

function clickEdit() {
    $('#modalTitle').html("Изменить элемент")
    $('#modalForm').trigger("reset")
    $('#modalForm').attr("action", urlEdit)
    $('#modal').modal('show')
    $(this).each(function () {
        $.each(this.attributes, function () {
            if (this.specified) {
                if (this.name.indexOf('attr-') === 0) {
                    let name = this.name.replace('attr-', '')
                    $('#' + dir + '-' + name).val(this.value)
                }
            }
        });
    });
    return false
}