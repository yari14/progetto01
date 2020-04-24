<?php
include_once '../db.php';
$idCliente = isset($_POST['idCliente']) ? addslashes($_POST['idCliente']) : false;
$msg = '';
$stato = false;
$queryDelete = "DELETE FROM clienti WHERE idCliente = " . intval($idCliente);
if ($idCliente) {
    if (mysqli_query($conn, $queryDelete)) {
        $msg = 'Record Cancellato';
        $stato = true;
    } else {
        $msg = mysqli_error($conn);
    }
}else{
    $msg = 'ID Cliente errato';
}
$retval = array('status' => $stato, 'message' => $msg, 'query' => $queryDelete);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);