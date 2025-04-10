<?php

class AdminController{

    private $actualiteManager;
    private $patientManager;
    private $soinManager;
    private $serviceManager;

    public function __construct() {

        $this->actualiteManager = new ActualiteManager();
        $this->patientManager = new PatientManager();
        $this->soinManager = new SoinManager();
        $this->serviceManager = new ServiceManager();

    }

    function showAdmin(){

        $actualites = $this->actualiteManager->getActualites();
        $patients = $this->patientManager->getPatients();
        $soins = $this->soinManager->getSoins();
        $services = $this->serviceManager->getServices();

        $view = new View();
        $view -> render("admin", [
            'actualites' => $actualites,
            'patients' => $patients,
            'services' => $services,
            'soins' => $soins
        ]);
    }
}
