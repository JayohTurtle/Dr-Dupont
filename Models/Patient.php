<?php

include_once('AbstractEntity.php');
class Patient extends AbstractEntity{

    private int $idPatient;
    private string $prenom;
    private string $nom;
    private string $email;
    private string $telephone;

    public function setIdPatient(int $idPatient): void {
        $this->idPatient = $idPatient;
    }

    public function getIdPatient(): int{
        return $this->idPatient;
    }

    public function setPrenom(string $prenom) {
        $this->prenom = $prenom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setTelephone(string $telephone) {
        $this->telephone = $telephone;
    }

    public function getTelephone(): string{
        return $this->telephone;
    }

}

