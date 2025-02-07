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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/leaflet.awesome-markers/css/style.css" /> 
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="mainNavbar">
        <div class="container">
            <div class="custom-container">
                <h1>Cabinet dentaire du docteur Dupont</h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-cta mx-auto">
                        <ul>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=accueil">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=soins">Soins</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=aPropos">A propos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=actualites">Actualités</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </nav>
        <main class="container">
            <?= $content ?>
        </main>
        <footer class="footer bg-light text-footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-between align-items-center">
                    <div class="mentions">
                        <p>Conditions générales d'utilisation</p>
                        <p>Mentions légales</p>
                        <p>Charte déontologique</p>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between align-items-center">
                    <div class="contact">
                        <div class="align-icon d-flex align-items-center mb-2">
                            <img src="assets/images/localisation.png" alt="Icône de localisation" class="icon mr-2">
                            <p class="mb-0">25 Rue Saint-Lô 76000 Rouen</p>
                        </div>
                        <div class="align-icon d-flex align-items-center">
                            <img src="assets/images/telephone.png" alt="Icône de téléphone" class="icon mr-2">
                            <p class="mb-0">02 33 44 55 66</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script type="module" src="js/script.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="assets/leaflet.awesome-markers/leaflet.awesome-markers.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
</body>