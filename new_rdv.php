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
    <div class="container background-container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/header.php'); ?>
        <div class="text-center mt-50">
            <h4>Merci de remplir le formulaire ci-dessous afin de prendre rendez-vous</h4>
        </div>
        <div class="form-container mt-25">
            <form id = form method="post" action="create_new_patients.php">
                <div class="form-grid mt-25">
                    <div class="box-nom mp-label form-control">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-prenom mp-label form-control">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-tel mp-label form-control">
                        <label for="tel">Téléphone</label>
                        <input type="text" name="telephone" id="telephone">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-mail mp-label form-control">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-adress mp-label form-control">
                        <label for="adress">Adresse</label>
                        <input type="text" name="adress" id="adress">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-code mp-label form-control">
                        <label for="code">Code postal</label>
                        <input type="text" name="code" id="code">
                        <small>Message d'erreur</small>
                    </div>
                    <div class="box-ville mp-label form-control">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville">
                        <small>Message d'erreur</small>
                    </div>
                </div>
                <div class="mp-btn-rdv">
                    <button type="submit" class="btn-rdv">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="mt-50">
            <!-- inclusion du pied de page du site -->
            <?php require_once(__DIR__ . '/footer.php'); ?>
        </div>
    </div>
</body>