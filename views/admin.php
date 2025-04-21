<?php
$messages = [
    'successAjoutSoin' => "Le nouveau Soin a bien été enregistré.",
    'successModifSoin' => "Le Soin a bien été modifié.",
    'successSupprimSoin' => "Le Soin a bien été supprimé.",
    'successAjoutService' => "Le nouveau Service a bien été enregistré.",
    'successModifService' => "Le Service a bien été modifié.",
    'successSupprimService' => "Le Service a bien été supprimé.",
    'successAjoutActualite' => "La nouvelle actualité a bien été enregistrée.",
    'successModifActualite' => "L'actualité a bien été modifiée.",
    'successSupprimActualite' => "L'actualité a bien été supprimée."
];

if (isset($jour)) {
    $messages['successHoraires'] = "Les horaires du " . htmlspecialchars($jour) . " ont bien été modifiés.";
}

foreach ($messages as $key => $message) {
    if (
        ($key === 'successHoraires' && isset($successHoraires) && $successHoraires) ||
        (isset($_GET[$key]) && $_GET[$key] == 1)
    ) {
        echo "<div id='success-message' style='color: green;'>$message</div>";
    }
}
?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center mt-3" id="error-message">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container">
    <div class="d-flex justify-content-center">
        <div class="article col-md-12 mb-4">
            <h5 class="text-center">Utilisateur</h5>
            <div class="d-flex">
                <div class="col-md-6">
                    <?php if (isset($_SESSION['userEmail'])): ?>
                        <p><strong>Utilisateur : </strong><?= htmlspecialchars($_SESSION['userEmail'])?></p>
                        <p><strong>Statut: </strong><?=htmlspecialchars($_SESSION['userRole'])?></p>
                        <div><a href="index.php?action=gestionRdv" class="btn btn-primary">Rendez-vous</a></div> 
                        <?php else: ?>
                        <p>Utilisateur non connecté.</p>
                    <?php endif; ?>
                </div>
                <div>
                    
                </div>
                <div class="col-md-6 mt-2 d-flex flex-column align-items-end">
                    <div><a href="index.php?action=logout" class="suppression">Déconnexion</a></div>  
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'Administrateur'): ?>
                        <div class="mt-3"><a href="index.php?action=createUser">Nouvel utilisateur</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="articles col-md-6">
            <form class = "article" id="formModifServices" method="POST" action="index.php?action=modifServices">
                <h5 class="text-center">Présentation des soins</h5>
                <div class="radio-group col-md-12">
                    <div class="d-flex justify-content-start">
                        <div class="radio-item me-3">
                            <input type="radio" id="ajouterService" name="serviceResearch" value="ajouterService" checked>
                            <label for="ajouterService">Ajouter</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="modifierService" name="serviceResearch" value="modifierService">
                            <label for="modifierService">Modifier</label>
                        </div>
                        <div class="radio-item me-3">
                            <input type="radio" id="supprimerService" name="serviceResearch" value="supprimerService">
                            <label for="supprimerService">Supprimer</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 col-md-12" id="inputAjouterService">
                    <div>
                        <label for="serviceAjout">Soin</label>
                        <input type="text" class="form-control service-input" id="serviceAjout" name="serviceAjout" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="descriptionAjout">Description</label>
                        <textarea name="descriptionAjout" id="descriptionAjout" rows="6" class="form-control tinymce-editor service-input"></textarea>
                    </div>
                </div>
                <div class="form-group d-none mt-2 col-md-12" id="inputModifierService">
                    <div>
                        <label for="serviceModif">Soin</label>
                        <input type="text" class="form-control service-input" id="serviceModif" name="serviceModif" list="getServicesModif" autocomplete="off">
                        <datalist id="getServicesModif">
                            <?php foreach ($services as $service) : ?>
                                <option value="<?= htmlspecialchars($service->getService()); ?>"
                                    data-contenu="<?= htmlspecialchars($service->getDescription()); ?>"
                                    data-id="<?= htmlspecialchars($service->getIdService()); ?>">
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                        <input type="hidden" name="idServiceModif" id="idServiceModif">
                    </div>
                    <div class="form-group">
                        <label for="descriptionModif">Description</label>
                        <textarea name="descriptionModif" id="descriptionModif" rows="6" class="form-control tinymce-editor service-input"></textarea>
                    </div>
                </div>
                <div class="form-group d-none mt-2 col-md-12" id="inputSupprimerService">
                    <div>
                        <label for="serviceSupprim">Soin</label>
                        <input type="text" class="form-control service-input" id="serviceSupprim" name="serviceSupprim" list="getServicesSupprim" autocomplete="off">
                        <datalist id="getServicesSupprim">
                            <?php foreach ($services as $service) : ?>
                                <option value="<?= htmlspecialchars($service->getService()); ?>"
                                    data-contenu="<?= htmlspecialchars($service->getDescription()); ?>"
                                    data-id="<?= htmlspecialchars($service->getIdService()); ?>">
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                        <input type="hidden" name="idServiceSupprim" id="idServiceSupprim">
                    </div>
                    <div class="form-group">
                        <label for="descriptionSupprim">Description</label>
                        <textarea name="descriptionSupprim" id="descriptionSupprim" rows="6" class="form-control service-input"></textarea>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
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
                        <textarea name="contenuAjout" id="contenuAjout" rows="6" class="form-control tinymce-editor actualite-input"></textarea>
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
                        <textarea name="contenuModif" id="contenuModif" rows="6" class="form-control tinymce-editor actualite-input"></textarea>
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
                        <textarea name="contenuSupprim" id="contenuSupprim" rows="6" class="form-control actualite-input"></textarea>
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
            <form class = "article" id="getionSoinss" method="POST" action="index.php?action=modifSoins">
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
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="form-group" id="inputAjouterSoin">
                            <label for="soinAjout">Soin</label>
                            <input type="text" class="form-control" name="soinAjout" id="soinAjout" autocomplete="off">
                        </div>
                        <div class="form-group d-none" id="inputModifierSoin">
                            <label for="soinModif">Soin</label>
                            <input type="text" class="form-control" name="soinModif" id="soinModif" list="getSoinsModif" autocomplete="off">
                            <datalist id="getSoinsModif">
                            <?php foreach ($soins as $soin) : ?>
                                <option value="<?= htmlspecialchars($soin->getSoin()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSupprimerSoin">
                            <label for="soinSupprim">Soin</label>
                            <input type="text" class="form-control" name="soinSupprim" id="soinSupprim" list="getSoinsSupprim" autocomplete="off">
                            <datalist id="getSoinsSupprim">
                            <?php foreach ($soins as $soin) : ?>
                                <option value="<?= htmlspecialchars($soin->getSoin()); ?>"></option>
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
    </div>
</div>
<script src="js/admin.js" defer></script>
<script src="js/tinyMCE.js" defer></script>
<script src="js/errorCreateUser.js" defer></script>

