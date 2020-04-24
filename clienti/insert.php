<?php
include_once '../db.php';
$cognome = isset($_POST['cognome'])? addslashes($_POST['cognome']):false;
$nome = isset($_POST['nome'])?addslashes($_POST['nome']):false;
$email = isset($_POST['email'])?addslashes($_POST['email']):false;
$msg = '';
$stato = false;
if(!$cognome || !$nome || !$email) {
    $msg = 'Tutti i campi sono obbligatori';
}
$queryInsert = "INSERT INTO clienti (cognome, nome, email) VALUES ('$cognome', '$nome', '$email')";
if(mysqli_query($conn, $queryInsert)){
    $msg = 'Record inserito';
    $stato = true;
}else{
    $msg = mysqli_error($conn);
}
$retval = array('status'=> $stato,'message'=> $msg , 'query' => $queryInsert);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);