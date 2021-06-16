$(document).ready(function () {
    $('body').on('click', '#selectAll', function () {
        if ($(this).hasClass('allChecked')) {
            $('input[type="checkbox"]', '#dataTable').prop('checked', false);
        } else {
            $('input[type="checkbox"]', '#dataTable').prop('checked', true);
        }
        $(this).toggleClass('allChecked');
        })
});