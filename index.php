<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once('config.php');
include_once('view.php');


// Auto-chargement des modèles et contrôleurs (évite les include à rallonge)
spl_autoload_register(function ($class) {
    if (file_exists("Models/$class.php")) {
        include_once "Models/$class.php";
    } elseif (file_exists("Controllers/$class.php")) {
        include_once "Controllers/$class.php";
    }
});
    $action = $_REQUEST['action'] ?? 'accueil';

    $controller = null;

    switch ($action){

        case 'accueil':
            $controller = new AccueilController();
            $controller -> showDaysList();
        break;

        case 'connect':

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['user'])) {
                header('Location: index.php?action=admin');
                exit;
            }

            $controller = new UserConnectController();
            $controller->showUserFormConnect();
        break;
        
        case 'changePassword':
            $controller = new ChangePasswordController();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $controller->changePassword();
            } else {
                $controller->showChangePasswordForm();
            }
        break;

        case 'createUser':
            if (isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'Administrateur') {
                $controller = new UserConnectController();
                $controller->showCreateUser();
            } else{
                $_SESSION['error'] = "Accès refusé : droits insuffisants.";
                header("Location: index.php?action=admin");
                exit;
            }
        break;

        case 'userCreated':
            $controller = new UserConnectController();
            $controller->userCreated();
            break;

        case 'login':
            $controller = new UserConnectController();
            $controller->login();
            break;

        case 'logout':
            $controller = new UserConnectController();
            $controller->logout();
            break;

        case 'admin':
            if (!isset($_SESSION['user'])) {
                header('Location: index.php?action=connect');
                exit;
            }
            $controller = new AdminController();
            $controller->showAdmin();
            break;

        case 'modifHoraires':
            $controller = new HorairesController();
            $controller -> modifHoraires();
        break;

        case 'modifRendezVous':
            $controller = new RendezVousController();
            $controller -> modifRendezVous();
        break;

        case 'supprimRendezVous':
            $controller = new RendezVousController();
            $controller -> supprimRendezVous();
        break;

        case 'ajoutRendezVous':
            $controller = new RendezVousController();
            $controller -> ajoutRendezVous();
        break;

        case 'gestionActualites':
            $controller = new ActualitesController();
            $controller -> modifActualites();

        case 'gestionPatients':
            $controller = new PatientsController();
            $controller -> handlePatients();

        case 'gestionRdv':
            $controller = new RendezVousController();
            $controller -> showRendezVous();
        break;

        case 'services':
            $controller = new ServicesController();
            $controller -> showServices();
        break;

        case 'modifServices':
            $controller = new ServicesController();
            $controller -> modifServices();
        break;

        case 'modifSoins':
            $controller = new SoinsController();
            $controller -> modifSoins();
        break;

        case 'aPropos':
            $controller = new AProposController();
            $controller -> showApropos();
        break;

        case 'actualites':
            $controller = new ActualitesController();
            $controller -> showActualites();
        break;

        case 'prendreRendezVous':
            $controller = new RendezVousController();
            $controller -> showRdvForm();
        break;

       case 'creationRendezVous':
           $controller = new RendezVousController();
           $controller->handleRendezVous();
        break;

        case 'getJoursOuvert':
            $controller = new RendezVousController();
            $controller->getJoursOuvert();
            exit;
        break;

        case 'getCreneaux':
            $controller = new RendezVousController();
            $controller->getCreneaux();
            exit;
        break;
        
        case 'confirmationRendezVous':
            $controller = new RendezVousController();
            $controller->confirmerRendezVous();
        break;

        case 'ajoutInfoPatient':
            $controller = new PatientsController();
            $controller->modifInfoPatient();
        break;

        case 'confirmerModificationPatient':
            $controller = new PatientsController();
            $controller->handleConfirmationModificationPatient();
            break;

        default:

            echo ("La page $action n'existe pas");

        break;

    }

?>

