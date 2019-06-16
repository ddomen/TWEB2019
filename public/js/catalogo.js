$(document).ready(()=>{
    var $modal = $('#noleggio-modal');
    var $modal_from = $modal.find('.noleggio-date-from input');
    var $modal_to = $modal.find('.noleggio-date-to input');

    
    var today = new Date();
    today.setHours(0);
    today.setMinutes(0);
    today.setSeconds(0);
    today.setMilliseconds(0);
    var noleggio_from_date = today,
        noleggio_to_date = today;

    $modal_from.on('changeDate', (evt) => {
        noleggio_from_date = evt.date;
        rispostaModal($modal, null);
    });
    $modal_to.on('changeDate', (evt) => {
        noleggio_to_date = evt.date;
        rispostaModal($modal, null);
    })

    var currentCar = null;
    

    $('.noleggia').click(function(){
        $modal_from.datepicker('setValue', '')
        $modal_to.datepicker('setValue', '')
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
            window.location.href = "noleggia/id/" + currentCar.ID + '/from/' + getDateUrl(noleggio_from_date) + '/to/' + getDateUrl(noleggio_to_date);
        }
    });
})

function getDateUrl(date){
    return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate()
}

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
            data: { inizio: getDateUrl(inizio), fine: getDateUrl(fine), macchina: macchina },
            dataType: 'json',
            success: function(res){ rispostaModal($modal, res.testo, res.tipo); }
        });
    }
    else{
        rispostaModal($modal, 'Inserisci date valide', 'warning');
    }
}

function rispostaModal($modal, testo, tipo){
    var $target = $modal.find('.noleggio-modal-risposta');
    $target.removeClass('alert-success alert-danger alert-warning')
    
    if(testo != null){ $target.addClass('alert-' + tipo).text(testo); }
    else{ $target.text(''); }

    if(tipo == 'success'){ $modal.find('.noleggia-btn').removeAttr('disabled') }
    else{ $modal.find('.noleggia-btn').attr('disabled', true) }
}

function isValidDate(d) { return d instanceof Date && !isNaN(d); }