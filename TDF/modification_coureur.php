<?php

include_once "src/php/util/fonction.php";
include_once "src/php/util/fonction_verif.php";


$_POST['n_coureur'] = $n_coureur;

$rescoureur = getRescoureur($conn, $n_coureur);
$resparticoureur = getResparticoureur($conn, $n_coureur, $rescoureur);

$nom = $rescoureur["NOM"];
$prenom = $rescoureur["PRENOM"];
$naissance = $rescoureur["ANNEE_NAISSANCE"];
$age = $rescoureur['AGE'];



$tab = getCoureur($conn, $_POST['n_coureur']);

$erreur = false;
$compte = "pphp2a05";
$erreurNom = array();
$erreurPrenom = array();
$erreurAnnee_naiss= array();
$erreurAnnee_prem= array();
$erreurDoublon= array();

if (isset($_POST['n_coureur'])) {

    if ($rescoureur['NOM'] != $_POST['modifNom']) {
        if (!empty($_POST['modifNom'])) {
            $_POST['modifNom'] = beautifyNom($_POST['modifNom']);
            if (!verifNom($_POST['modifNom'], $erreurNom)) {
                $erreurNom = $erreurNom;
                $erreur = true;
            }
        } else {
            $erreurNom = "Le champ Nom est obligatoire";
            $erreur = true;
        }
    }

    if ($rescoureur['PRENOM'] != $_POST['modifPrenom']) {
        if (!empty($_POST['modifPrenom'])) {
            $_POST['modifPrenom'] = beautifyPrenom($_POST['modifPrenom']);

            if (!verifPrenom($_POST['modifPrenom'], $erreurPrenom)) {
                $erreurPrenom = " $erreurPrenom";
                $erreur = true;
            }
        } else {
            $erreurPrenom = "Le champ Prenom est obligatoire";
            $erreur = true;
        }
    }

    if ($rescoureur['NOM'] != $_POST['modifNom'] && $rescoureur['PRENOM'] != $_POST['modifPrenom']) {
        if (existeDuo($conn, $_POST['modifNom'], $_POST['modifPrenom'])) {
            $erreurDoublon = "Un coureur avec ce Nom et ce Prenom existe déjà";
            $erreur = true;
        }
    }

    if ($rescoureur['ANNEE_NAISSANCE'] != $_POST['modifAnneeNaiss']) {
        if (!empty($_POST['modifAnneeNaiss'])) {
            if (!verifAnneeNaissance($_POST['modifAnneeNaiss'], $erreurAnnee_naiss)) {
                $erreurAnnee_naiss = $erreurAnnee_naiss;
//                echo "L\'année de naissance n\'est pas valide.";
                $erreur = true;
            }
        } else {
            $_POST['modifAnneeNaiss'] = "null";
        }
    }

    if ($rescoureur['ANNEE_PREM'] != $_POST['modifAnneePrem']) {
        if (!empty($_POST['modifAnneePrem'])) {
            $erreurAnnee_prem = "L'année de première participation n'est pas valide";
//            echo "L'année de premiere participation n'est pas valide";
            $erreur = true;
        } else {
            $_POST['modifAnneePrem'] = "null";
        }
    }
}
if (!$erreur) {
    $sql = "update tdf_coureur set nom = '".$_POST['modifNom']."' where n_coureur =". $_POST['n_coureur'];
    majDonneesPDO($conn, $sql);

    $sql = "update tdf_coureur set prenom = '".$_POST['modifPrenom']."' where n_coureur =". $_POST['n_coureur'];
    majDonneesPDO($conn, $sql);

    $sql = "update tdf_coureur set annee_naissance = ".$_POST['modifAnneeNaiss']." where n_coureur =". $_POST['n_coureur'];
    majDonneesPDO($conn, $sql);

    $sql = "update tdf_coureur set annee_prem = ".$_POST['modifAnneePrem']." where n_coureur =". $_POST['n_coureur'];
    majDonneesPDO($conn, $sql);

    echo "<script>
                window.location.href = 'coureur.php?n_coureur=$n_coureur';
                alert('Modification prit en compte');
            </script>";

} else {
    include "src/html/modif_coureur.phtml";
}



