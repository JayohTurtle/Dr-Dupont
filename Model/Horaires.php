<?php

class Horaires{

    private int $id = 0;
    private string $jour = '';
    private string $ouvertureAm = '00:00:00';
    private string $fermetureAm = '00:00:00';
    private string $ouverturePm = '00:00:00';
    private string $fermeturePm = '00:00:00';

    public function __construct(array $data = [])
    {
        if (!empty ($data)){
            $this -> hydrate($data);
        }
        
    }

    public function hydrate(array $data = []) {
        foreach ($data as $key => $value){
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
        
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function setId (int $id) : void{
        $this -> id = $id;
    }

    public function getId ():int{
        return $this -> id;
    }

    public function setJour (string $jour){
        $this -> jour = $jour;
    }

    public function getJour ():string{
        return $this -> jour;
    }

    public function setOuvertureAm (string $ouvertureAm) {
        $this -> ouvertureAm = $ouvertureAm;
    }

    public function getOuvertureAmFormatted(): string {
        return substr($this->ouvertureAm, 0, 5); // Enlève les secondes (HH:MM)
    }

    public function setFermetureAm (string $fermetureAm) {
        $this -> fermetureAm = $fermetureAm;
    }

    public function getFermetureAmFormatted(): string {
        return substr($this->fermetureAm, 0, 5);
    }

    public function setOuverturePm (string $ouverturePm) {
        $this -> ouverturePm = $ouverturePm;
    }
    public function getOuverturePmFormatted(): string {
        return substr($this->ouverturePm, 0, 5);
    }

    public function setFermeturePm (string $fermeturePm) {
        $this -> fermeturePm = $fermeturePm;
    }

    public function getFermeturePmFormatted(): string {
        return substr($this->fermeturePm, 0, 5);
    }

}