<?php
$title = 'Ordini';
include_once 'include/header.php';
include_once 'include/menu.php';
include_once 'db.php';
$queryOrdini = "SELECT ordini.nOrd, cli.cognome, cli.nome, COUNT(ordini.idProdotto) AS nRighe, SUM(ordini.qta) AS qtaTot FROM ordini\n"
    . "INNER JOIN prodotti AS prod ON ordini.idProdotto = prod.idProdotto\n"
    . "INNER JOIN clienti AS cli ON ordini.idCliente = cli.idCliente\n"
    . "GROUP BY nOrd, cognome, nome\n"
    . "ORDER BY nOrd DESC";
$result = mysqli_query($conn, $queryOrdini);

?>
<main role="main" class="container">
    <h3>Ordini</h3>
    <div class="mx-auto" style="width: 200px;">
        <a href="ordine_new.php" class="btn btn-success btn-sm mb-2" id="addOrder">Aggiungi Nuovo Ordine</a>
    </div>
    <div class="row">
        <table class="table" id="tblClienti">
            <thead>
            <tr>
                <th scope="col">N°Ordine</th>
                <th scope="col">Cognome</th>
                <th scope="col">Nome</th>
                <th scope="col">N°Righe Totali</th>
                <th scope="col">Quantit&agrave; Totale</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="rows">
            <?php
            while ($row = mysqli_fetch_assoc($result)){
                echo '<tr>';
                echo '<td>'.$row['nOrd'].'</td>';
                echo '<td>'.$row['cognome'].'</td>';
                echo '<td>'.$row['nome'].'</td>';
                echo '<td>'.$row['nRighe'].'</td>';
                echo '<td>'.$row['qtaTot'].'</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<?php include_once 'include/footer.php'; ?>
