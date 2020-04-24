const result = $('#result');
var currentId;
//EVENTO LOAD DEL DOCUMENTO
$(document).ready(function () {
    visualizzaProdotti();
});
//EVENTO CLICK DEL TASTO AGGIUNGI
$('#addProdotto').click(function (e) {
    e.preventDefault();
    var codpro = $('#codProd').val();
    var des = $('#des').val();
    inserisciProdotto(codpro, des);
});
//EVENTO CLICK DEL BOTTONE CANCELLA DELLA TABELLA
$("#tblProdotti").on("click", "button.cancella", function () {
    cancellaProdotto($(this).data('id'));
});
//EVENTO CLICK DEL BOTTONE MODIFICA DELLA TABELLA
$("#tblProdotti").on("click", "button.btn-warning", function () {
    currentId = $(this).data('id');
    //recupero i dati della righa selezionata per poi essere visulizzati nella modal
    let rigaCorrente = $(this).closest("tr");
    //recupero il valore delle colonna della righa sezionata
    let codProCor = rigaCorrente.find("td:eq(0)").text();
    let desCor = rigaCorrente.find("td:eq(1)").text();
    $('#codProdEdit').val(codProCor);
    $('#desEdit').val(desCor);
    $('#editProdottoModal').modal('show');
});
//EVENTO CLICK DEL BTN AGGIORNA DATI DENTRO LA MODAL
$('#salvaModifica').click(function (e) {
    e.preventDefault();
    var codProEdit = $('#codProdEdit').val();
    var desEdit = $('#desEdit').val();
    aggiornaProdotto(currentId, codProEdit, desEdit);
    $('#editProdottoModal').modal('hide');
});

//FUNZIONE PER AGGIUNGERE UN NUOVO PRODOTTO
function inserisciProdotto(codpro, des) {
    //Nel caso i valori passatti alla funzione fosserto vuoti ritorno un messaggio di allert
    if (codpro.length === 0 || des.length === 0)
        return showMessage('Compilare tutti i campi');
    //Eseguo una chiamata asincrona ad uno script PHP che eseguie l'operazione di insert
    //nel database MySql
    $.ajax({
        url: 'prodotti/insert.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            codpro: codpro,
            des: des
        }
    }).done(function (dataval) {
        //Se la query ha avuto successo avviso l'utente e rinfresco i dati della tabella
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
            visualizzaProdotti();
            //Reset campi input form
            $('#codpro').val('');
            $('#des').val('');
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

//FUNZIONE PER VISUALIZZARE I DATI PRESENTI NELLA TABELLA prodotti SUL DATABASE
function visualizzaProdotti() {
    //azzero la variabile
    $('#rows').html('');
    //eseguo una chiamata asincrona allo script php che esegue l'operazione di select
    $.ajax({
        url: 'prodotti/select.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            /*cognome: cognome,
            nome: nome,
            email: email*/
        }
    }).done(function (dataval) {
        //il risultato in formato JSON viene montato aggiunto alla tabella html presente nella pagina
        if (dataval.status) {
            let row = '';
            var i;
            for (i = 0; i <= dataval.rows - 1; i++) {
                row += '<tr>';
                row += '<th>' + dataval.data[i]['idProdotto'] + '</th>';
                row += '<td>' + dataval.data[i]['codpro'] + '</td>';
                row += '<td>' + dataval.data[i]['des'] + '</td>';
                row += '<td><button class="btn btn-sm btn-warning" data-id="' + dataval.data[i]['idProdotto'] + '"> Modifica</button></td>';
                row += '<td><button class="btn btn-sm btn-danger cancella" data-id="' + dataval.data[i]['idProdotto'] + '"> Cancella</button></td>';
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

//FUNZIONE PER LA CANCELLAZIONE DEL RECORD NEL DB
function cancellaProdotto(idProdotto) {
    //chiamata ajax allo script PHP per la cancellazione del record
    $.ajax({
        url: 'prodotti/delete.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            id: idProdotto
        }
    }).done(function (dataval) {
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
        } else {
            showMessage('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        addToMyConsole(dataval.query);
        //richiamo la funzione per ricaricare a video i dati della tabella prodotti
        visualizzaProdotti();
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}

//FUNZIONE PER L'AGGIONAMENTO DEL RECORD SELEZIONATO
function aggiornaProdotto(idProdotto, codPro, des) {
    //chiamata ajax allo script PHP per la cancellazione del record
    $.ajax({
        url: 'prodotti/update.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            idProdotto: idProdotto,
            codPro: codPro,
            des: des
        }
    }).done(function (dataval) {
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
        } else {
            showMessage('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        addToMyConsole(dataval.query);
        //richiamo la funzione per ricaricare a video i dati della tabella prodotti
        visualizzaProdotti();
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}