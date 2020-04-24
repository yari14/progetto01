<?php
include_once 'db.php';
$msg = 'Azione sconosciuta o non implementata';
$stato = false;
do {
    switch ($_REQUEST['Action']) {
        case 'selectCliente':
            $where = '';
            $filter = isset($_POST['filter']) ? addslashes($_POST['filter']) : false;
            if ($filter)
                $where = "WHERE cognome LIKE '%$filter%' OR nome LIKE '%$filter%' ";
            $querySelect = "SELECT * FROM clienti $where ORDER BY updated_at DESC LIMIT 20";
            $result = mysqli_query($conn, $querySelect);
            if ($result->num_rows > 0){
                $stato = true;
                $msg = "Hai selezionato " . $result->num_rows . " clienti" ;
            }

            $resultArr = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $resultArr[] = $row;
            }
            $retval = array('status' => $stato, 'message' => $msg, 'data' => $resultArr, 'rows' => $result->num_rows, 'query' => $querySelect);
            break;
        case 'selectProdotti':
            $where = '';
            $nOrd = isset($_POST['nOrd']) ? addslashes($_POST['nOrd']) : false;
            if ($nOrd ) {
                $where = "WHERE ordini.nOrd = $nOrd";
            } else {
                $msg = 'Numero ordine non valido';
            }
            $querySelect = "SELECT ordini.idOrdine, ordini.nOrd, ordini.idProdotto, prod.codpro, prod.des, ordini.qta FROM ordini ";
            $querySelect .= "INNER JOIN prodotti AS prod ON ordini.idProdotto = prod.idProdotto $where ORDER BY ordini.idOrdine DESC";
            $result = mysqli_query($conn, $querySelect);
            if ($result->num_rows > 0){
                $stato = true;
                $msg = "Hai " . $result->num_rows . " prodotti nel tuo ordine" ;
            }
            $resultArr = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $resultArr[] = $row;
            }
            $retval = array('status' => $stato, 'message' => $msg, 'data' => $resultArr, 'rows' => $result->num_rows, 'query' => $querySelect);
            break;
        case 'insertProduct':
            $queryInsert = '';
            $q = '';
            $queryInsert = '';
            $nOrd = isset($_POST['nOrd']) ? addslashes($_POST['nOrd']) : 0;
            $idCliente = isset($_POST['idCliente']) ? addslashes($_POST['idCliente']) : false;
            $idProdotto = isset($_POST['idProdotto']) ? addslashes($_POST['idProdotto']) : false;
            $qta = isset($_POST['qta']) ? addslashes($_POST['qta']) : false;
            //verifico che il numero ordine sia valorizzato
            if ($nOrd == '0') {
                //se il numero ordine è 0 genero un nuovo numero ordine
                $anno = date('Y');
                $queryNuovoNumOrd = " SELECT MAX(nOrd) nOrd FROM z_numeratoreord WHERE anno = $anno ";
                $result = mysqli_query($conn, $queryNuovoNumOrd);
                $result_nord = mysqli_fetch_assoc($result);
                if (intval($result_nord['nOrd']) > 0) {
                    $result_nord = $result_nord['nOrd'] + 1;
                    $q = "INSERT INTO z_numeratoreord (anno, nOrd) VALUES ($anno, $result_nord)";
                    if (mysqli_query($conn, $q)) {
                        $msg = 'nuovo numeraore numeratore inserito<br>';
                    } else {
                        $msg = mysqli_error($conn);
                    }
                }
            } else {
                $result_nord = $nOrd;
            }
            $msg = '';
            $queryInsert = "INSERT INTO ordini (idCliente, nOrd, idProdotto, qta) VALUES ('$idCliente', '$result_nord', '$idProdotto', $qta)";
            if (mysqli_query($conn, $queryInsert)) {
                $msg .= 'Record inserito';
                $stato = true;
            } else {
                $msg = mysqli_error($conn);
            }
            $retval = array('status' => $stato, 'message' => $msg, 'query' => $queryInsert .'<br>'.$q.'<br>'. $queryInsert, 'nord'=> $result_nord);
            break;
        default:
            $retval = array("status" => $stato, "message" => $msg);
            break;
    }
} while (false);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($retval);