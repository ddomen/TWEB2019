var LAST_PAGE = 1;

$(document).ready(()=>{
    window.$modal = $('#noleggio-modal');
    window.$modal_from = $modal.find('.noleggio-date-from input');
    window.$modal_to = $modal.find('.noleggio-date-to input');
    
    window.today = new Date();
    today.setHours(0);
    today.setMinutes(0);
    today.setSeconds(0);
    today.setMilliseconds(0);
    
    window.noleggio_from_date = today;
    window.noleggio_to_date = today;

    $modal_from.on('changeDate', (evt) => {
        noleggio_from_date = evt.date;
        rispostaModal($modal, null);
    });
    $modal_to.on('changeDate', (evt) => {
        noleggio_to_date = evt.date;
        rispostaModal($modal, null);
    })

    window.currentCar = null;

    $modal.find('.noleggia-check-btn').click(()=>{
        checkDateNoleggio($modal, noleggio_from_date, noleggio_to_date, currentCar.ID);
    })

    $modal.find('.noleggia-btn').click(()=>{
        if(currentCar && isValidDate(noleggio_from_date) && isValidDate(noleggio_to_date)){
            window.location.href = "noleggia/id/" + currentCar.ID + '/from/' + getDateUrl(noleggio_from_date) + '/to/' + getDateUrl(noleggio_to_date);
        }
    });

    $('#catalogo-search-form').on('submit', (e)=>{ e.preventDefault(); getCatalogo(); })
    getCatalogo();

    $('.catalogo-search-firstPage').click(()=>{ setPaginatorPage(1, true); });
    $('.catalogo-search-prevPage').click(()=>{ setPaginatorPage(-1); });
    $('.catalogo-search-nextPage').click(()=>{ setPaginatorPage(1); });
    $('.catalogo-search-lastPage').click(()=>{ setPaginatorPage(-1, true); });
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
            url: baseUrl('api/checknoleggio'),
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

function getCatalogo(filtri = null, $container){
    filtri = filtri || getCatalogoSearchData();
    $container = $container || $('.contenitore-catalogo');
    $.ajax({
        type: 'POST',
        url: baseUrl('api/catalog'),
        dataType: 'json',
        data: filtri,
        success: function(res){
            LAST_PAGE = Math.ceil(res.totale / 5) || 1;
            CARS = res.data;
            renderCatalogo(res.data, $container);
            setPaginatorPage(null);
        }
    })
}

function renderCatalogo(catalogo, $container){
    $container.empty();
    if(!catalogo.length){
        $container.append('<div class="alert alert-warning">Nessuna auto trovata con questi criteri</div>')
    }
    for(const macchina of catalogo){
        const component = `
            <div class="panel panel-default">
            <div class="panel-heading panel-primary"><h3><b>` + macchina.Marca + ` - ` + macchina.Modello + `</h3></b></div>
            <div class="panel-body">
        
            <div class="row">
            <div class="col-xs-6 col-sm-3">
                <img src="` + baseUrl('images/vetture/') + macchina.Foto +`" class="img-responsive"/>
            </div>
            <div class="col-xs-18 col-sm-9">
                <p style="float:left;">
                  <input type="hidden" name="car" value="`+ macchina.ID + `" />`
                + ((LAYOUT == 'staff' || LAYOUT == 'admin') ? `                  
                  <p><button class="btn btn-primary" style="font-size: 2em" onclick="window.location.href = '`
                  + baseUrl(LAYOUT+'/editmacchina/id/'+macchina.ID) +
                  `'">MODIFICA</button></p>
                  <br>             
                  <p>
                    <button class="btn btn-danger" style="font-size: 2em" onclick="if(window.confirm('Sicuro di voler eliminare l\\'auto `+ macchina.Marca +` - ` + macchina.Modello + ` - ` + macchina.TARGA + `?')){
                      window.location.href = '`+ baseUrl(LAYOUT+'/deletemacchina/id/'+macchina.ID) + `'}">ELIMINA</button>
                  </p>
                  ` : '') + (LAYOUT == 'user' ? `<p><button class="btn btn-primary noleggia" style="font-size: 2em">NOLEGGIA</button></p>` : '') +
                `</p>
                <p><b><p align="right" style="font-size: 2em">` + parseFloat(macchina.Prezzo).toFixed(2) + `€/giorno</p></b></p>
                <br>
                <p style="clear:left"><b>Posti: </b>` + macchina.Posti + `</p>
                <p><b>Allestimento: </b>` + macchina.Allestimento + `</p>
                <p><b>Targa: </b>` + macchina.TARGA + `</p>
            </div>
            <div class="clearfix visible-xs-block"></div></div>
            </div>
        </div>`;
        $container.append($(component));
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
            $modal_foto.attr('src', baseUrl('images/vetture/'+ currentCar.Foto))
    
            rispostaModal($modal, null, null);
    
        });
    }
}

function getCatalogoSearchData(){
    var result = {
        modello: $('#catalogo-search-modello').val(),
        marca: $('#catalogo-search-marca').val(),
        posti: $('#catalogo-search-posti').val(),
        prezzoMin: $('#catalogo-search-prezzoMin').val(),
        prezzoMax: $('#catalogo-search-prezzoMax').val(),
        from: $('#catalogo-search-from').val(),
        to: $('#catalogo-search-to').val(),
        allestimento: $('#catalogo-search-allestimento').val(),
        order: $('#catalogo-search-order').val(),
        page: $('#catalogo-search-page').val()
    }
    for(var k of Object.keys(result)){ if(result[k] == '' || result[k] == null){ delete result[k]; } }
    return result;
}

function setPaginatorPage(page, absolute){
    $page = $('#catalogo-search-page');

    var refresh = page != null;

    if(page == null){ page = parseInt($page.val()); }
    else{
        if(!absolute){ page = parseInt($page.val()) + page; }
        else if(page == -1){ page = LAST_PAGE; }
    }
    page = Math.min(Math.max(1, page), LAST_PAGE);

    $page.val(page);
    $('.catalogo-search-pageDisplay').text(page + ' / ' + LAST_PAGE);
    if(refresh){ getCatalogo(); }
}