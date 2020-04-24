const result = $('#result');
var currentId;
//EVENTO LOAD DEL DOCUMENTO
$(document).ready(function () {
    visualizzaClienti();
});
//EVENTO CLICK DEL TASTO AGGIUNGI
$('#addCliente').click(function (e) {
    e.preventDefault();
    var cognome = $('#cognome').val(); //sintatti standard JS document.getElementById("cognome").value
    var nome = $('#nome').val();
    var email = $('#email').val();
    inserisciCliente(cognome, nome, email);
});
//EVENTO CLICK DEL BOTTONE CANCELLA DELLA TABELLA
$("#tblClienti").on("click", "button.cancella", function () {
    cancellaCliente($(this).data('id'));
});
//EVENTO CLICK DEL BOTTONE MODIFICA DELLA TABELLA
$("#tblClienti").on("click", "button.modifica", function () {
    currentId = $(this).data('id');
    //recupero i dati della righa selezionata per poi essere visulizzati nella modal
    let rigaCorrente = $(this).closest("tr");
    //recupero il valore delle colonna della righa sezionata
    let cognomeCor = rigaCorrente.find("td:eq(0)").text();
    let nomeCor = rigaCorrente.find("td:eq(1)").text();
    let emailCor = rigaCorrente.find("td:eq(2)").text();
    $('#cognomeEdit').val(cognomeCor);
    $('#nomeEdit').val(nomeCor);
    $('#emailEdit').val(emailCor);
    $('#editClienteModal').modal('show');
});
//EVENTO CLICK DEL BTN AGGIORNA DATI DENTRO LA MODAL
$('#salvaModifica').click(function (e) {
    e.preventDefault();
    var cognomeEdit = $('#cognomeEdit').val();
    var nomeEdit = $('#nomeEdit').val();
    var emailEdit = $('#emailEdit').val();
    aggiornaCliente(currentId,cognomeEdit,nomeEdit,emailEdit);
    $('#editClienteModal').modal('hide');
});
//FUNZIONE PER AGGIUNGERE UN NUOVO CLIENTE
function inserisciCliente(cognome, nome, email) {
    //Nel caso i valori passatti alla funzione fosserto vuoti ritorno un messaggio di allert
    if (cognome.length === 0 || nome.length === 0 || email.length === 0)
        return showMessage('Compilare tutti i campi');
    //Eseguo una chiamata asincrona ad uno script PHP che eseguie l'operazione di insert
    //nel database MySql
    $.ajax({
        url: 'clienti/insert.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            cognome: cognome,
            nome: nome,
            email: email
        }
    }).done(function (dataval) {
        //Se la query ha avuto successo avviso l'utente e rinfresco i dati della tabella
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
            visualizzaClienti();
            //Reset campi input form
            $('#cognome').val('');
            $('#nome').val('');
            $('#email').val('');
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
//FUNZIONE PER VISUALIZZARE I DATI PRESENTI NELLA TABELLA clienti SUL DATABASE
function visualizzaClienti() {
    //azzero la variabile
    $('#rows').html('');
    //eseguo una chiamata asincrona allo script php che esegue l'operazione di select
    $.ajax({
        url: 'clienti/select.php',
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
                row += '<th>' + dataval.data[i]['idCliente'] + '</th>';
                row += '<td>' + dataval.data[i]['cognome'] + '</td>';
                row += '<td>' + dataval.data[i]['nome'] + '</td>';
                row += '<td>' + dataval.data[i]['email'] + '</td>';
                row += '<td><button class="btn btn-sm btn-warning modifica" data-id="' + dataval.data[i]['idCliente'] + '"> Modifica</button></td>';
                row += '<td><button class="btn btn-sm btn-danger cancella" data-id="' + dataval.data[i]['idCliente'] + '"> Cancella</button></td>';
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
function cancellaCliente(idCliente) {
    //chiamata ajax allo script PHP per la cancellazione del record
    $.ajax({
        url: 'clienti/delete.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            idCliente: idCliente
        }
    }).done(function (dataval) {
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
        } else {
            showMessage('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        addToMyConsole(dataval.query);
        //richiamo la funzione per ricaricare a video i dati della tabella clienti
        visualizzaClienti();
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}
//FUNZIONE PER L'AGGIONAMENTO DEL RECORD SELEZIONATO
function aggiornaCliente(idCliente, cognome, nome, email) {
    //chiamata ajax allo script PHP per la cancellazione del record
    $.ajax({
        url: 'clienti/update.php',
        quietMillis: 100,
        dataType: 'json',
        type: "POST",
        data: {
            idCliente: idCliente,
            cognome: cognome,
            nome: nome,
            email: email
        }
    }).done(function (dataval) {
        if (dataval.status) {
            showMessage('<p>' + dataval.message + '</p>');
        } else {
            showMessage('<p style="color: #FF0000">' + dataval.message + '<br>' + dataval.query + '</p>');
        }
        addToMyConsole(dataval.query);
        //richiamo la funzione per ricaricare a video i dati della tabella clienti
        visualizzaClienti();
    }).fail(function (jqXHR, textStatus) {
        //in caso di problemi di collegamento ritorno un messaggio d'errore.
        var message = 'Errore nel collegamento ai sistemi riprovare in seguito';
        alert(message);
    });
}