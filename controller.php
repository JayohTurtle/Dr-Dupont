<?php


class Controller{

    function showDaysList(){
        $model = new Model();
        $daysList = $model -> getDaysList();
        $view = new View();
        $view -> render("accueil",[
            'daysList' => $daysList
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