<?php


class Controller{

    function showDaysList(){
        $HorairesManager = new HorairesManager();
        $horaires = $HorairesManager -> getHoraires();
        $view = new View();
        $view -> render("accueil",[
            'horaires' => $horaires
        ]);
    }

    function showSoins(){
        $view = new View();
        $view -> render("soins", []);

    }

    function showApropos(){
        $view = new View();
        $view -> render("aPropos", []);

    }

    function showActualites(){
        $view = new View();
        $view -> render("actualites", []);

    }
    
    function showRdvForm(){
        $view = new View();
        $view -> render("new_rdv", []);
    }

    function showConfirmationRdv(){
        $view = new View();
        $view -> render("confirmation_rdv", []);

    }

}

?>