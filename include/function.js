//FUNZIONE CHE PERMETTE DI AGGIUNGERE TESTO AD UN TAG HTML
//OGNI QUALVOTA LA FUNZIONE VIENE RICHIAMATA IL TESTO
//VIENE SOSTITUITO
function showMessage(msg) {
    return result.html(msg);
}

//FUNZIONE SIMILE ALLA PRECEDENTE MA IL TESTO VA IN AGGIUNTA
function addToMyConsole(value) {
    var nowDt = new Date();
    var secondi = nowDt.getMilliseconds();
    var minuti = nowDt.getMinutes();
    var ora = nowDt.getHours();
    var now = ora + ':' + minuti + ':' + secondi.toString().substring(0, 2);
    $('#console').prepend('[' + now + '] $ ' + value + '<br>');
}