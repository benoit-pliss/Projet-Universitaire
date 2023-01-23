<?php

include "src/html/header.phtml";
include "src/php/util/info_conn.php";
include "src/php/util/fonction_verif.php";
include "src/php/util/fonction_parti.php";
include "src/php/util/remplissage_form.php";
include "src/php/util/fonction.php";
$erreur = false;

$erreurAnnee = array();
$erreurDirecteurs = array();
$erreurEquipe = array();



if (isset($_GET['ANNEE'])) {
    if (!empty($_GET['ANNEE'])) {
        $annee = $_GET['ANNEE'];
        if (!verifAnnee($annee)) {
            $erreurAnnee[] = "Le format de l'année est incorrect";
        }
    } else {
        $erreurAnnee[] = "Veuillez renseigner une année";
    }

    //S'il n'y a pas d'erreur sur l'année et que l'année est renseignée
}

$anneeCorrecte = isset($_GET['ANNEE']) && empty($erreurAnnee);




if (isset($_POST['subButton']) && $anneeCorrecte) {

    if (isset($_POST['directeurs'])) {
        $nb = count($_POST['directeurs']);
        if ($nb == 0)
            $erreurDirecteurs[] = "Veuillez sélectionner au moins un directeur";
        elseif ($nb > 3)
            $erreurDirecteurs[] = "Vous pouvez sélectionner au maximum 3 directeurs";
        else {
            $directeurs = $_POST['directeurs'];
            if (count(array_unique($directeurs)) != $nb)
                $erreurDirecteurs[] = "Vous ne pouvez pas sélectionner deux fois le même directeur";
            foreach ($directeurs as $directeur) {
                if (verifDirecteurPasDejaParticipant($directeur, $annee, $conn)) {
                    $erreurDirecteurs[] = "Le directeur $directeur est déjà participant";
                }
            }
            for ($i = 1; $i < 3; $i++) {
                if (!isset($directeurs[$i])) {
                    $directeurs[$i] = null;
                }
            }
        }
    } else {
        $erreurDirecteurs[] = "Veuillez sélectionner au moins un directeur";
    }

    if (!empty($_POST['EQUIPE'])){
        $equipe = explode("~", $_POST['EQUIPE']);
        $n_equipe = $equipe[0];
        $n_sponsor = $equipe[1];

        if (verifEquipeParticipante($n_equipe, $n_sponsor, $annee, $conn)) {
            $erreurEquipe[] = "L'équipe est déjà participante pour cette année";
        }


    } else {
        $erreurEquipe[] = "Veuillez sélectionner une équipe";
    }

    $erreur = !empty($erreurDirecteurs) || !empty($erreurEquipe) || !empty($erreurAnnee);

    if (!$erreur) {
        $req = $conn->prepare("insert into TDF_PARTI_EQUIPE(ANNEE, N_EQUIPE, N_SPONSOR, N_PRE_DIRECTEUR, N_SEC_DIRECTEUR, N_TROI_DIRECTEUR, COMPTE_ORACLE, DATE_INSERT)
                                    values (:annee, :n_equipe, :n_sponsor, :n_pre_directeur, :n_sec_directeur, :n_troi_directeur, 'PPHP2A_05', sysdate)");
        $req->bindParam(':annee', $annee);
        $req->bindParam(':n_equipe', $n_equipe);
        $req->bindParam(':n_sponsor', $n_sponsor);
        $req->bindParam(':n_pre_directeur', $directeurs[0]);
        $req->bindParam(':n_sec_directeur', $directeurs[1]);
        $req->bindParam(':n_troi_directeur', $directeurs[2]);
        $req->execute();
        if ($req->errorCode() != 0) {
            print_r($req->errorInfo());
            echo "Erreur lors de l'insertion de la participation";
        } else {
            echo "Insertion réussie";
            $_POST = array();
        }
    }
}







include "src/html/insertion_parti_equipe.phtml";

