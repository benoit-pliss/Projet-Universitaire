<?php

include 'src/html/header.phtml';
include 'src/php/util/info_conn.php';
include 'src/php/util/fonction.php';


if (!empty($_GET["n_coureur"])){
    $n_coureur = $_GET['n_coureur'];
    if (!is_numeric($n_coureur)) exit();

    $rescoureur = getRescoureur($conn, $n_coureur);
    $resparticoureur = getResparticoureur($conn, $n_coureur, $rescoureur);

    $nom = $rescoureur["NOM"];
    $prenom = $rescoureur["PRENOM"];
    $naissance = $rescoureur["ANNEE_NAISSANCE"];
    $age = $rescoureur['AGE'];



    if(isset($_POST['valid_modif'])){
        include_once "modification_coureur.php";
    } else {

    }
    include "src/html/coureur.phtml";

}




