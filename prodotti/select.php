<?php
include_once '../db.php';
$codProd = isset($_POST['codProd'])? addslashes($_POST['codProd']):false;
$des = isset($_POST['des'])?addslashes($_POST['des']):false;
$msg = '';
$stato = false;
/*if(!$cognome || !$nome || !$email) {
    $msg = 'Tutti i campi sono obbligatori';
}*/
$querySelect = "SELECT * FROM prodotti ORDER BY idProdotto DESC";

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