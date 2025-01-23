<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;
if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
){
        echo('L\'email saisi n\'est pas valide.');
        return;
    }
if(
    empty($postData['nom'])
    || empty($postData['prenom'])
    || empty($postData['telephone'])
    || empty($postData['email'])
    || empty($postData['adress'])
    || empty($postData['code'])
    || empty($postData['ville'])
) {
    echo('Tous les champs sont obligatoires.');
    return;
}

$nom = trim(strip_tags($postData['nom']));
$prenom = trim(strip_tags($postData['prenom']));
$telephone = trim(strip_tags($postData['telephone']));
$email = trim(strip_tags($postData['email']));
$adress = trim(strip_tags($postData['adress']));
$code = trim(strip_tags($postData['code']));
$ville = trim(strip_tags($postData['ville']));

// Faire l'insertion en base
$insertPatient = $mysqlClient->prepare('INSERT INTO patients(nom, prenom, telephone, email, adress, code, ville) VALUES (:nom, :prenom, :telephone, :email, :adress, :code, :ville)');

$insertPatient->execute([
    'nom' => $nom,
    'prenom' => $prenom,
    'telephone' => $telephone,
    'email' => $email,
    'adress' => $adress,
    'code' => $code,
    'ville' => $ville,
]);
?>

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
    </div>
    
</body>
</html>