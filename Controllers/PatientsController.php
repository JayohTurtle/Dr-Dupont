<?php

class PatientsController{

    private $patientManager;
    private $rendezVousManager;
    private $soinManager;

    public function __construct() {

        $this->patientManager = new PatientManager();
        $this->rendezVousManager = new RendezVousManager();
        $this->soinManager = new SoinManager();
    }

    public function handlePatients(){

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $donnees = [
            'nom' => $this->sanitizeInput($_POST['nomPatient'] ?? ''),
            'email' => $this->sanitizeInput($_POST['emailPatient'] ?? ''),
            'telephone' => $this->sanitizeInput($_POST['telephonePatient'] ?? ''),
        ];

        if(!empty ($_POST['nomPatient'])){
            //on récupère le nom et le prénom
            $nomComplet = $donnees['nom'];
            
            $nomPrenom = explode(' ', $nomComplet, 2);

            $nom = $nomPrenom[0] ?? ''; 
            $prenom = $nomPrenom[1] ?? '';
        }
        $donneeRecherchee = null;
        $valeurRecherchee = null;

        foreach ($donnees as $champ => $valeur) {
            if (!empty($valeur)) {
                $donneeRecherchee = $champ;
                $valeurRecherchee = $valeur;
                break;
            }
        }

        $rendezVous = null;

        if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
            $patient = null;

            // on recherhce par le mail, le téléphone ou le nom et le prénom
            switch ($donneeRecherchee) {
                case 'email':

                    $patient = $this->patientManager->extractResearchPatient('email', $valeurRecherchee);
                    break;
                
                case 'telephone':

                    $patient = $this->patientManager->extractResearchPatient('telephone', $valeurRecherchee);                    
                    break;

                case 'nom':

                    // Recherche avec le nom et le prénom
                    $patient = $this->patientManager->extractResearchPatientByNomPrenom($nom, $prenom);
                    break;
            }
            
            $idPatient = $patient->getIdPatient();

            $rendezVous = $this->rendezVousManager->getRendezVousByIdPatient($idPatient);
            $prochainRendezVous = $this->rendezVousManager->getProchainRendezVous($idPatient);
            $soins = $this->soinManager->getSoins();
            // Passer les résultats à la vue
            $view = new View();
            $view->render('patient', [
                'patient' => $patient,
                'rendezVous' => $rendezVous,
                'prochainRendezVous' => $prochainRendezVous,
                'soins' => $soins
            ]);
            }
        }
    }

    public function modifInfoPatient(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idPatient = (int) $_POST["idPatient"];
            $champ = $_POST["champ"];
            $valeur = $_POST["valeur"];
    
            $resultat = $this->patientManager->verifierEtMettreAJourPatient($idPatient, $champ, $valeur);
            
            echo json_encode($resultat);
            exit;
        }
    }

    public function handleConfirmationModificationPatient() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST["idPatient"], $_POST["champ"], $_POST["valeur"])) {
                echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
                exit;
            }
    
            $idPatient = (int) $_POST["idPatient"];
            $champ = $_POST["champ"];
            $valeur = $_POST["valeur"];
    
            $this->patientManager->mettreAJourPatient($idPatient, $champ, $valeur);
    
            echo json_encode(["status" => "success"]);
            exit;
        }
    }

     /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return trim(strip_tags($input)); // Supprime les balises HTML/PHP et les espaces
    }   
}
