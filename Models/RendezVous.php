<?php

include_once('AbstractEntity.php');
class RendezVous extends AbstractEntity{

    private int $idRdv;
    private string $dateRdv;
    private string $heureRdv;
    private string $soin;
    private int $idPatient;

    public function setIdRdv(int $idRdv): void {
        $this->idRdv = $idRdv;
    }

    public function getIdRdv(): int{
        return $this->idRdv;
    }

    public function setIdPatient(int $idPatient) {
        $this->idPatient = $idPatient;
    }

    public function getIdPatient(): int{
        return $this->idPatient;
    }

    public function setDateRdv(string $dateRdv) {
        $this->dateRdv = $dateRdv;
    }

    public function getDateRdv(): string{
        return $this->dateRdv;
    }

    public function setHeureRdv(string $heureRdv) {
        $this->heureRdv = $heureRdv;
    }

    public function getHeureRdv(): string{
        return $this->heureRdv;
    }

    public function getDateRdvFormatFr(): string {
        if ($this->dateRdv) {
            $date = DateTime::createFromFormat('Y-m-d', $this->dateRdv);
            return $date ? $date->format('d-m-Y') : "";
        }
        return "";
    }

    public function setSoin(string $soin) {
        $this->soin = $soin;
    }

    public function getSoin(): string{
        return $this->soin;
    }

}