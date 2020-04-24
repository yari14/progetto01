<?php
$title = 'Clienti';
include_once 'include/header.php';
include_once 'include/menu.php';
?>
<main role="main" class="container">
    <h5>Nuovo Cliente </h5>
    <form method="post">
        <div class="form-row">
            <div class="col-md-4">
                <label for="cognome">Cognome: </label>
                <input class="form-control mb-2 form-control-sm" type="text" name="cognome" id="cognome">
            </div>
            <div class="col-md-4">
                <label for="nome">Nome: </label>
                <input class="form-control mb-2 form-control-sm" type="text" name="nome" id="nome">
            </div>
            <div class="col-md-4">
                <label for="email">E-Mail: </label>
                <input class="form-control mb-2 form-control-sm" type="email" name="email" id="email">
            </div>
        </div>
        <input class="btn mb-2 btn-sm btn-success" type="button" id="addCliente" value="Aggiungi Cliente">
    </form>

    <div class="row">
        <div class="col" id="result"></div>
    </div>
    <div class="row">
        <table class="table" id="tblClienti">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cognome</th>
                <th scope="col">Nome</th>
                <th scope="col">E-Mail</th>
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
<div class="modal fade" id="editClienteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifica Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <label for="cognomeEdit">Cognome: </label><br>
                    <input type="text" id="cognomeEdit"/><br>
                    <label for="nomeEdit">Nome: </label><br>
                    <input type="text" id="nomeEdit"><br>
                    <label for="emailEdit">E-Mail: </label><br>
                    <input type="email" id="emailEdit"><br>
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
<script src="clienti.js" type="text/javascript"></script>