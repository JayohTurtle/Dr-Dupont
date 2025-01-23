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
        <div class="row choice">
            <div class="mt-100">
                <a href="new_rdv.php" class="question">C'est mon premier rendez-vous avec le docteur Dupont</a>
            </div>
            <div class="mt-100">
            <a href="rdv_patient.php" class="question">Je suis un(e) patient(e) du docteur Dupont</a>
            </div>
        </div>
        <div class="mt-150" >
            <!-- inclusion du pied de page du site -->
            <?php require_once(__DIR__ . '/footer.php'); ?>
        </div>
    </div>
</body>
</html>