<?php

include_once('AbstractEntityManager.php');

class Actualite extends AbstractEntity{

    private int $idActualite = 0;
    private string $titre = '';
    private string $contenu = '';

    

    public function setIdActualite (int $idActualite) : void{
        $this -> idActualite = $idActualite;
    }

    public function getIdActualite ():int{
        return $this -> idActualite;
    }

    public function setTitre (string $titre){
        $this -> titre = $titre;
    }

    public function getTitre ():string{
        return $this -> titre;
    }

    public function setContenu (string $contenu) {
        $this -> contenu = $contenu;
    }

    public function getContenu(): string {
        return $this->contenu;
    }

}
