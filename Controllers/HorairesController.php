<?php

class HorairesController{

    private $horairesManager;

    public function __construct() {
        $this->horairesManager = new HorairesManager();
    }

    function modifHoraires(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $jour = $_POST['jour'];
            $ouvertureAm = $_POST['ouvertureAm'];
            $fermetureAm = $_POST['fermetureAm'];
            $ouverturePm = $_POST['ouverturePm'];
            $fermeturePm = $_POST['fermeturePm'];

            $newHoraires = new Horaires();
            $newHoraires->setJour($jour);
            $newHoraires->setOuvertureAm($ouvertureAm);
            $newHoraires->setFermetureAm($fermetureAm);
            $newHoraires->setOuverturePm($ouverturePm);
            $newHoraires->setFermeturePm($fermeturePm);

            $successHoraires = $this->horairesManager->modifHoraires($newHoraires);

            $view = new View();
            $view->render('admin', [
                'jour' => $jour,
                'successHoraires' => $successHoraires,
            ]);
        }
    }
}