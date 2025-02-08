<?php

include_once('AbstractManager.php');


class HorairesManager extends AbstractManager {
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
    
}



        