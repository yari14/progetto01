<?php
include_once '../db.php';
//INIZIALIZZO VARABILI
$msg = '';
$stato = false;
$campi = '';
$queryUpdate = '';
//RECUPERO I DATI INVIATI TRAMITE POST
$idProdotto = isset($_POST['idProdotto']) ? addslashes($_POST['idProdotto']) : false;
$codPro = isset($_POST['codPro']) ? addslashes($_POST['codPro']) : false;
$des = isset($_POST['des']) ? addslashes($_POST['des']) : false;
//CONCATENO I CAMPI E PREPARO LA QUERY DI UPDATE
if ($codPro)
    $campi .= "codpro = '$codPro',";
if ($des)
    $campi .= "des = '$des',";
//RIMUOVO L'ULTIMO CARATTERE SARA' SEMPRE UNA ,
$campi = substr($campi, 0, -1);
if ($campi) {
    $queryUpdate = "UPDATE prodotti SET $campi WHERE idProdotto = " . intval($idProdotto);
    if ($idProdotto) {
        if (mysqli_query($conn, $queryUpdate)) {
            $msg = 'Record aggiorato';
            $stato = true;
        } else {
            $msg = mysqli_error($conn);
        }
    } else {
        $msg = 'ID Prodotto errato';
    }
} else {
    $msg = 'Errore campi ricevuti';
}
$retval = array('status' => $stato, 'message' => $msg, 'query' => $queryUpdate);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);