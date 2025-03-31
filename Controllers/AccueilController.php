<?php

class AccueilController{

    private $horairesManager ;

    public function __construct() {
        $this->horairesManager = new HorairesManager();
    }

    function showDaysList(){
        $horaires = $this-> horairesManager -> getHoraires();
        $view = new View();
        $view -> render("accueil",[
            'horaires' => $horaires
        ]);
    }
}