$(function() {
    $('#new-expense-modal').on('shown.bs.modal', function () {
        $('#new-expense-title').focus()
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
        if ($('#new-expense-title').val() === '' || $('#new-expense-amount').val() === '') {
            toastr.warning('You must enter title and amount');
            return false;
        } else {
            return true;
        }
    })

});