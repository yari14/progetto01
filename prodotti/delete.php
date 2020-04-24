<?php
include_once '../db.php';
$idProdotto = isset($_POST['id']) ? addslashes($_POST['id']) : false;
$msg = '';
$stato = false;
$queryDelete = "DELETE FROM prodotti WHERE idProdotto = " . intval($idProdotto);
if ($idProdotto) {
    if (mysqli_query($conn, $queryDelete)) {
        $msg = 'Record Cancellato';
        $stato = true;
    } else {
        $msg = mysqli_error($conn);
    }
}else{
    $msg = 'ID Prodotto errato';
}
$retval = array('status' => $stato, 'message' => $msg, 'query' => $queryDelete);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);