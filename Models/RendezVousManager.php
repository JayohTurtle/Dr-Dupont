<?php

include_once('AbstractEntityManager.php');

class RendezVousManager extends AbstractEntityManager {
    
    public function insertRendezVous(RendezVous $rendezVous) {
        $sql = 'INSERT INTO rendezvous (dateRdv, heureRdv, soin, idPatient) 
                VALUES (:dateRdv, :heureRdv, :soin, :idPatient)';
        $this->db->query($sql, [
            'dateRdv' => $rendezVous->getDateRdv(),
            'heureRdv' =>$rendezVous->getHeureRdv(),
            'soin' => $rendezVous->getSoin(),
            'idPatient' => $rendezVous->getIdPatient()
        ]);
    }

    public function getJoursDispo() {
        // Requête pour récupérer les jours avec horaires valides
        $sql = "SELECT jour FROM horaires WHERE (ouvertureAm != '00:00:00' AND ouverturePm != '00:00:00')";
        $result = $this->db->query($sql);
        
        // Tableau de correspondance des jours en anglais
        $joursEnAnglais = [
            "Lundi"     => "Monday",
            "Mardi"     => "Tuesday",
            "Mercredi"  => "Wednesday",
            "Jeudi"     => "Thursday",
            "Vendredi"  => "Friday",
            "Samedi"    => "Saturday",
            "Dimanche"  => "Sunday"
        ];
        
        // Récupérer les résultats sous forme de tableau
        $joursDispoEnFrançais = $result->fetchAll(PDO::FETCH_ASSOC);
    
        // Convertir les jours de français à anglais
        $joursDispoEnAnglais = [];
        foreach ($joursDispoEnFrançais as $jour) {
            $nomJour = ucfirst(strtolower($jour['jour']));
            if (isset($joursEnAnglais[$nomJour])) {
                $joursDispoEnAnglais[] = $joursEnAnglais[$nomJour];
            }
        }
    
        // Calculer les 30 prochains jours
        $jours = [];
        for ($i = 0; $i < 30; $i++) {
            $dateActuelle = new DateTime();
            $dateActuelle->modify("+$i day");
            $jourEnAnglais = $dateActuelle->format('l'); 
            
            // Si le jour est dans les jours valides
            if (in_array($jourEnAnglais, $joursDispoEnAnglais)) {
                $jours[] = $dateActuelle->format('Y-m-d');  // format YYYY-MM-DD
            }
        }

        // Retourner les jours valides pour les 30 jours à venir
        return $jours;
    }

    private function convertDayToFrench($day) {
        $days = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];
    
        return $days[$day] ?? $day;
    }
    
    public function getAvailableHoraires($dateRdv): array {
        // Déterminer le jour de la semaine pour la date donnée
        $jourSemaineEn = date('l', strtotime($dateRdv)); // 'l' renvoie le nom complet du jour en anglais (e.g., Monday)
        $jourSemaine = $this->convertDayToFrench($jourSemaineEn);

        // Récupérer les horaires d'ouverture et de fermeture pour le jour de la semaine
        $sql = "SELECT ouvertureAm, fermetureAm, ouverturePm, fermeturePm FROM horaires WHERE jour = :jour";
        $stmt = $this->db->query($sql, ['jour' => $jourSemaine]);
        $horaires = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Générer les créneaux horaires disponibles
        $creneauxDisponibles = [];
        if ($horaires) {
            $creneauxDisponibles = array_merge(
                $this->generateCreneaux($horaires['ouvertureAm'], $horaires['fermetureAm']),
                $this->generateCreneaux($horaires['ouverturePm'], $horaires['fermeturePm'])
            );
        }
 
        // Récupérer les créneaux déjà pris pour la date donnée
        $sql = "SELECT heureRdv FROM rendezvous WHERE dateRdv = :dateRdv";
        $stmt = $this->db->query($sql, ['dateRdv' => $dateRdv]);
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        $creneauxPris = array_map(function($time) {
            return DateTime::createFromFormat('H:i:s', $time)->format('H:i');
        }, $result);

        // Exclure les créneaux pris des créneaux disponibles
        $creneauxLibres = array_diff($creneauxDisponibles, $creneauxPris);
    
        return array_values($creneauxLibres);
    }
    
    // Méthode pour générer les créneaux horaires entre deux heures données
    private function generateCreneaux($heureDebut, $heureFin): array {
        $creneaux = [];
        $debut = strtotime($heureDebut);
        $fin = strtotime($heureFin);
    
        while ($debut < $fin) {
            $creneaux[] = date('H:i', $debut);
            $debut = strtotime('+30 minutes', $debut);
        }
    
        return $creneaux;
    }

    public function getRendezVousByIdPatient($idPatient) {
        if (empty($idPatient)) {
            return null; // Retourne null si aucun ID n'est fourni
        }
    
        $sql = "SELECT * FROM rendezvous WHERE idPatient = " . (int) $idPatient;
        
        $result = $this->db->query($sql);

        $rendezVousList = [];

        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $rendezVous = new RendezVous();
            $rendezVous->setIdPatient($row['idPatient']);
            $rendezVous->setDateRdv($row['dateRdv']);
            $rendezVous->setHeureRdv($row['heureRdv']);
            $rendezVous->setSoin($row['soin']);

            $rendezVousList[] = $rendezVous;
        }

        return $rendezVousList;
    }

    public function getProchainRendezVous($idPatient) {
        if (empty($idPatient)) {
            return null; // Retourne null si aucun ID n'est fourni
        }
    
        $sql = "SELECT * FROM rendezvous 
                WHERE idPatient = " . (int) $idPatient . " 
                AND CONCAT(dateRdv, ' ', heureRdv) > NOW() 
                ORDER BY dateRdv ASC, heureRdv ASC 
                LIMIT 1";
    
        $result = $this->db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            $rendezVous = new RendezVous();
            $rendezVous->setIdPatient($row['idPatient']);
            $rendezVous->setDateRdv($row['dateRdv']);
            $rendezVous->setHeureRdv($row['heureRdv']);
            $rendezVous->setSoin($row['soin']);
    
            return $rendezVous;
        }
    
        return null; // Aucun rendez-vous futur trouvé
    }

    public function mettreAJourRendezVous($idPatient, $dateRdvActuelle, $soin, $dateRdv, $heureRdv) {

        $sql = "UPDATE rendezvous
                SET soin = :soin, dateRdv = :dateRdv, heureRdv = :heureRdv
                WHERE idPatient = :idPatient AND dateRdv = :dateRdvActuelle";
    
        $params = [
            ':soin' => $soin,
            ':dateRdv' => $dateRdv,
            ':heureRdv' => $heureRdv,
            ':idPatient' => $idPatient,
            ':dateRdvActuelle' => $dateRdvActuelle
        ];
    
        $this->db->query($sql, $params);

        return true;
    }

    public function getRendezVousByDate($dateRdv) {
        $sql = "SELECT r.*, p.nom, p.prenom 
                FROM rendezvous r
                JOIN patients p ON r.idPatient = p.idPatient
                WHERE r.dateRdv = :dateRdv";
    
        $result = $this->db->query($sql, ['dateRdv' => $dateRdv]);
    
        $rendezVousList = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rendezVous = new RendezVous($row); // Crée un objet RendezVous
    
            // Ajouter directement le nom et prénom du patient
            $rendezVous->setNom($row['nom']);
            $rendezVous->setPrenom($row['prenom']);
    
            $rendezVousList[] = $rendezVous;
        }
    
        return $rendezVousList;
    }    
}
    
