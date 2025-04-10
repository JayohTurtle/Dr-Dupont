<?php

$groupesParDate = [];

//grouper les rdv par date
foreach ($rendezVousList as $rdv) {
    $date = $rdv->getDateRdv();
    if (!isset($groupesParDate[$date])) {
        $groupesParDate[$date] = [];
    }
    $groupesParDate[$date][] = $rdv;
}

//traduire les dates en français
$joursFr = [
    'Monday'    => 'Lundi',
    'Tuesday'   => 'Mardi',
    'Wednesday' => 'Mercredi',
    'Thursday'  => 'Jeudi',
    'Friday'    => 'Vendredi',
    'Saturday'  => 'Samedi',
    'Sunday'    => 'Dimanche'
];
?>

<div class="row">
    <div class="container mt-5">
        <h4 class="text-center">Rendez-vous</h4>
        <a class="mb-3 d-block" href="index.php?action=admin"><- Retour</a>
        <?php if (!empty($groupesParDate)): ?>
            <div class="row d-flex flex-wrap mt-5">
                <?php foreach ($groupesParDate as $dateStr => $rdvsDuJour): ?>
                    <?php
                        $dateObj = new DateTime($dateStr);
                        $jour = $dateObj->format('l');
                        $dateFr = $dateObj->format('d/m/Y');
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="article">
                            <h5><?= htmlspecialchars($joursFr[$jour]) . " " . $dateFr ?></h5>
                            <?php foreach ($rdvsDuJour as $rdv): ?>
                                <?php $heure = (new DateTime($rdv->getHeureRdv()))->format('H\hi'); ?>
                                <div class="ms-3">
                                    <p style="display: flex; align-items: center; gap: 8px;">
                                        <strong><?= htmlspecialchars($heure) ?></strong> :
                                        <?= htmlspecialchars($rdv->getPrenom()) ?> <?= htmlspecialchars($rdv->getNom()) ?> –
                                        <?= htmlspecialchars($rdv->getSoin()) ?>
                                        <a href="#" onclick="ouvrirPopup('popupModifRendezVous',  
                                            <?= $rdv->getIdRdv() ?>,
                                            '<?= htmlspecialchars($rdv->getNom()) ?>',
                                            '<?= htmlspecialchars($rdv->getPrenom()) ?>',
                                            '<?= (new DateTime($rdv->getDateRdv()))->format('Y-m-d') ?>',
                                            '<?= htmlspecialchars($rdv->getSoin()) ?>')">
                                            <img class="icon" src="assets/images/modifier.png" alt="Modifier">
                                        </a>
                                        <a href="#" onclick="ouvrirPopup('popupSupprimRendezVous', 
                                            <?= $rdv->getIdRdv() ?>,
                                            '<?= htmlspecialchars($rdv->getNom()) ?>',
                                            '<?= htmlspecialchars($rdv->getPrenom()) ?>',
                                            '<?= (new DateTime($rdv->getDateRdv()))->format('Y-m-d') ?>',
                                            '<?= htmlspecialchars($rdv->getSoin()) ?>')">
                                            <img class="icon" src="assets/images/supprimer.png" alt="Supprimer">
                                        </a>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucun rendez-vous programmé</p>
        <?php endif; ?>
    </div>
</div>
<!-- Boîte modale pour modifier le rendez-vous -->
<div id="popupModifRendezVous" class="modal">
    <div class="modal-content form-group d-flex flex-column align-items-center">
        <span class="close" onclick="fermerPopup('popupModifRendezVous')">&times;</span>
        <h5>Modifier le rendez-vous</h5>
        <form class = "article justify-content-center" method="POST" id="modifRdvForm">
            <div class="row form-row mt-3">
                <div class="form-group col-md-6">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" name="prenom" value="<?= htmlspecialchars($rdv->getPrenom()) ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($rdv->getNom()) ?>" readonly>
                </div>
            </div>
            <div class="row form-row mt-3">
                <div class="form-group col-md-6">
                    <label>Date</label>
                    <?php if (isset ($rdv)): ?>
                        <input type="date" class="form-control" id="datepicker" name="dateRdv" 
                            value="<?= htmlspecialchars((new DateTime($rdv->getDateRdv()))->format('Y-m-d')); ?>">
                    <?php else: ?>
                        <input type="date" class="form-control" id="datepicker" name="dateRdv" value="">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                    <label for="infoSoin">Soin</label>
                    <?php $soinActuel = $rdv ? htmlspecialchars($rdv->getSoin()) : ''; ?>
                    <select class="form-control" name="soin" id="infoSoin">
                        <?php foreach ($soins as $optionSoin) : 
                            $valeur = htmlspecialchars($optionSoin->getSoin());
                            $selected = ($valeur === $soinActuel) ? 'selected' : '';
                        ?>
                            <option value="<?= $valeur ?>" <?= $selected ?>>
                                <?= $valeur ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <input type="hidden" id="sourceContext" name="sourceContext">
            <input type="hidden" name="idRendezVous" value="<?= (int) $rdv->getIdRdv() ?>">
            <input type="hidden" id="hiddenTime" name="heureRdv" value="<?= htmlspecialchars($hiddenTime ?? '') ?>">
            <div class="form-group col-md-3 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary small-button">Envoyer</button>
            </div>
        </form>
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
</div>
<!-- Boîte modale pour supprimer le rendez-vous -->
<div id="popupSupprimRendezVous" class="modal">
    <div class="modal-content form-group d-flex flex-column align-items-center">
        <span class="close" onclick="fermerPopup('popupSupprimRendezVous')">&times;</span>
        <h5>Confirmez la suppression de ce rendez-vous</h5>
        <form class="article justify-content-center" method="POST" id="supprimRdvForm">
            <h6 class="text-center"></h6> 
            <p class="text-center"></p> 
            <input type="hidden" name="idRendezVous" value="">
            <div class="form-group col-md-12 d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-danger small-button">Confirmer la suppression</button>
            </div>
        </form>
    </div>
</div>
<script src="js/modifRdv.js" defer></script>
