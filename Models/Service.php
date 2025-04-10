<?php

include_once('AbstractEntity.php');

class Service extends AbstractEntity{

    private int $idService;
    private string $service;
    private string $description;

    public function setIdService(int $idService): void {
        $this->idService = $idService;
    }

    public function getIdService(): int{
        return $this->idService;
    }

    public function setService(string $service) {
        $this->service = $service;
    }

    public function getService(): string{
        return $this->service;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }   

    public function getDescription(): string{
        return $this->description;
    }

}