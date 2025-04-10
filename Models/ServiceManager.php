<?php

include_once('AbstractEntityManager.php');

class ServiceManager extends AbstractEntityManager {

    //Fonction pour insérer un service
    public function insertService(Service $service) {
        $sql = 'INSERT INTO services (soin, description) 
                VALUES (:soin, :description)';
        $this->db->query($sql, [
            'soin' => $service->getService(),
            'description' => $service->getDescription(),
        ]);

        return true;
    }

    public function modifService(Service $service) {
        $sql = 'UPDATE services 
                SET service = :service, description = :description 
                WHERE idService = :idService'; 
    
        $this->db->query($sql, [
            'service' => $service->getService(),
            'description' => $service->getDescription(),
            'idService' => $service->getIdService()
        ]);
    
        return true;
    }
    
    public function supprimService($idService) {
        $sql = "DELETE FROM services WHERE idService = :idService";
        $this->db->query($sql, ['idService' => $idService]);
        return true;
    }
    
    public function getServices(): array {
        $request = "SELECT * FROM services";
        $statement = $this->db->query($request);
        $servicesArray = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $services = [];
        foreach ($servicesArray as $data) {
            $services[] = new Service($data);
        }
    
        return $services;
    }
    
}