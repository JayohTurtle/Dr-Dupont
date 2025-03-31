<?php

include_once('AbstractEntityManager.php');
class HorairesManager extends AbstractEntityManager {
    
    public function getHoraires(): array {
        $request = "SELECT * FROM horaires";
        $statement = $this->db->query($request);
        $horairesArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $horaires = [];
        foreach ($horairesArray as $data) {
            $horaires[] = new Horaires($data);
        }
    
        return $horaires;
    }

    public function modifHoraires(Horaires $newHoraires) {
        // Récupération des valeurs à partir de l'objet Horaires
        $jour = $newHoraires->getJour();
        $ouvertureAm = $newHoraires->getOuvertureAmFormatted();
        $fermetureAm = $newHoraires->getFermetureAmFormatted();
        $ouverturePm = $newHoraires->getOuverturePmFormatted();
        $fermeturePm = $newHoraires->getFermeturePmFormatted();
    
        // Construction de la requête SQL pour mettre à jour les horaires pour un jour spécifique
        $sql = "UPDATE horaires
                SET 
                    ouvertureAm = '$ouvertureAm',
                    fermetureAm = '$fermetureAm',
                    ouverturePm = '$ouverturePm',
                    fermeturePm = '$fermeturePm'
                WHERE jour = '$jour'";
    
        // Exécution de la requête
        return $this->db->query($sql);
    }
    
}



        