<?php
include_once '../db.php';
$codpro = isset($_POST['codpro'])? addslashes($_POST['codpro']):false;
$des = isset($_POST['des'])?addslashes($_POST['des']):false;
$msg = '';
$stato = false;
if(!$codpro || !$des) {
    $msg = 'Tutti i campi sono obbligatori';
}
$queryInsert = "INSERT INTO prodotti (codpro, des) VALUES ('$codpro', '$des')";
if(mysqli_query($conn, $queryInsert)){
    $msg = 'Record inserito';
    $stato = true;
}else{
    $msg = mysqli_error($conn);
}
$retval = array('status'=> $stato,'message'=> $msg , 'query' => $queryInsert);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);