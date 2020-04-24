<?php
include_once '../db.php';
$cognome = isset($_POST['cognome'])? addslashes($_POST['cognome']):false;
$nome = isset($_POST['nome'])?addslashes($_POST['nome']):false;
$email = isset($_POST['email'])?addslashes($_POST['email']):false;
$msg = '';
$stato = false;
/*if(!$cognome || !$nome || !$email) {
    $msg = 'Tutti i campi sono obbligatori';
}*/
$querySelect = "SELECT * FROM clienti ORDER BY idCliente DESC";

$result =mysqli_query($conn, $querySelect);
if($result->num_rows > 0)
    $stato = true;
//
$resultArr = array();
while($row = mysqli_fetch_assoc($result)){
    $resultArr[] = $row;
}


$retval = array('status'=> $stato,'message'=> $msg , 'data'=> $resultArr, 'rows'=> $result->num_rows,'query' => $querySelect);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);