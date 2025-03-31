<?php

class RendezVousController{

    private $patientManager;
    private $rendezVousManager;
    private $soinManager;

    public function __construct() {
        $this->patientManager = new PatientManager();
        $this->rendezVousManager = new RendezVousManager();
        $this->soinManager = new SoinManager();
    }

    public function handleRendezVous(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = $this->sanitizeInput($_POST['nom']);
            $prenom = $this->sanitizeInput($_POST['prenom']);
            $email = $this->sanitizeInput($_POST['email']);
            $telephone = $this->sanitizeInput($_POST['telephone']);

            $patient = $this->addPatient($nom, $prenom, $email, $telephone);

            $idPatient = $patient->getIdPatient();

            $rendezVous = new RendezVous();
            $rendezVous->setDateRdv($_POST['dateRdv']);
            $rendezVous->setHeureRdv($_POST['hiddenTime']);
            $rendezVous->setSoin($_POST['soin']);
            $rendezVous->setIdPatient($idPatient);

            $this->showConfirmationRendezVous($idPatient, $patient, $rendezVous);
        }
    }

    public function addPatient($nom, $prenom, $email, $telephone) {

        // Ajout du patient et récupération de son ID
        $patient = new Patient([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone
        ]);
        // Vérifier si le patient existe déjà
        $existingiDPatient = $this->patientManager->patientExists($patient);
    
        if ($existingiDPatient) {
            return $this->patientManager->getPatientById($existingiDPatient);
        }
    
        // Insérer le patient dans la base de données et récupérer l'ID généré
        $idPatient = $this->patientManager->insertPatient($patient); // Hypothèse d'une méthode qui insère et retourne l'ID
    
        // Assigner l'ID au patient
        $patient->setIdPatient($idPatient);
    
        return $patient; // ✅ On retourne l'objet complet avec l'ID
    }
    
    public function showConfirmationRendezVous($idPatient, $patient, $rendezVous){

        //on enregistre les infos en session au cas où l'utilisateur souhaite modifier
        $_SESSION['nom'] = $_POST['nom'];
        $_SESSION['prenom'] = $_POST['prenom'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['telephone'] = $_POST['telephone'];
        $_SESSION['dateRdv'] = $_POST['dateRdv'];
        $_SESSION['hiddenTime'] = $_POST['hiddenTime'];
        $_SESSION['soin'] = $_POST['soin'];
        // On envoie les infos à la vue pour confirmation
        $view = new View();
        $view->render("creationRendezVous", [
            'patient' => $patient,
            'rendezVous' => $rendezVous,
            'nom' => $this->sanitizeInput($_POST['nom']),
            'prenom' => $this->sanitizeInput($_POST['prenom']),
            'email' => $this->sanitizeInput($_POST['email']),
            'telephone' => $this->sanitizeInput($_POST['telephone']),
            'dateRdv' => $_POST['dateRdv'],
            'heureRdv' => $_POST['hiddenTime'],
            'soins' => $this->sanitizeInput($_POST['soin']),
            'idPatient' => $idPatient
        ]);
    }

    public function confirmerRendezVous() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les données du formulaire
            $idPatient = $_POST['idPatient'];
            $dateRdv = $this->sanitizeInput($_POST['dateRdv']);
            $heureRdv = $this->sanitizeInput($_POST['heureRdv']);
            $soin = $this->sanitizeInput($_POST['soin']);

            //On passe la date récupérée au format dateTime avant insertion dans la base
            $dateRdv = date('Y-m-d', strtotime($dateRdv)); 
            $heureRdv = date('H:i', strtotime($heureRdv)); 

            $rendezVous = new RendezVous();
            $rendezVous->setIdPatient($idPatient);
            $rendezVous->setDateRdv($dateRdv);
            $rendezVous->setHeureRdv($heureRdv);
            $rendezVous->setSoin($soin);
    
            $this->rendezVousManager->insertRendezVous($rendezVous);

            // Vider et fermer la session après avoir confirmé le rendez-vous
            session_unset();
            session_destroy();
    
            $view = new View();
            $view -> render("confirmationFinale", [
            'rendezVous'=> $rendezVous
        ]);
        }
    }

    public function getJoursOuvert() {
        header("Content-Type: application/json");
        
        // Appel à la méthode getDates() du manager pour récupérer les jours valides
        $jours = $this->rendezVousManager->getJoursDispo();
        
        // Encodage des événements en JSON
        $json = json_encode($jours);
    
        // Envoie des données JSON au client
        echo $json;
        exit;
    }

    public function getCreneaux(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dateRdv = $this->sanitizeInput($_POST['hiddenDate']);

        // Appel à la méthode getDates() du manager pour récupérer les horaires libres
        $rdvPris = $this->rendezVousManager->getAvailableHoraires($dateRdv);

        header("Content-Type: application/json");
        // Encodage des événements en JSON
        $json = json_encode($rdvPris);
    
        // Envoie des données JSON au client
        echo $json;
        exit;
        }

    }
    
    public function showRdvForm(){

        $soins = $this->soinManager->getSoins();

        $view = new View();
        $view -> render("prendreRendezVous", ['soins'=>$soins]);
    }

     /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($value) {
        return !empty($value) ? trim(strip_tags($value)) : null;
    } 
    
    public function modifRendezVous(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idPatient = (int) $_POST["idPatient"];
            $soin = $_POST["soin"];
            $dateRdv = $_POST["dateRdv"];
            $dateRdvActuelle = $_POST["dateRdvActuelle"];
            $heureRdv = $_POST["heureRdv"];
    
            $success = $this->rendezVousManager->mettreAJourRendezVous($idPatient, $dateRdvActuelle, $soin, $dateRdv, $heureRdv);
            
            echo json_encode([
                "status" => $success ? "success" : "error",
                "message" => $success ? "Rendez-vous modifié" : "Erreur lors de la modification"
            ]);

            exit;
        }
    }

    public function showRendezVous(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dateRdv = $_POST['dateRdv'];

            $rendezVousList = $this->rendezVousManager->getRendezVousByDate($dateRdv);

            $view = new View();
            $view->render("rendezVous", [
                'rendezVousList' => $rendezVousList,
            ]);

            }
    }

    public function supprimRendezVous(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dateRdv = $_POST['dateRdvActuelle'];
            $idPatient = $_POST['idPatient'];

            $success = $this->rendezVousManager->supprimerRendezVous($dateRdv, $idPatient);

            echo json_encode([
                "status" => $success ? "success" : "error",
                "message" => $success ? "Rendez-vous supprimé" : "Erreur lors de la suppression"
            ]);

        }
    }
}

