<?php
session_start();

include_once('config.php');
include_once('Model/Horaires.php');
include_once('Model/AbstractManager.php');
include_once('Model/HorairesManager.php');
include_once('view.php');
include_once('controller.php');

    $action = $_REQUEST['action'] ?? 'accueil';

    $controller = new Controller();

    switch ($action){
        case 'accueil':
            $controller -> showDaysList();
        break;

        case 'soins':
            $controller -> showSoins();
        break;

        case 'aPropos':
            $controller -> showApropos();
        break;

        case 'actualites':
            $controller -> showActualites();
        break;

        case 'new_rdv':
            $controller -> showRdvForm();
        break;

        case 'confirmation_rdv':
            $controller -> showConfirmationRdv();
        break;

        default:

        echo ("La page $action n'existe pas");

        break;

    }

?>

