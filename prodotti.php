<?php
$title = 'Prodotti';
include_once 'include/header.php';
include_once 'include/menu.php';
?>
<main role="main" class="container">
    <h5>Nuovo Prodotto </h5>
    <form method="post">
        <div class="form-row">
            <div class="col-md-4">
                <label for="codProd">Codice Prodotto: </label>
                <input class="form-control mb-2 form-control-sm" type="text" id="codProd">
            </div>
            <div class="col-md-4">
                <label for="des">Descrizione: </label>
                <input class="form-control mb-2 form-control-sm" type="text" id="des">
            </div>
        </div>
        <input class="btn mb-2 btn-sm btn-success" type="button" id="addProdotto" value="Aggiungi Prodotto">
    </form>
    <div class="row">
        <div class="col" id="result"></div>
    </div>
    <div class="row">
        <table class="table" id="tblProdotti">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cod. Prodotto</th>
                <th scope="col">Descrizione</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody id="rows">
            </tbody>
        </table>
    </div>
</main>
<!-- Inizio Modal -->
<!-- questa porzione di codice è stata recuperato da -->
<!-- https://getbootstrap.com/docs/4.4/components/modal/ -->
<div class="modal fade" id="editProdottoModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifica Prodotto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <label for="codProdEdit">Codice Prodotto: </label><br>
                    <input type="text" id="codProdEdit"/><br>
                    <label for="desEdit">Desrizione: </label><br>
                    <input type="text" id="desEdit"><br>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-sm btn-primary" id="salvaModifica">Salva Modifiche</button>
            </div>
        </div>
    </div>
</div>
<!-- Fine Modal -->
<?php include_once 'include/footer.php'; ?>
<script src="prodotti.js" type="text/javascript"></script>