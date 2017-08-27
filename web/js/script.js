$(function() {

    $('#new-expense-modal').on('shown.bs.modal', function () {
        $('#new-expense-title').focus()
    });

    $('#create-expense-btn').on('click', function() {
        $('#create-expense-form').submit();
    });
});