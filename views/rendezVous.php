<div class="row">
    <div class="container mt-5">
        <h4 class="text-center">Rendez-vous</h4>
        <div class="row d-flex mt-5">
            <?php if (!empty($rendezVousList)): ?>
                <?php 
                $premierRdv = $rendezVousList[0];
                $date = new DateTime($premierRdv->getDateRdv());
                $jour = $date->format('l');

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
                <h5>
                    Rendez-vous du <?= htmlspecialchars($joursFr[$jour]) . " " . htmlspecialchars($premierRdv->getDateRdvFormatFr()) ?>
                </h5>
                <?php foreach ($rendezVousList as $rendezVous): ?>
                    <div class="row">
                        <div class="col-md-5">
                            
                            <h6 class="mt-3">Patient : <?= htmlspecialchars($rendezVous->getPrenom()) ?> <?= htmlspecialchars($rendezVous->getNom()) ?> </h6>
                            <?php
                            $heure = new DateTime($rendezVous->getHeureRdv());
                            $formattedTime = $heure->format('H\hi');
                            ?>
                            <p>Horaire : <?= htmlspecialchars($formattedTime) ?></p>
                            <p>Soin : <?= htmlspecialchars($rendezVous->getSoin()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun rendez-vous programmé à cette date</p>
            <?php endif; ?>
        </div>
    </div>
</div>

                    