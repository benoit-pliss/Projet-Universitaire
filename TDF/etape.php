<?php

if (isset($_GET['ANNEE'])){
    if (!empty($_GET['ANNEE'])){
        $annee = $_GET['ANNEE'];
        if (!verifAnnee($annee)){
            $erreurAnnee[] = "Le format de l'année est incorrect";
        }
    }
}

if (!isset($annee))
    $annee = date('Y');

echo $annee;
