<?php

$postData = $_POST;

$date = trim(strip_tags($postData['date']));
$time = trim(strip_tags($postData['time']));
$nom = trim(strip_tags($postData['nom']));
$prenom = trim(strip_tags($postData['prenom']));
$telephone = trim(strip_tags($postData['telephone']));
$email = trim(strip_tags($postData['email']));
$soin = trim(strip_tags($postData['soin']));

//On vérifie si le patient existe déjà dans la base de données
$checkPatient = $this -> db ->prepare('SELECT * FROM patients WHERE nom = :nom AND prenom = :prenom');
$checkPatient->execute([
    'nom' => $nom,
    'prenom' => $prenom,
]);

//Si le patient n'existe pas, on l'ajoute
if (!$checkPatient->rowCount() > 0) {
    //on entre le client dans la base de données
    $insertPatient = $this -> db ->prepare('INSERT INTO patients(nom, prenom, telephone, email) VALUES (:nom, :prenom, :telephone, :email)');

    $insertPatient->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'telephone' => $telephone,
        'email' => $email,
]);;
    return;
}

// Enregistrement des données en session pour utilisation sur page confirmation.php ou retour sur page confirmation_rdv.php
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['telephone'] = $telephone;
$_SESSION['email'] = $email;
$_SESSION['soin'] = $soin;
$_SESSION['date'] = $date;
$_SESSION['time'] = $time;

?>