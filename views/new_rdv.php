<div class = "container">
    <h5 class="text-center mt-25 p-3">Merci de remplir ce formulaire afin de prendre rendez-vous</h5>
</div>
<form action="index.php?action=confirmation_rdv" method="post" class = "mb-50" id="form">
    <div class="form-container">
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom">
                <small class="form-text">Message d'erreur</small>
            </div>
            <div class="form-group col-md-6">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom">
                <small class="form-text">Message d'erreur</small>
            </div>
        </div>
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
                <label for="telephone">Téléphone</label>
                <input type="tel" class="form-control" name="telephone" id="telephone">
                <small class="form-text">Message d'erreur</small>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email">
                <small class="form-text">Message d'erreur</small>
            </div>
        </div>
        <div class="row form-row mt-3">
            <div class="form-group col-md-6">
            <label for="date-picker">Choisissez une date et une heure</label>
                <input type="text" class="form-control" name="date-picker" id="date-picker">
                <small class="form-text">Message d'erreur</small>
            </div>
            <div class="form-group col-md-6">
                <label for="soins">Soin</label>
                <select class="form-control" name="soin" id="soins">
                    <option value="consultation">Consultation</option>
                    <option value="detartrage">Détartrage</option>
                    <option value="extraction">Extraction</option>
                    <option value="implant">Implant</option>
                </select>
            </div>
        </div>
        <div class= "row form-row mt-3 justify-content-center">
            <button type="submit" class="btn btn-primary mt-3">Envoyer</button>
        </div>
    </form>
</div>
<div class="container mt-5 mb-5">
    <div class= "map-container">
        <div class="row">
            <div class="col-md-6">
                <div id="mapid"></div>
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center">
                <h6>Les accès au cabinet</h6>
                <p>Adresse : 25 Rue Saint-Lô 76000 Rouen</p>
                <ul>
                    <li>Ligne de bus 5 : arrêt Michel</li>
                    <li>Ligne de bus 14 : arrêt Micheline</li>
                    <li>Métro ligne 2 : station Ici, prendre la sortie 3</li>
                </ul>
            </div>
        </div> 
    </div>
</div>
<script src="js/validate_form.js" defer></script>
<script src="js/date_rdv.js" defer></script>


