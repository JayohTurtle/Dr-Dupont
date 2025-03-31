<?php

include_once('AbstractEntityManager.php');

class SoinManager extends AbstractEntityManager {

    public function insertSoin(Soin $soin) {
        $sql = 'INSERT INTO soins (soin) 
                VALUES (:soin)';
        $this->db->query($sql, [
            'soin' => $soin->getSoin(),
        ]);

        return true;
    }

    public function modifSoin(Soin $soin) {
        $sql = 'UPDATE soins 
                SET soin = :soin 
                WHERE idSoin = :idSoin'; 
    
        $this->db->query($sql, [
            'soin' => $soin->getSoin(),
            'idSoin' => $soin->getIdSoin()
        ]);
    
        return true;
    }
    
    public function supprimSoin($idSoin) {
        $sql = "DELETE FROM soins WHERE idSoin = :idSoin";
        $this->db->query($sql, ['idSoin' => $idSoin]);
        return true;
    }
    
    public function getSoins(): array {
        $request = "SELECT * FROM soins";
        $statement = $this->db->query($request);
        $soinsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $soins = [];
        foreach ($soinsArray as $data) {
            $soins[] = new Soin($data);
        }
    
        return $soins;
    }
    
}