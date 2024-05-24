$(document).ready(function () {


    $('.datetimepicker').datetimepicker({
        locale: 'es',
        format: 'DD-MM-YYYY',
        daysOfWeekDisabled: [0, 6],
        maxDate: $.now()
    });

});


