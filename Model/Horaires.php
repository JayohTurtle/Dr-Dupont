<?php

class Horaires{

    private int $id = 0;
    private string $jour = '';
    private string $amOpen = '00:00:00';
    private string $amClose = '00:00:00';
    private string $pmOpen = '00:00:00';
    private string $pmClose = '00:00:00';

    public function __construct(array $data = [])
    {
        if (!empty ($data)){
            $this -> hydrate($data);
        }
        
    }

    public function hydrate(array $data = []) {
        $this->id = $data['id'] ?? 0;
        $this->jour = $data['jour'] ?? '';
        $this->amOpen = $data['ouverture_am'] ?? '00:00:00';
        $this->amClose = $data['fermeture_am'] ?? '00:00:00';
        $this->pmOpen = $data['ouverture_pm'] ?? '00:00:00';
        $this->pmClose = $data['fermeture_pm'] ?? '00:00:00';
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

    public function setamOpen (string $amOpen) {
        $this -> amOpen = $amOpen;
    }

    public function getAmOpenFormatted(): string {
        return substr($this->amOpen, 0, 5); // Enlève les secondes (HH:MM)
    }

    public function setamClose (string $amClose) {
        $this -> amClose = $amClose;
    }

    public function getAmCloseFormatted(): string {
        return substr($this->amClose, 0, 5);
    }

    public function setpmOpen (string $pmOpen) {
        $this -> pmOpen = $pmOpen;
    }
    public function getPmOpenFormatted(): string {
        return substr($this->pmOpen, 0, 5);
    }

    public function setpmClose (string $pmClose) {
        $this -> pmClose = $pmClose;
    }

    public function getPmCloseFormatted(): string {
        return substr($this->pmClose, 0, 5);
    }

}