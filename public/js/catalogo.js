$(document).ready(()=>{
    var $modal = $('#noleggio-modal');
    var $modal_from = $modal.find('.noleggio-date-from');
    var $modal_to = $modal.find('.noleggio-date-to');

    var noleggio_from_date, noleggio_to_date;

    //TODO: fare il controllo in ajax
    dateGroupChange($modal_from, d =>{
        rispostaModal($modal, null, null);
        noleggio_from_date = d;
    });
    dateGroupChange($modal_to, d =>{
        rispostaModal($modal, null, null);
        noleggio_to_date = d;
    });

    var currentCar = null;
    

    $('.noleggia').click(function(){
        dateGroupValue($modal_from, null);
        dateGroupValue($modal_to, null);
        $modal.modal('show');
        var id = $(this).parent().parent().find('input[type=hidden]').val();
        currentCar = CARS.find(car => car.ID == id);
        
        $modal.find('.noleggio-modal-targa').text(currentCar.TARGA)
        $modal.find('.noleggio-modal-modello').text(currentCar.Modello)
        $modal.find('.noleggio-modal-marca').text(currentCar.Marca)
        $modal.find('.noleggio-modal-prezzo').text(currentCar.Prezzo)
        $modal.find('.noleggio-modal-posti').text(currentCar.Posti)
        $modal.find('.noleggio-modal-allestimento').text(currentCar.Allestimento)
        var $modal_foto = $modal.find('.noleggio-modal-foto');
        var baseUrl = $modal_foto.attr('data-base')
        $modal_foto.attr('src', baseUrl + currentCar.Foto)

        rispostaModal($modal, null, null);

    })

    $modal.find('.noleggia-check-btn').click(()=>{
        checkDateNoleggio($modal, noleggio_from_date, noleggio_to_date, currentCar.ID);
    })

    $modal.find('.noleggia-btn').click(()=>{
        if(currentCar && isValidDate(noleggio_from_date) && isValidDate(noleggio_to_date)){
            window.location.href = "noleggia/id/" + currentCar.ID + '/from/' + noleggio_from_date.toJSON() + '/to/' + noleggio_to_date.toJSON();
        }
    });
})

function checkDateNoleggio($modal, inizio, fine, macchina){
    var now = new Date();
    now.setHours(0);
    now.setMinutes(0);
    now.setSeconds(0);
    now.setMilliseconds(0);
    if(inizio < now || fine < now){
        rispostaModal($modal, 'Le date devono essere successive o uguali alla data attuale', 'danger');
    }
    else if(isValidDate(inizio) && isValidDate(fine) && macchina){
        $.ajax({
            type: 'POST',
            url: window.location.href.replace(/public\/.*/, 'public/api/checknoleggio'),
            data: { inizio: inizio.toJSON(), fine: fine.toJSON(), macchina: macchina },
            dataType: 'json',
            success: function(res){ rispostaModal($modal, res.testo, res.tipo); }
        });
    }
}

function rispostaModal($modal, testo, tipo){
    var $target = $modal.find('.noleggio-modal-risposta');
    $target.removeClass('alert-success alert-danger')
    
    if(testo != null){ $target.addClass('alert-' + tipo).text(testo); }
    else{ $target.text(''); }

    if(tipo == 'success'){ $modal.find('.noleggia-btn').removeAttr('disabled') }
    else{ $modal.find('.noleggia-btn').attr('disabled', true) }
}

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

    var result = new Date(parseInt(dg.years.val()), parseInt(dg.months.val()) - 1, parseInt(dg.days.val()));
    console.log(result.toJSON());
    return result;
}

function dateGroupChange($dateGroup, onChange){
    var dg = dateGroup($dateGroup);
    dg.days.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    dg.months.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    dg.years.on('change', (e) => { onChange(dateGroupValue($dateGroup), dg, e) })
    return dg;
}

function isValidDate(d) { return d instanceof Date && !isNaN(d); }