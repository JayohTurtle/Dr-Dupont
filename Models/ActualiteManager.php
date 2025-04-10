<?php

include_once('AbstractEntity.php');


class ActualiteManager extends AbstractEntityManager {
    
    public function getActualites(): array {
        $request = "SELECT * FROM actualites ORDER BY idActualite DESC"; // Trie par ID décroissant, permet d'afficher l'actualité la plus récente en premier
        $statement = $this->db->query($request);
        $actualitesArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $actualites = [];
        foreach ($actualitesArray as $data) {
            $actualites[] = new Actualite($data);
        }
    
        return $actualites;
    }

    //Fonction pour insérer unactualité
    public function insertActualite(Actualite $actualite) {
        $sql = 'INSERT INTO actualites (titre, contenu) 
                VALUES (:titre, :contenu)';
        $this->db->query($sql, [
            'titre' => $actualite->getTitre(),
            'contenu' => $actualite->getContenu(),
        ]);

        return true;
    }

    public function modifActualite(Actualite $actualite) {
        $sql = 'UPDATE actualites 
                SET titre = :titre, contenu = :contenu 
                WHERE idActualite = :idActualite'; 
    
        $this->db->query($sql, [
            'titre' => $actualite->getTitre(),
            'contenu' => $actualite->getContenu(),
            'idActualite' => $actualite->getIdActualite()
        ]);
    
        return true;
    }

    public function supprimActualite($idActualite) {
        $sql = "DELETE FROM actualites WHERE idActualite = :idActualite";
        $this->db->query($sql, ['idActualite' => $idActualite]);
        return true;
    }
    
}
    

