<?php

function dbConnect() {
    $connectString = "mysql:host=localhost;dbname=tp_store;charset=utf8";
    try {
    $bdd = new PDO($connectString, "root", "", 
                array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)
            );
            return $bdd;
    }
    catch (PDOException $ex) {
        var_dump("Erreur GET COURSE: {$ex->getMessage()}");
    }
}