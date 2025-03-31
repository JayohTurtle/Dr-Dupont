<div class="container">    
    <div class="col-md-12 text-center mt-3">
        <h2>Confirmation de votre rendez-vous</h2>
    </div>
    <div class="text-center mt-3">
        <div class="text-center">
        <h5>Veuillez vérifier les informations ci-dessous avant de confirmer</h5>
            <?php if ($patient instanceof Patient): ?>
                <p><strong>Nom : </strong> <?= htmlspecialchars($patient->getNom()) ?></p>
                <p><strong>Prénom : </strong> <?= htmlspecialchars($patient->getPrenom()) ?></p>
                <p><strong>Téléphone : </strong> <?= htmlspecialchars($patient->getTelephone()) ?></p>
                <p><strong>Email : </strong> <?= htmlspecialchars($patient->getEmail()) ?></p>
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

            <p><strong>Date du rendez-vous : </strong> <?= htmlspecialchars($dateAffichee) ?> <strong> à </strong> <?= htmlspecialchars($rendezVous->getHeureRdv()) ?></p>
                <p><strong>Soin : </strong> <?= htmlspecialchars($rendezVous->getSoin()) ?></p>
            <?php endif; ?>
                <?php else: ?>
                <p class="text-danger">Aucune information patient disponible.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="text-center mt-3">
    <h6>Confirmer le rendez-vous</h6>
    <form action="index.php?action=confirmationRendezVous" method="POST">
        <input type="hidden" name="idPatient" value="<?= htmlspecialchars($idPatient) ?>">
        <input type="hidden" name="dateRdv" value="<?= htmlspecialchars($rendezVous->getDateRdv()) ?>">
        <input type="hidden" name="heureRdv" value="<?= htmlspecialchars($rendezVous->getHeureRdv()) ?>">
        <input type="hidden" name="soin" value="<?= htmlspecialchars($rendezVous->getSoin()) ?>">
        <button type="submit" class="btn btn-primary mt-3">Confirmer</button>
    </form>
    </div>
    <div class="text-center mt-3">
        <h6>Revenir au formulaire de rendez-vous</h6>
        <a href="index.php?action=prendreRendezVous" class="btn btn-success mt-3">Modifier</a>
    </div>
    <div class="text-center mt-3">
        <h6>Annuler le rendez-vous</h6>
        <a href="index.php?action=accueil" class="btn btn-danger mb-3 mt-3">Annuler</a>
    </div>
</div>
