$(document).ready(()=>{
    const now = new Date();
    $('.bs-datepicker').datepicker({ format: 'dd/mm/yyyy' })
    $('.bs-datepicker-today').datepicker({
        format: 'dd/mm/yyyy',
        onRender: function(date) { return date < now ? 'disabled' : ''; }
    })
});