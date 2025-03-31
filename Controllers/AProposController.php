<?php

class AProposController{

    function showApropos(){
        $view = new View();
        $view -> render("aPropos", []);

    }
}