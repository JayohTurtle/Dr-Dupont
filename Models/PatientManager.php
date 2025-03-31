<?php

include_once('AbstractEntityManager.php');

class PatientManager extends AbstractEntityManager {

    public function getPatients(): array {
        $request = "SELECT * FROM patients";
        $statement = $this->db->query($request);
        $patientsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $patients = [];
        foreach ($patientsArray as $data) {
            $patients[] = new Patient($data);
        }
    
        return $patients;
    }

    // Vérifier si le patient existe déjà
        
    public function patientExists($patient) {
        $sql = 'SELECT idPatient FROM patients
                WHERE (nom = :nom AND prenom = :prenom AND email = :email AND telephone = :telephone) 
                LIMIT 1';

        $query = $this->db->query($sql, [
            'nom' => $patient -> getNom(),
            'prenom' => $patient -> getPrenom(),
            'telephone' => $patient -> getTelephone(),
            'email' => $patient -> getEmail()
        ]);

        $patientId = (int) $query->fetchColumn(); // Récupère directement l'ID s'il existe et force le int

        return $patientId ?: null; // Retourne l'ID s'il existe, sinon null
    }

    // Ajouter un patient en base
    public function insertPatient(Patient $patient) {
        $sql = 'INSERT INTO patients (nom, prenom, telephone, email) 
                VALUES (:nom, :prenom, :telephone, :email)';
        $this->db->query($sql, [
            'nom' => $patient -> getNom(),
            'prenom' => $patient -> getPrenom(),
            'telephone' => $patient -> getTelephone(),
            'email' => $patient -> getEmail()
        ]);
    
        return $this->db->lastInsertId();
    }
    
    public function getPatientById($idPatient) {
        $sql = 'SELECT * FROM patients WHERE idPatient = :idPatient';
        $result = $this->db->query($sql, ['idPatient' => $idPatient])->fetch();
    
        if ($result) {
            $patient = new Patient();
            $patient->setIdPatient((int) $result['idPatient']);
            $patient->setNom($result['nom']);
            $patient->setPrenom($result['prenom']);
            $patient->setTelephone($result['telephone']);
            $patient->setEmail($result['email']);
            return $patient;
        }
    
        return null;
    }

    // Foncction pour récupérer un patient à partir d'une seule donnée
    public function extractResearchPatient($donneeRecherchee, $valeurRecherchee) {
        
        $sql = 'SELECT * FROM patients WHERE ' . $donneeRecherchee . ' = :value';

        // Appel du dbManager pour exécuter la requête
        $patientData = $this->db->query($sql, [
            'value' => $valeurRecherchee,
        ]);
        // Récupérer une seule ligne
        $patientData = $patientData->fetch(PDO::FETCH_ASSOC);
    
        // Vérifier si un résultat est trouvé
        if ($patientData) {
            $patient = new Patient();
            $patient->setIdpatient($patientData['idPatient']);
            $patient->setNom($patientData['nom']);
            $patient->setPrenom($patientData['prenom']);
            $patient->setEmail($patientData['email']);
            $patient->setTelephone($patientData['telephone']);
    
            return $patient;
        }
    
        return null;
    }

    public function extractResearchPatientByNomPrenom($nom, $prenom) {
        // Préparer la requête SQL pour chercher par nom et prénom
        $sql = 'SELECT * FROM patients WHERE nom = :nom AND prenom = :prenom LIMIT 1';
    
        // Exécution de la requête avec les paramètres nom et prénom
        $patientData = $this->db->query($sql, [
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
        
        // Récupérer une seule ligne de résultat
        $patientData = $patientData->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si un patient a été trouvé
        if ($patientData) {
            // Créer l'objet Patient avec les données récupérées
            $patient = new Patient();
            $patient->setIdPatient($patientData['idPatient']);        
            $patient->setNom($patientData['nom']);
            $patient->setPrenom($patientData['prenom']);
            $patient->setEmail($patientData['email']);
            $patient->setTelephone($patientData['telephone']);
    
            return $patient; // Retourne l'objet patient trouvé
        }
    
        return null; // Si aucun patient n'est trouvé, retourne null
    }

    public function getPatientByIdPatient($idPatient) {
        if (empty($idPatient)) {
            return null; // Retourne null si aucun ID n'est fourni
        }
    
        $sql = "SELECT * FROM patients WHERE idPatient = " . (int) $idPatient;
        
        // Exécution de la requête
        $result = $this->db->query($sql);
        
        // Récupérer un seul résultat
        $row = $result->fetch(PDO::FETCH_ASSOC);
    
        // Création et hydratation de l'objet Patient
        $patient = new Patient();
        $patient->setIdPatient($row['idPatient']);
        $patient->setNom($row['nom']);
        $patient->setPrenom($row['prenom']);
        $patient->setEmail($row['email']);
        $patient->setTelephone($row['telephone']);

        return $patient;
    }

    public function verifierEtMettreAJourPatient($idPatient, $champ, $nouvelleValeur) {
        // Vérifier si la donnée existe déjà pour ce Patient
        $sql = "SELECT $champ FROM patients WHERE idPatient = :idPatient";
        $patientActuel = $this->db->query($sql, [$idPatient])->fetch(PDO::FETCH_ASSOC);
    
        if (!$patientActuel) {
            return ["status" => "error", "message" => "Patient introuvable."];
        }
    
        $valeurExistante = $patientActuel[$champ];
    
        // Si la valeur est identique, ne rien faire
        if ($valeurExistante === $nouvelleValeur) {
            return ["status" => "no_change", "message" => "Aucune modification nécessaire."];
        }
    
        // Si le champ est vide, mettre à jour directement
        if (empty($valeurExistante)) {
            $this->mettreAJourPatient($idPatient, $champ, $nouvelleValeur);
            return ["status" => "success", "message" => "Donnée mise à jour avec succès."];
        }
    
        // Si une modification est nécessaire, demander confirmation
        return [
            "status" => "confirm_required",
            "message" => "Une modification est détectée, confirmation requise.",
            "champ" => $champ,
            "ancien" => $valeurExistante,
            "nouveau" => $nouvelleValeur,
            "idPatient" => $idPatient
        ];
    }
    
    public function mettreAJourPatient($idPatient, $champ, $valeur) {
        // Mise à jour du patient
        $sql = "UPDATE patients SET $champ = ? WHERE idPatient = ?";
        $this->db->query($sql, [$valeur, $idPatient]);
    
        return ["status" => "success", "message" => "Modification effectuée."];
    }   
}