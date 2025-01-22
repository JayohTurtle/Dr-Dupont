<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr Dupont - Page d'accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
    </div>
    <section class="container container-accueil">
        <div class="welcome">
            <p>Bienvenue<br>
            Le cabinet du docteur Dupont, chirurgien-dentiste à LaVille, est heureux de vous accueillir sur son nouveau site Internet destiné à vous communiquer les meilleures informations de prévention et de santé bucco-dentaire</p>
        </div>
        <div class="bloc-infos row mt-75">
            <article class="infos schedule text-center">
                <p class="mt-25">Horaires d’ouverture du cabinet</p>
                <ul class="list-infos mt-50">
                    <li>Lundi : Fermé</li>
                    <li>Mardi : 9h00-18h00</li>
                    <li>Mercredi : 9h00-18h00</li>
                    <li>Jeudi : 9h00-18h00</li>
                    <li>Vendredi : 9h00-18h00</li>
                    <li>Samedi : 9h00-18h00</li>
                    <li>Dimanche : 9h00-18h00</li>
                </ul>
            </article>
            <div class="container-appointment">
                <div class="img-appointment">
                    <img src="images/docteur-dupont.png" class="photo-dr" alt="Le docteur Dupont dans son cabinet">
                </div>
                <div class="appointment">
                    <button class="btn-appointment">Prendre rendez-vous</button>
                </div>
            </div>
            <article class="infos care text-center">
                <p class="mt-25">Expertise</p>
                <ul class="list-infos mt-50">
                    <li>Abcès dentaire</li>
                    <li>Consultation de chirurgie dentaire</li>
                    <li>Implant dentaire</li>
                    <li>Panoramique dentaire</li>
                    <li>Prothèse dentaire</li>
                    <li>Extraction dentaire</li>
                </ul>
            </article>
        </div>
    </section>
    <div class="container">
        <!-- inclusion du pied de page du site -->
        <?php require_once(__DIR__ . '/footer.php'); ?>
    </div>

</body>