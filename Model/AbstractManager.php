
<?php

abstract class AbstractManager{
//model = gestion des données
    public $db;

    public function __construct(){
        $this -> db = new PDO('mysql:host='. DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        $this -> db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this -> db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO ::FETCH_ASSOC);
    }

}