const result = $('#result');
var closeFilterProdotti = true;
var currentProductId, currentId;
var currentNOrd = 0;
//EVENTO LOAD DEL DOCUMENTO
$(document).ready(function () {
    var filterCliente = $('#filterCliente').val();
    visualizzaClienti(filterCliente);
});
$('#filterCliente').keyup(function () {
    visualizzaClienti($(this).val());
});

$('#addProdotto').click(function (e) {
    e.preventDefault();
    var idProdottoSel = $('#prodottoS').val();
    var qtaS = $('#qtaS').val();
    inserisciProdotto(currentId, idProdottoSel, qtaS, currentNOrd);
});
//EVENTO CLICK DEL BOTTONE SELEZIONE DELLA TABELLA CLIENTE
$("#tblClienti").on("click", "button.seleziona", function () {
    currentId = $(this).data('id');
    //recupero i dati della righa selezionata per poi essere visulizzati nella modal
    let rigaCorrente = $(this).closest("tr");
    //recupero il valore delle colonna della righa sezionata
    let datiCliente = currentId + '# ' + rigaCorrente.find("td:eq(0)").text() + ' ' + rigaCorrente.find("td:eq(1)").text();
    $('#selectedCliente').html(datiCliente);
    $('#filterClienteContainer').hide();
});

//FUNZIONE PER VISUALIZZARE I DATI PRESENTI NELLA TABELLA clienti SUL DATABASE
function visualizzaClienti(filterCliente) {
    //azzero la variabile
    $('#rows').html('');
    //eseguo una chiamata asincrona allo script php che esegue l'operazione di select
    $.ajax({
        url: 'ordini_dt.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            Action: 'selectCliente',
            filter: filterCliente
        }
    }).done(function (dataval) {
        //il risultato in formato JSON viene montato aggiunto alla tabella html presente nella pagina
        if (dataval.status) {
            let row = '';
            var i;
            for (i = 0; i <= dataval.rows - 1; i++) {
                row += '<tr>';
                row += '<th>' + dataval.data[i]['idCliente'] + '</th>';
                row += '<td>' + dataval.data[i]['cognome'] + '</td>';
                row += '<td>' + dataval.data[i]['nome'] + '</td>';
                row += '<td>' + dataval.data[i]['email'] + '</td>';
                row += '<td><button class="btn btn-sm btn-primary seleziona" data-id="' + dataval.data[i]['idCliente'] + '"> Seleziona</button></td>';
                row += '</tr>';
            }
            $('#rows').append(row);
        } else {
            result.html('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        //visualizza la query che viene richiamata
        addToMyConsole(dataval.query);
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}

function inserisciProdotto(idCliente, idProdotto, qta, nOrd) {
    //Nel caso i valori passatti alla funzione fosserto vuoti ritorno un messaggio di allert
    if (qta.length === 0)
        return showMessage('Digita una quantit&agrave;');
    //Eseguo una chiamata asincrona ad uno script PHP che eseguie l'operazione di insert
    //nel database MySql
    $.ajax({
        url: 'ordini_dt.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            Action: 'insertProduct',
            idCliente: idCliente,
            idProdotto: idProdotto,
            qta: qta,
            nOrd: nOrd
        }
    }).done(function (dataval) {
        //Se la query ha avuto successo avviso l'utente e rinfresco i dati della tabella
        if (dataval.status) {
            if (currentNOrd == 0)
                currentNOrd = dataval.nord;
            showMessage('<p>' + dataval.message + '</p>');
            //Reset campi input form
            $('#filterProdotto').val('');
            visualizzaProdotti(currentNOrd);
        } else {
            showMessage('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        //questa funzione permette di visualizzare a video la query che ha eseguito lo script PHP
        addToMyConsole(dataval.query);
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}

//FUNZIONE PER VISUALIZZARE I DATI PRESENTI NELLA TABELLA PRODOTTI
function visualizzaProdotti(nOrd) {
    //azzero la variabile
    $('#tblProdottoRows').html('');
    //eseguo una chiamata asincrona allo script php che esegue l'operazione di select
    $.ajax({
        url: 'ordini_dt.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            Action: 'selectProdotti',
            nOrd: nOrd
        }
    }).done(function (dataval) {
        //il risultato in formato JSON viene montato aggiunto alla tabella html presente nella pagina
        if (dataval.status) {
            let row = '';
            var i;
            for (i = 0; i <= dataval.rows - 1; i++) {
                row += '<tr>';
                row += '<td>' + dataval.data[i]['codpro'] + '</td>';
                row += '<td>' + dataval.data[i]['des'] + '</td>';
                row += '<td>' + dataval.data[i]['qta'] + '</td>';
                row += '</tr>';
            }
            $('#tblProdottoRows').append(row);
        } else {
            result.html('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        //visualizza la query che viene richiamata
        addToMyConsole(dataval.query);
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}
