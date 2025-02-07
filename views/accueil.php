
<h4 class="text-center mt-25 p-3">Le cabinet du Dr Dupont, chirurgien-dentiste à Rouen, est heureux de vous accueillir sur son nouveau site Internet destiné à vous communiquer les meilleures informations de prévention et de santé bucco-dentaire.</h4>
<div class="row justify-content-between mt-75">
    <article class="text-center col-md-4">
    <p class="mt-25">Horaires d'ouverture du cabinet</p>
    <?php
        date_default_timezone_set('Europe/Paris'); // On définit le fuseau horaire
        setlocale(LC_TIME, 'fr_FR.UTF-8'); // On définit la locale en français
        $current_time = new DateTime;//on définit l'haure actuelle

        for ($i=0; $i < count($daysList) ; $i++) { 
            $day = $daysList[$i]['jour'];
            $amOpen = $daysList[$i]['ouverture_am'];
            $amClose = $daysList[$i]['fermeture_am'];
            $pmOpen = $daysList[$i]['ouverture_pm'];
            $pmClose = $daysList[$i]['fermeture_pm'];
            // On convertit les heures au format souhaité (HH:MM)
            $amOpenFormatted = date('H:i', strtotime($amOpen));
            $amCloseFormatted = date('H:i', strtotime($amClose));
            $pmOpenFormatted = date('H:i', strtotime($pmOpen));
            $pmCloseFormatted = date('H:i', strtotime($pmClose));
            //Si les horaires d'ouverture sont 00:00:00 on affiche "fermé"
            if ($amOpen === '00:00:00' && $pmOpen === '00:00:00') {
                echo ("$day : fermé <br/>");
            }
            elseif ($amOpen === '00:00:00') {
                echo ("$day : $pmOpenFormatted - $pmCloseFormatted <br/>");
            }
            elseif ($pmOpen === '00:00:00'){
                echo ("$day : $amOpenFormatted - $amCloseFormatted <br/>");
            }else{
                echo ("$day : $amOpenFormatted - $amCloseFormatted / $pmOpenFormatted - $pmCloseFormatted <br/>");
            }
        }
        ?>
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



