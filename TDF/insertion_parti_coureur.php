<?php

include "src/html/header.phtml";
include "src/php/util/info_conn.php";
include "src/php/util/fonction_verif.php";
include "src/php/util/fonction_parti.php";
include "src/php/util/remplissage_form.php";
include "src/php/util/fonction.php";

echo "<pre>";
print_r($_POST);
print_r($_GET);
echo "</pre>";

$erreurAnnee = [];
$erreurCoureur = [];
$erreurEquipe = [];
$erreurDossard = [];
$n_dossard = 0;
$erreur = false;
$premier = false;

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
echo $anneeCorrecte;

if (isset($_POST['subButton']) && $anneeCorrecte) {
    echo "verif";

    //vérification du N_COUREUR
    if (!empty($_POST['N_COUREUR'])) {
        $n_coureur = $_POST['N_COUREUR'];
        verifCoureur($n_coureur, $annee, $erreurCoureur, $conn);
    } else {
        $erreurCoureur[] = "Veuillez indiquer un coureur";
    }

    //vérification de l'équipe
    if (!empty($_POST['EQUIPE'])) {
        $equipe = explode("~", $_POST['EQUIPE']);
        $n_equipe = $equipe[0];
        $n_sponsor = $equipe[1];
        echo "n_sponsor = $n_sponsor, n_equipe = $n_equipe";

        if (isset($annee)) {
            if (!verifEquipeParticipante($n_equipe, $n_sponsor, $annee, $conn)) {
                $erreurEquipe[] = "Cette équipe n'est pas inscrite pour l'édition $annee";
            } else {
                if (($nbCoureurs = nbCoureurEquipe($n_equipe, $n_sponsor, $annee, $conn)) >= 8) {
                    $erreurEquipe[] = "Cette équipe est déjà complète pour l'édition $annee";
                }
                //si le joueur est le premier qui va être inscrit dans l'équipe
                //alors on doit demander à l'utilisateur de renseigner un numéro de dossard
                $premier = $nbCoureurs == 0;
            }
        }
    } else {
        $erreurEquipe[] = "Veuillez choisir une équipe et un sponsor";
    }

    if ($premier) {
        if (!empty($_POST['N_DOSSARD'])) {
            $n_dossard = $_POST['N_DOSSARD'];
            if (!verifNDossardNonExistant($n_dossard, $annee, $conn)) {
                $erreurDossard[] = "Le numéro de dossard est déjà utilisé";
            }
        } else {
            $erreurDossard[] = "Veuillez renseigner un numéro de dossard";
        }
    }

    $erreur = !empty($erreurAnnee) || !empty($erreurCoureur) || !empty($erreurEquipe) || !empty($erreurDossard);

    if (!$erreur) {
        //Si pas d'erreur alors on peut passer à l'insertion
        $req = $conn->prepare("insert into TDF_PARTI_COUREUR(ANNEE, N_COUREUR, N_EQUIPE, N_SPONSOR, N_DOSSARD, JEUNE, COMPTE_ORACLE, DATE_INSERT, VALIDE)
                                            values (:annee, 
                                            :n_coureur, 
                                            :n_equipe, 
                                            :n_sponsor, 
                                            nvl((select min(N_DOSSARD)+1 as min from TDF_PARTI_COUREUR
                                            where N_EQUIPE = :n_equipe
                                            and N_SPONSOR = :n_sponsor
                                            and ANNEE = :annee), :n_dossard),
                                            (select 'o' as JEUNE from TDF_COUREUR
                                            where :annee - ANNEE_NAISSANCE <= 25
                                            and N_COUREUR  = :n_coureur) , 
                                            'PPHP2A_05', 
                                            sysdate, 
                                            'O')");
        $req->bindParam(':annee', $annee);
        $req->bindParam(':n_coureur', $n_coureur);
        $req->bindParam(':n_equipe', $n_equipe);
        $req->bindParam(':n_sponsor', $n_sponsor);
        $req->bindParam(':n_dossard', $n_dossard);
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

include "src/html/insertion_parti_coureur.phtml";

