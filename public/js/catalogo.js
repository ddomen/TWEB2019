$(document).ready(()=>{
    var $modal = $('#noleggio-modal');
    var $modal_from = $modal.find('.noleggio-date-from');
    var $modal_to = $modal.find('.noleggio-date-to');

    dateGroupChange($modal_from, console.log)
    

    $('.noleggia').click(function(){
        dateGroupValue($modal_from, null);
        dateGroupValue($modal_to, null);
        $modal.modal('show');
        var id = $(this).parent().parent().find('input[type=hidden]').val();
        var car = CARS.find(car => car.ID == id);
        console.log(car)
        
        $modal.find('.noleggio-modal-targa').text(car.TARGA)
        $modal.find('.noleggio-modal-modello').text(car.Modello)
        $modal.find('.noleggio-modal-marca').text(car.Marca)
        $modal.find('.noleggio-modal-prezzo').text(car.Prezzo)
        $modal.find('.noleggio-modal-posti').text(car.Posti)
        $modal.find('.noleggio-modal-allestimento').text(car.Allestimento)
        var $modal_foto = $modal.find('.noleggio-modal-foto');
        var baseUrl = $modal_foto.attr('data-base')
        $modal_foto.attr('src', baseUrl + car.Foto)

    })
})

function dateGroup($dateGroup){
    return {
        days: $dateGroup.find('.date-days'),
        months: $dateGroup.find('.date-months'),
        years: $dateGroup.find('.date-years')
    };
}

function dateGroupValue($dateGroup, value = undefined){
    var dg = dateGroup($dateGroup);

    if(value !== undefined){
        if(value instanceof Date){
            dg.days.val(value.getDate());
            dg.months.val(value.getMonth());
            dg.years.val(value.getFullYear());
        }
        else if(Array.isArray(value) && value.length >= 3){
            dg.days.val(value[0]);
            dg.months.val(value[1]);
            dg.years.val(value[2]);
        }
        else if(value == null){
            dg.days.val('');
            dg.months.val('');
            dg.years.val('');
        }
    }

    return new Date(parseInt(dg.years.val()), parseInt(dg.months.val()) + 1, parseInt(dg.days.val()));
}

function dateGroupChange($dateGroup, onChange){
    var dg = dateGroup($dateGroup);
    dg.days.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    dg.months.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    dg.years.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    return dg;
}