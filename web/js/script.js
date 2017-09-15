$(function() {
    $('#new-expense-modal').on('shown.bs.modal', function () {
        $('#new-expense-amount').focus();
    });

    $('#create-expense-btn').on('click', function() {
        $('#create-expense-form').submit();
    });

    var $createExpenseForm = $('#create-expense-form');
    $createExpenseForm.on('keyup', function(event) {
        if (event.keyCode === 13) {
            $(this).submit();
        }
    });
    $createExpenseForm.on('submit', function() {
        var amountValue = $('#new-expense-amount').val();
        if (amountValue === '') {
            toastr.warning('You must enter valid amount');
            return false;
        }
        return true;
    })

});