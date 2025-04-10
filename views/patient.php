<div class="row">
    <div class="container mt-5">
        <h4 class="text-center">Patient</h4>
        <div class="row d-flex mt-5">
            <a class="ms-5 mb-3" href="index.php?action=admin"><- Retour</a>
            <div class="articles col-md-6">
                <div class="article">
                    <h5><?= htmlspecialchars($patient->getPrenom()) ?> <?= htmlspecialchars($patient->getNom()) ?></h5>
                    <?php 
                         $fields = [
                            'Email' => $patient->getEmail(),
                            'Telephone' => $patient->getTelephone(),
                        ];
                        foreach ($fields as $label => $value): 
                            $isEmail = ($label == 'Email');
                    ?>
                        <p style="display: flex; align-items: center; gap: 8px;">
                            <strong><?= $label ?>: </strong>
                            <span id="copy_<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($value) ?></span>
                            <?php if ($isEmail): ?>
                                <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('copy_<?= htmlspecialchars($value) ?>', this)">
                            <?php endif; ?>
                            <a href="#" onclick="ouvrirPopup('popupModif<?= $label ?>')">
                                <img class="iconCopie" src="assets/images/modif.png" alt="Modifier">
                            </a>
                        </p>
                    <?php endforeach; ?>
                    <h5 class="mt-3">Prochain rendez-vous</h5>
                    <?php if (isset($prochainRendezVous)): ?>
                        <p><strong>Date: </strong><?= htmlspecialchars($prochainRendezVous->getDateRdvFormatFr()) ?></p>
                        <?php
                            $heure = new DateTime($prochainRendezVous->getHeureRdv());
                            $formattedTime = $heure->format('H\hi');
                        ?>
                        <p><strong>Heure: </strong><?= htmlspecialchars($formattedTime) ?></p>
                        <p><strong>Soin: </strong><?= htmlspecialchars($prochainRendezVous->getSoin()) ?></p>
                        <p><a href="#" onclick="ouvrirPopup('popupModifRendezVous')">
                                <img class="icon" src="assets/images/modifier.png" alt="Modifier">
                            </a>
                            <a href="#" onclick="ouvrirPopup('popupSupprimRendezVous')">
                                <img class="icon" src="assets/images/supprimer.png" alt="Supprimer">
                            </a>
                        </p>
                    <?php endif; ?>
                    <p>
                        <a href="#" onclick="ouvrirPopup('popupAjoutRendezVous')">
                            <img class="icon" src="assets/images/ajouter.png" alt="Ajouter">
                        </a>
                    </p>
                </div>
            </div>
            <div class="articles col-md-6">
                <div class="article">
                    <h5 class="mt3">Rendez-vous: </h5>
                    <?php foreach ($rendezVous as $rendezVousUn): ?>
                        <p><strong>Date: </strong><?= htmlspecialchars($rendezVousUn->getDateRdvFormatFr()) ?> <strong>Soin: </strong><?= htmlspecialchars($rendezVousUn->getSoin()) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modals pour modifier email et téléphone -->
    <?php 
    $modals = [
    'Email' => 'email',
    'Telephone' => 'telephone',
    ];
    foreach ($modals as $field => $champ): ?>
        <div id="popupModif<?= $field ?>" class="modal">
            <div class="modal-content form-group d-flex flex-column align-items-center">
                <span class="close" onclick="fermerPopup('popupModif<?= $field ?>')">&times;</span>
                <h5>Ajouter/modifier <?= strtolower($field) ?></h5>
                <form class="article justify-content-center infoPatientForm" id="modif<?= $field ?>" method="POST">
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group w-100" id="inputModif<?= $field ?>">
                            <label for="info<?= $field ?>"><?= $field ?></label>
                            <input type="text" class="form-control" name="valeur" id="info<?= $field ?>" value="<?= htmlspecialchars($field == 'Soin' ? $prochainRendezVous->getSoin() : '') ?>">
                        </div>
                        <?php if (isset($patient) && $patient instanceof Patient): ?>
                            <input type="hidden" name="champ" value="<?= strtolower($field) ?>">
                            <input type="hidden" name="idPatient" value="<?= (int) $patient->getIdPatient() ?>">
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <div id="popupConfirmation" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <div id="popupConfirmationInfoPatientContent">
                <!-- Le contenu dynamique sera injecté ici -->
            </div>
        </div>
    </div>
     <!-- Boîte modale pour modifier le rendez-vous -->
     <div id="popupModifRendezVous" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifRendezVous')">&times;</span>
            <h5>Modifier le rendez-vous</h5>
            <form class = "article justify-content-center" method="POST" id="modifRdvForm">
                <div class="d-flex mt-2 justify-content-center">
                    <div class="mb-3 mx-3">
                        <label>Date</label>
                        <?php if ($prochainRendezVous): ?>
                            <input type="date" class="form-control" id="datepicker" name="dateRdv" 
                                value="<?= htmlspecialchars((new DateTime($prochainRendezVous->getDateRdv()))->format('Y-m-d')); ?>">
                        <?php else: ?>
                            <input type="date" class="form-control" id="datepicker" name="dateRdv" value="">
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="infoSoin">Soin</label>
                        <select class="form-control" name="soin" id="infoSoin">
                            <?php 
                            $soinActuel = $prochainRendezVous ? htmlspecialchars($prochainRendezVous->getSoin()) : ''; 
                            ?>
                            <?php foreach ($soins as $soin) : ?>
                                <option value="<?= htmlspecialchars($soin->getSoin()); ?>" 
                                    <?= ($soin->getSoin() === $soinActuel) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($soin->getSoin()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="hiddenTime" name="heureRdv" value="<?= htmlspecialchars($hiddenTime ?? '') ?>">
                <input type="hidden" name="dateRdvActuelle" value="<?= htmlspecialchars($prochainRendezVous ? $prochainRendezVous->getDateRdv() : ''); ?>">
                <input type="hidden" name="idPatient" value="<?= (int) $patient->getIdPatient() ?>">
                <div class="form-group col-md-3 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour supprimer le rendez-vous -->
    <div id="popupSupprimRendezVous" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupSupprimRendezVous')">&times;</span>
            <h5>Confirmez la suppression de ce rendez-vous</h5>
            <form class = "article justify-content-center" method="POST" id="supprimRdvForm">
                <div class="d-flex mt-2 justify-content-center">
                    <div class="mb-3 mx-3">
                        <h6><?= htmlspecialchars($patient->getPrenom()) ?> <?= htmlspecialchars($patient->getNom()) ?></h6>
                        <p>Le <?= htmlspecialchars($prochainRendezVous ? $prochainRendezVous->getDateRdvFormatFr() : ''); ?> à <?= htmlspecialchars($formattedTime) ?></p>
                        <input type="hidden" name="dateRdvActuelle" value="<?= htmlspecialchars($prochainRendezVous ? $prochainRendezVous->getDateRdv() : ''); ?>">
                        <input type="hidden" name="idPatient" value="<?= (int) $patient->getIdPatient() ?>">
                        <div class="form-group col-md-12 d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-danger small-button">Confirmer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter un rendez-vous -->
    <div id="popupAjoutRendezVous" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutRendezVous')">&times;</span>
            <h5>Nouveau Rendez-vous</h5>
            <form class = "article justify-content-center" method="POST" id="ajoutRdvForm">
                <div class="d-flex mt-2 justify-content-center">
                    <div class="mb-3 mx-3">
                        <label>Date</label>
                        <input type="date" class="form-control" id="newDatepicker" name="dateRdv" >
                        <input type="hidden" name="idPatient" value="<?= (int) $patient->getIdPatient() ?>">
                        <input type="hidden" id="hiddenTime" name="hiddenTime" value="<?= htmlspecialchars($hiddenTime) ?>">
                    </div>
                    <div>
                        <label for="infoSoin">Soin</label>
                        <select class="form-control" name="soin" id="infoSoin">
                            <?php foreach ($soins as $soin) : ?>
                                <option value="<?= htmlspecialchars($soin->getSoin()); ?>">
                                    <?= htmlspecialchars($soin->getSoin()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-12 d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour choisir un horaire -->
    <div id="popupChoixHoraires" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupChoixHoraires')">&times;</span>
            <h3>Choisissez un horaire</h3>
            <form class="article justify-content-center col-md-12" id="addChoixHoraireForm" method="POST">
                <div class="form-group col-md-12" id="inputAddChoixHoraire">
                    <label for="addChoixHoraire">Horaires disponibles</label>
                    <div id="horairesDisponibles"></div>
                </div>
                <input type="hidden" id="hiddenDate" name="hiddenDate">
                <input type="hidden" id="sourceContext" value="">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutHoraire">Choisir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/iconCopy.js" defer></script>
<script src="js/copierEmail.js" defer></script>
<script src="js/modifPatient.js" defer></script>
<script src="js/modifRdv.js" defer></script>
