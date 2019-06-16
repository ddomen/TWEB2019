$(document).ready(()=>{
    $('.bs-datepicker').datepicker()
    .on('changeDate', function(ev){
        //Converte il formato inglese della data in italiano
        $(this).val(formatNumber(ev.date.getDate()) + '/' + formatNumber(ev.date.getMonth()) + '/' + formatNumber(ev.date.getFullYear()))
    });
});