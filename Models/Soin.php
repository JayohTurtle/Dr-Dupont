<?php

include_once('AbstractEntity.php');

class Soin extends AbstractEntity{

    private int $idSoin;
    private string $soin;

    public function setIdSoin(int $idSoin): void {
        $this->idSoin = $idSoin;
    }

    public function getIdSoin(): int{
        return $this->idSoin;
    }

    public function setSoin(string $soin) {
        $this->soin = $soin;
    }

    public function getSoin(): string{
        return $this->soin;
    }

}