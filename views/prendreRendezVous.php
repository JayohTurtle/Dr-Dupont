<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//si des infos sont enregistrées en session, on les affiche dans le formulaire
$nom = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
$prenom = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$telephone = isset($_SESSION['telephone']) ? $_SESSION['telephone'] : '';
$dateRdv = isset($_SESSION['dateRdv']) ? $_SESSION['dateRdv'] : '';
$hiddenTime = isset($_SESSION['hiddenTime']) ? $_SESSION['hiddenTime'] : '';
$soin = isset($_SESSION['soin']) ? $_SESSION['soin'] : '';
?>

<div class = "container">
    <h5 class="text-center mt-2 p-3">Merci de remplir ce formulaire afin de prendre rendez-vous</h5>
</div>
<form action="index.php?action=creationRendezVous" method="post" class = "mb-3" id="form">
    <div class="form-container mt-5">
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" value="<?= htmlspecialchars($nom) ?>" autocomplete="off">
            </div>
            <div class="form-group col-md-6">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" value="<?= htmlspecialchars($prenom) ?>" autocomplete="off">
            </div>
        </div>
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
                <label for="telephone">Téléphone</label>
                <input type="tel" class="form-control" name="telephone" id="telephone" value="<?= htmlspecialchars($telephone) ?>" autocomplete="off">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email) ?>" autocomplete="off">
            </div>
        </div>
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
                <div>
                    <label>Date</label>
                    <input type="text" class="form-control" id="datepicker" name="dateRdv" value="<?= htmlspecialchars($dateRdv) ?>">
                </div>
                <input type="hidden" id="hiddenTime" name="hiddenTime" value="<?= htmlspecialchars($hiddenTime) ?>">
                <!-- Boîte modale pour choisir les horaires -->
                <div id="popupChoixHoraires" class="modal" style="display: none;">
                    <div class="modal-content form-group d-flex flex-column align-items-center">
                        <span class="close" onclick="fermerPopup('popupChoixHoraires')">&times;</span>
                        <h3>Choisissez un horaire</h3>
                        <form class = "article justify-content-center col-md-12" id="addChoixHoraireForm" method="POST">
                            <div class="form-group col-md-12" id="inputAddChoixHoraire">
                                <label for="addChoixHoraire">Horaires disponibles</label>
                                <div id="horairesDisponibles"></div>

                            </div>
                            <input type="hidden" id="hiddenDate" name="hiddenDate">
                            <div class="form-group col-md-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary small-button" id="ajoutHoraire">Choisir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="soin">Soin</label>
                <select class="form-control" name="soin" id="soin">
                    <?php foreach ($soins as $soinOption) : ?>
                        <option value="<?= htmlspecialchars($soinOption->getSoin()); ?>"
                            <?= ($soinOption->getSoin() === $soin) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($soinOption->getSoin()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class= "form-row mt-3 justify-content-center">
            <button type="submit" class="cta-appointment">Envoyer</button>
        </div>
    </div>
</form>
<script src="js/validate_form.js" defer></script>
<script src="js/date_rdv.js" defer></script>


