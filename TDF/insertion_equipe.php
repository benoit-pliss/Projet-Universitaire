<?php

include "src/php/util/info_conn.php";
include "src/php/util/remplissage_form.php";
include "src/php/util/fonction_verif.php";
include "src/php/util/fonction.php";
include "src/html/header.phtml";

$erreur = false;
$erreurEquipe = array();
$erreurSponsor = array();

echo "<pre>";
print_r($_POST);
echo "</pre>";

if (isset($_POST['subButton'])) {
    //vérification s'il s'agit d'une nouvelle équipe ou d'une équipe existante
    if (isset($_POST['new_equipe'])) {
        //vérification de l'année de création
        if (isset($_POST['creation'])) {
            $annee_creation = $_POST['annee_creation'];
            if (!verifAnnee($annee_creation)) {
                $erreurEquipe[] = "L'année de création doit être un nombre";
            }
        } else {
            $erreurEquipe[] = "Veuillez entrée une année de création pour la nouvelle équipe";
        }

        //vérification de l'année de disparition
        if (isset($_POST['disparition'])) {
            $annee_disparition = $_POST['annee_disparition'];
            if (!verifAnnee($annee_disparition)) {
                $erreurEquipe[] = "L'année de disparition doit être un nombre";
            }
        }
    } elseif (!empty($_POST['ancienne_equipe'])) {
        $n_equipe = $_POST['ancienne_equipe'];
    } else {
        $erreurEquipe[] = "Veuillez choisir une ancienne équipe ou en créer une nouvelle";
    }

    //vérification pour le sponsor
    if (!empty($_POST['nom_sponsor'])) {
        $nom_sponsor = $_POST['nom_sponsor'];
        $nom_sponsor = mb_strtoupper($nom_sponsor, 'UTF-8');
        verifNomSponsor($nom_sponsor, $erreurSponsor);


        $_POST['nom_sponsor'] = $nom_sponsor;
    } else {
        $erreurSponsor[] = "Veuillez entrer un nom de sponsor";
    }

    //vérification pour le nom abrégé
    if (!empty($_POST['nom_code_spo'])) {
        $nom_abrege = $_POST['nom_code_spo'];
        $nom_abrege = mb_strtoupper($nom_abrege, 'UTF-8');

        verifNomAbregeSponsor($nom_abrege, $erreurSponsor);

    } else {
        $erreurSponsor[] = "Veuillez entrer un nom abrégé";
    }

    //vérification pour le pays du sponsor
    if (!empty($_POST['cio_sponsor'])) {
        $pays_sponsor = $_POST['cio_sponsor'];
    } else {
        $erreurSponsor[] = "Veuillez sélectionner un pays pour le sponsor";
    }

    if (!empty($_POST['annee_sponsor'])){
        $annee_sponsor = $_POST['annee_sponsor'];
        if (!verifAnnee($annee_sponsor)){
            $erreurSponsor[] = "L'année doit être un nombre";
        }
    }else{
        $annee = date("Y");
    }

    //Si pas d'erreur sur les champs du sponsor, on peut vérifier s'il n'en existe pas déjà un avec les mêmes infos.
    if (empty($erreurSponsor)) {
        $req = $conn->prepare("select *
                                        from TDF_SPONSOR TS
                                        where ANNEE_SPONSOR =
                                              (select max(ANNEE_SPONSOR)
                                               from TDF_SPONSOR TS2
                                               where TS2.N_EQUIPE = TS.N_EQUIPE)
                                        and NOM = :nom
                                        and CODE_CIO = :code_cio
                                        and NA_SPONSOR = :na_sponsor");
        $req->bindParam(':nom', $nom_sponsor);
        $req->bindParam(':code_cio', $pays_sponsor);
        $req->bindParam(':na_sponsor', $nom_abrege);
        $req->execute();
        $res = array();
        $res = $req->fetch(PDO::FETCH_ASSOC);

        if (!empty($res)) {
            $erreurSponsor[] = "Un sponsor avec les mêmes informations existe déjà";
        }
    }

    $erreur = !empty($erreurEquipe) || !empty($erreurSponsor);


    //si il n'y a pas d'erreur et que le bouton confirmer a été cliqué, on peut insérer les données
    if (!$erreur && $_POST['subButton'] == "Confirmer") {

        //Insertion des données dans la base de données
        //on utilise une transaction pour pouvoir rollback en cas d'erreur sur une insertion
        $conn->beginTransaction();
        try {
            //insertion de l'équipe si une nouvelle est créee
            if (isset($_POST['new_equipe'])) {
                $req = $conn->prepare("insert into TDF_EQUIPE (N_EQUIPE, ANNEE_CREATION, ANNEE_DISPARITION)
                                       values (SEQ_TDF_EQUIPE.nextval, :annee_creation, :annee_disparition)
                                       return N_EQUIPE into :n_equipe");
                $req->bindParam(':annee_creation', $annee_creation);
                $req->bindParam(':annee_disparition', $annee_disparition);
                $n_equipe = 0;
                $req->bindParam(':n_equipe', $n_equipe, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
                $req->execute();
                if ($n_equipe == 0) {
                    throw new Exception("Erreur lors de l'insertion de l'équipe");
                }
            }

            //insertion du sponsor
            $req = $conn->prepare("insert into TDF_SPONSOR (N_EQUIPE, N_SPONSOR, ANNEE_SPONSOR, NOM, CODE_CIO, NA_SPONSOR, COMPTE_ORACLE, DATE_INSERT)
                                        values (:n_equipe, (select nvl(max(N_SPONSOR),1) from TDF_SPONSOR), :annee, :nom, :code_cio, :na_sponsor, :compte_oracle, sysdate)");
            $req->bindParam(':n_equipe', $n_equipe);
            $req->bindParam(':annee', $annee_sponsor);
            $req->bindParam(':nom', $nom_sponsor);
            $req->bindParam(':code_cio', $pays_sponsor);
            $req->bindParam(':na_sponsor', $nom_abrege);
            $req->bindParam(':compte_oracle', $infoConn['login']);

        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
        }
        $conn->commit();

        echo "Insertion réussie";
        $_POST = array();

    }

}


include "src/html/insertion_equipe.phtml";

