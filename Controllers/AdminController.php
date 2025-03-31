<?php

class AdminController{

    private $actualiteManager;
    private $patientManager;
    private $soinManager;

    public function __construct() {

        $this->actualiteManager = new ActualiteManager();
        $this->patientManager = new PatientManager();
        $this->soinManager = new SoinManager();

    }

    function showAdmin(){

        $actualites = $this->actualiteManager->getActualites();
        $patients = $this->patientManager->getPatients();
        $soins = $this->soinManager->getSoins();

        $view = new View();
        $view -> render("admin", [
            'actualites' => $actualites,
            'patients' => $patients,
            'soins' => $soins
        ]);
    }
}
