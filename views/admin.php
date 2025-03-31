<?php if (isset($successHoraires) && $successHoraires): ?>
    <div id="success-message" style="color: green;">
        ✅ Les horaires du <?= htmlspecialchars($jour) ?> ont bien été modifiés.
    </div>
<?php endif; ?>

<?php if (isset($_GET['successAjoutSoin']) && $_GET['successAjoutSoin'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ Le nouveau soin a bien été enregistré.
    </div>
<?php endif; ?>
<?php if (isset($_GET['successModifSoin']) && $_GET['successModifSoin'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ Le soin a bien été modifié.
    </div>
<?php endif; ?>
<?php if (isset($_GET['successSupprimSoin']) && $_GET['successSupprimSoin'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ Le soin a bien été supprimé.
    </div>
<?php endif; ?>

<?php if (isset($_GET['successAjoutActualite']) && $_GET['successAjoutActualite'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ La nouvelle actualite a bien été enregistrée.
    </div>
<?php endif; ?>
<?php if (isset($_GET['successModifActualite']) && $_GET['successModifActualite'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ L'actualité a bien été modifiée.
    </div>
<?php endif; ?>
<?php if (isset($_GET['successSupprimActualite']) && $_GET['successSupprimActualite'] == 1): ?>
    <div id="success-message" style="color: green;">
        ✅ L'actualité' a bien été supprimée.
    </div>
<?php endif; ?>

<div class="container">
    <div class = "row mt-2">
        <div class="articles col-md-6">
            <form class = "article" id="formModifHoraires" method="POST" action="index.php?action=modifHoraires">
                <h5 class="text-center">Horaires d'ouverture</h5>
                <div class="form-group">
                    <label for="jour">Jour</label>
                    <select class="form-control w-100" name="jour">
                        <option value="lundi">Lundi</option>
                        <option value="mardi">Mardi</option>
                        <option value="mercredi">Mercredi</option>
                        <option value="jeudi">Jeudi</option>
                        <option value="vendredi">Vendredi</option>
                        <option value="samedi">Samedi</option>
                        <option value="dimanche">Dimanche</option>
                    </select>
                </div>
                <h6 class="mt-3">Matinée</h6>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-6 form-group">
                        <label class="me-3" for="ouvertureAm">Ouverture :</label>
                        <select id="ouvertureAm" name="ouvertureAm" class="w-100">
                            <option value="0">Fermé</option>
                            <?php
                            $heure_debut = 7;
                            $heure_fin = 12;

                            for ($h = $heure_debut; $h <= $heure_fin; $h++) {
                                foreach (["00", "30"] as $m) {
                                    $horaire = sprintf("%02d:%s", $h, $m);
                                    echo "<option value=\"$horaire\">$horaire</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="fermetureAm">Fermeture :</label>
                        <select id="fermetureAm" name="fermetureAm" class="w-100">
                            <option value="0">Fermé</option>
                            <?php
                            $heure_debut = 7;
                            $heure_fin = 12;

                            for ($h = $heure_debut; $h <= $heure_fin; $h++) {
                                foreach (["00", "30"] as $m) {
                                    $horaire = sprintf("%02d:%s", $h, $m);
                                    echo "<option value=\"$horaire\">$horaire</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <h6 class="mt-3">Après-midi</h6>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-6 form-group">
                        <label class="me-3" for="ouverturePm">Ouverture :</label>
                        <select id="ouverturePm" name="ouverturePm" class="w-100">
                            <option value="0">Fermé</option>
                            <?php
                            $heure_debut = 13;
                            $heure_fin = 20;

                            for ($h = $heure_debut; $h <= $heure_fin; $h++) {
                                foreach (["00", "30"] as $m) {
                                    $horaire = sprintf("%02d:%s", $h, $m);
                                    echo "<option value=\"$horaire\">$horaire</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="fermeturePm">Fermeture :</label>
                        <select id="fermeturePm" name="fermeturePm" class="w-100">
                            <option value="0">Fermé</option>
                            <?php
                            $heure_debut = 13;
                            $heure_fin = 20;

                            for ($h = $heure_debut; $h <= $heure_fin; $h++) {
                                foreach (["00", "30"] as $m) {
                                    $horaire = sprintf("%02d:%s", $h, $m);
                                    echo "<option value=\"$horaire\">$horaire</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-4">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="articles col-md-6">
            <form class = "article" id="formModifActualites" method="POST" action="index.php?action=gestionActualites">
                <h5 class="text-center">Actualités</h5>
                <div class="radio-group col-md-12">
                    <div class="d-flex justify-content-start">
                        <div class="radio-item me-3">
                            <input type="radio" id="ajouterActualite" name="actualiteResearch" value="ajouterActualite" checked>
                            <label for="ajouterActualite">Ajouter</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="modifierActualite" name="actualiteResearch" value="modifierActualite">
                            <label for="modifierActualite">Modifier</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="supprimerActualite" name="actualiteResearch" value="supprimerActualite">
                            <label for="supprimerActualite">Supprimer</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="inputAjouterActualite">
                    <div>
                        <label for="titreAjout">Titre</label>
                        <input type="text" class="form-control actualite-input" id="titreAjout" name="titreAjout" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="contenuAjout">Contenu</label>
                        <textarea name="contenuAjout" id="contenuAjout" rows="6" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group d-none" id="inputModifierActualite">
                    <div>
                        <label for="titreModif">Titre</label>
                        <input type="text" class="form-control actualite-input" id="titreModif" name="titreModif" list="getActualitesModif" autocomplete="off">
                        <datalist id="getActualitesModif">
                            <?php foreach ($actualites as $actualite) : ?>
                                <option value="<?= htmlspecialchars($actualite->getTitre()); ?>"
                                    data-contenu="<?= htmlspecialchars($actualite->getContenu()); ?>"
                                    data-id="<?= htmlspecialchars($actualite->getIdActualite()); ?>">
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                        <input type="hidden" name="idActualiteModif" id="idActualiteModif">
                    </div>
                    <div class="form-group">
                        <label for="contenuModif">Contenu</label>
                        <textarea name="contenuModif" id="contenuModif" rows="6" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group d-none" id="inputSupprimerActualite">
                    <div>
                        <label for="titreSupprim">Titre</label>
                        <input type="text" class="form-control actualite-input" id="titreSupprim" name="titreSupprim" list="getActualitesSupprim" autocomplete="off">
                        <datalist id="getActualitesSupprim">
                            <?php foreach ($actualites as $actualite) : ?>
                                <option value="<?= htmlspecialchars($actualite->getTitre()); ?>"
                                    data-contenu="<?= htmlspecialchars($actualite->getContenu()); ?>"
                                    data-id="<?= htmlspecialchars($actualite->getIdActualite()); ?>">
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                        <input type="hidden" name="idActualiteSupprim" id="idActualiteSupprim">
                    </div>
                    <div class="form-group">
                        <label for="contenuSupprim">Contenu</label>
                        <textarea name="contenuSupprim" id="contenuSupprim" rows="6" class="form-control"></textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <div class = "row mt-3">
        <div class="articles col-md-6">
            <form class = "article" id="formModifSoins" method="POST" action="index.php?action=modifSoins">
                <h5 class="text-center">Soins</h5>
                <div class="radio-group col-md-12">
                    <div class="d-flex justify-content-start">
                        <div class="radio-item me-3">
                            <input type="radio" id="ajouterSoin" name="soinResearch" value="ajouterSoin" checked>
                            <label for="ajouterSoin">Ajouter</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="modifierSoin" name="soinResearch" value="modifierSoin">
                            <label for="modifierSoin">Modifier</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="supprimerSoin" name="soinResearch" value="supprimerSoin">
                            <label for="supprimerSoin">Supprimer</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 col-md-8" id="inputAjouterSoin">
                    <label for="soinAjout">Soin</label>
                    <input type="text" class="form-control" id="soinAjout" name="soinAjout">
                </div>
                <div class="form-group d-none mt-2 col-md-8" id="inputModifierSoin">
                    <label for="soinModif">Soin</label>
                    <input type="text" class="form-control" id="soinModif" name="soinModif" list="getSoinsModif" autocomplete="off">
                    <datalist id="getSoinsModif">
                        <?php foreach ($soins as $soin) : ?>
                            <option value="<?= htmlspecialchars($soin->getSoin()); ?>"
                                data-id="<?= htmlspecialchars($soin->getIdSoin()); ?>">
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                    <input type="hidden" name="idSoinModif" id="idSoinModif">
                </div>
                <div class="form-group d-none mt-2 col-md-8" id="inputSupprimerSoin">
                    <label for="soinSupprim">Soin</label>
                    <input type="text" class="form-control" id="soinSupprim" name="soinSupprim" list="getSoinsSupprim" autocomplete="off">
                    <datalist id="getSoinsSupprim">
                        <?php foreach ($soins as $soin) : ?>
                            <option value="<?= htmlspecialchars($soin->getSoin()); ?>"
                                data-id="<?= htmlspecialchars($soin->getIdSoin()); ?>">
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                    <input type="hidden" name="idSoinSupprim" id="idSoinSupprim">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="articles col-md-6">
            <form class = "article" id="getionPatients" method="POST" action="index.php?action=gestionPatients">
                <h5 class="text-center">Patients</h5>
                <div class="radio-group col-md-12">
                    <div class="d-flex justify-content-start">
                        <div class="radio-item me-3">
                            <input type="radio" id="nom" name="patientResearch" value="nom" checked>
                            <label for="nom">Nom</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="telephone" name="patientResearch" value="telephone">
                            <label for="telephone">Téléphone</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="email" name="patientResearch" value="email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="form-group" id="inputNom">
                            <label for="nomPatient">Nom</label>
                            <input type="text" class="form-control patient-input" name="nomPatient" id="nomPatient" list="getNoms" autocomplete="off">
                            <datalist id="getNoms">
                            <?php foreach ($patients as $patient) : ?>
                                <option value="<?= htmlspecialchars($patient->getNom()); ?> <?= htmlspecialchars($patient->getPrenom()); ?> "></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="telephonePatient">Téléphone</label>
                            <input type="text" class="form-control patient-input" name="telephonePatient" id="telephonePatient" list="getTelephones" autocomplete="off">
                            <datalist id="getTelephones">
                            <?php foreach ($patients as $patient) : ?>
                                <option value="<?= htmlspecialchars($patient->getTelephone()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="emailPatient">Email</label>
                            <input type="text" class="form-control patient-input" name="emailPatient" id="emailPatient" list="getEmails" autocomplete="off">
                            <datalist id="getEmails">
                            <?php foreach ($patients as $patient) : ?>
                                <option value="<?= htmlspecialchars($patient->getEmail()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <div class="articles col-md-6 mt-3">
        <form class = "article" id="formGestionRdv" method="POST" action="index.php?action=gestionRdv">
            <h5 class="text-center">Rendez-vous</h5>
            <h6>Recherche</h6>
            <div class="row mt-2 align-items-end">
                <div class="col-md-8">
                    <div class="form-group" id="inputDateRdv">
                        <label for="dateRdv">Date</label>
                        <input type="date" class="form-control rdv-input" id="dateRdv" name="dateRdv">
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
            </div>
        </form>
    </div>
</div>
    
<script src="js/admin.js" defer></script>
