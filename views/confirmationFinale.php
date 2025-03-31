<div class="container">
    <div class="col-md-12 text-center mt-3">
        <h2>Votre rendez-vous est confirmé</h2>
    </div>
    <div class="text-center mt-3">
        <?php if ($rendezVous instanceof RendezVous): ?>
            <?php
            $dateAffichee = "";
            // Récupération de la date et l'heure
            $dateRdv = $rendezVous->getDateRdv(); // YYYY-MM-DD

            // Vérifier si la date est valide
            if ($dateRdv) {
                $dateObj = new DateTime($dateRdv);

                // Mettre la première lettre en majuscule
                $dateAffichee = ucfirst($dateAffichee);

                // Alternative avec IntlDateFormatter si strftime ne fonctionne pas
                if (!$dateAffichee || $dateAffichee === "0") {
                    $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                    $dateAffichee = ucfirst($formatter->format($dateObj));
                }
            } else {
                $dateAffichee = "Date invalide";
            }
            ?>
            <p class = "mt-3"><strong>Vous êtes attendu le : </strong> <?= htmlspecialchars($dateAffichee) ?><strong> à </strong><?= htmlspecialchars($rendezVous->getHeureRdv()) ?></p>
            <p class="mt-3"><strong>Soin : </strong> <?= htmlspecialchars($rendezVous->getSoin()) ?></p>
        <?php endif; ?>
    </div>
</div>
<div class="container mt-5">
    <div class="mt-5 mb-5">
        <div class= "map-container">
            <div class="row">
                <div class="col-md-6">
                    <div id="mapid"></div>
                </div>
                <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
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
</div>
<script src="js/map.js" defer></script>