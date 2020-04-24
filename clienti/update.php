<?php
include_once '../db.php';
//INIZIALIZZO VARABILI
$msg = '';
$stato = false;
$campi = '';
$queryUpdate = '';
//RECUPERO I DATI INVIATI TRAMITE POST
$idCliente = isset($_POST['idCliente']) ? addslashes($_POST['idCliente']) : false;
$cognome = isset($_POST['cognome']) ? addslashes($_POST['cognome']) : false;
$nome = isset($_POST['nome']) ? addslashes($_POST['nome']) : false;
$email = isset($_POST['email']) ? addslashes($_POST['email']) : false;
//CONCATENO I CAMPI E PREPARO LA QUERY DI UPDATE
if ($cognome)
    $campi .= "cognome = '$cognome',";
if ($nome)
    $campi .= "nome = '$nome',";
if ($email)
    $campi .= "email = '$email',";
//RIMUOVO L'ULTIMO CARATTERE SARA' SEMPRE UNA ,
$campi = substr($campi, 0, -1);
if ($campi) {
    $queryUpdate = "UPDATE clienti SET $campi WHERE idCliente = " . intval($idCliente);
    if ($idCliente) {
        if (mysqli_query($conn, $queryUpdate)) {
            $msg = 'Record aggiorato';
            $stato = true;
        } else {
            $msg = mysqli_error($conn);
        }
    } else {
        $msg = 'ID Cliente errato';
    }
} else {
    $msg = 'Errore campi';
}
$retval = array('status' => $stato, 'message' => $msg, 'query' => $queryUpdate);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);