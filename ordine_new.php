<?php
$title = 'Nuovo Ordine';
include_once 'include/header.php';
include_once 'include/menu.php';
include_once 'db.php';
?>
<main role="main" class="container">
    <h3>Nuovo Ordine</h3>
    <div class="row">
        <div class="col" id="result"></div>
    </div>
    <div class="row" id="filterClienteContainer">
        <div class="col">
            <h5>Aggiungi Cliente <span id="nRighe"></span></h5>
            <form method="post">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="filterCliente">Cerca Cliente: </label>
                        <input class="form-control mb-2 form-control-sm" type="text" id="filterCliente">
                    </div>
                </div>
            </form>
            <div class="row">
                <table class="table" id="tblClienti">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cognome</th>
                        <th scope="col">Nome</th>
                        <th scope="col">E-Mail</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="rows">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="selectedCliente"></div>
    </div>
    <?php
    $selectProdotto = "SELECT * FROM prodotti ORDER BY idProdotto";
    $result = mysqli_query($conn, $selectProdotto);
    ?>
    <div class="row" id="filterProdottiContainer">
        <div class="col">
            <h5>Aggiungi Prodotto</h5>
            <form method="post">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="prodottoS">Cerca Prodotto: </label>
                        <select class="form-control mb-2 form-control-sm" id="prodottoS">
                            <option value="">-</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['idProdotto'] . '">' . $row['des'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="qtaS">Quantit&agrave;</label>
                        <input type="number" class="form-control mb-2 form-control-sm" id="qtaS">
                    </div>
                </div>
                <button class="btn mb-2 btn-sm btn-success" id="addProdotto">Aggiungi</button>
            </form>
            <div class="row">
                <table class="table" id="tblProdotti">
                    <thead>
                    <tr>
                        <th scope="col">Codice Prodotto</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Qta</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="tblProdottoRows">
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col" id="selectedCliente"></div>
    </div>

</main>
<?php include_once 'include/footer.php'; ?>
<script src="ordine_new.js" type="text/javascript"></script>
