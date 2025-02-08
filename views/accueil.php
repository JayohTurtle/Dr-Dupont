<?php

$horairesManager = new HorairesManager();
$horaires = $horairesManager->getHoraires();
?>

<h4 class="text-center mt-25 p-3">Le cabinet du Dr Dupont, chirurgien-dentiste à Rouen, est heureux de vous accueillir sur son nouveau site Internet destiné à vous communiquer les meilleures informations de prévention et de santé bucco-dentaire.</h4>
<div class="row justify-content-between mt-75">
    <article class="text-center col-md-4">
        <p class="mt-25">Horaires d'ouverture du cabinet</p>
        <div>
            <?php
            foreach ($horaires as $horaire) {
                echo "<p><strong>{$horaire->getJour()} :</strong> ";
                
                if ($horaire->getOuvertureAmFormatted() === '00:00' && $horaire->getFermeturePmFormatted() === '00:00') {
                    echo "Fermé</p>";
                } elseif ($horaire->getOuvertureAmFormatted() === '00:00') {
                    echo "{$horaire->getOuverturePmFormatted()} - {$horaire->getFermeturePmFormatted()}</p>";
                } elseif ($horaire->getOuverturePmFormatted() === '00:00') {
                    echo "{$horaire->getOuvertureAmFormatted()} - {$horaire->getFermetureAmFormatted()}</p>";
                } else {
                    echo "{$horaire->getOuvertureAmFormatted()} - {$horaire->getFermetureAmFormatted()} / {$horaire->getOuverturePmFormatted()} - {$horaire->getFermeturePmFormatted()}</p>";
                }
            }
            ?>
        </div>
    </article>
    </article>
    <div class="col-md-4 text-center">
        <div class="mb-3">
            <img src="assets/images/ozkan-guner-YEx4RBK8Bdw-unsplash.png" class="photo-dr" alt="Le docteur Dupont dans son cabinet">
        </div>
        <div class="mb-4">
            <a href="index.php?action=new_rdv" class="cta-appointment">Prendre rendez-vous</a>
        </div>
    </div>
    <article class="text-center col-md-4">
        <p class="mt-25">Expertise</p>
        <ul class="mt-50 list-unstyled text-center">
            <li>Abcès dentaire</li>
            <li>Consultation de chirurgie dentaire</li>
            <li>Implant dentaire</li>
            <li>Panoramique dentaire</li>
            <li>Prothèse dentaire</li>
            <li>Extraction dentaire</li>
        </ul>
    </article>
</div>



