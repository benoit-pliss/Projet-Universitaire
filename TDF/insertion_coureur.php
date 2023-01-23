<?php

include "src/html/header.phtml";
include "src/php/util/info_conn.php";
include "src/php/util/remplissage_form.php";
include "src/php/util/fonction_verif.php";

$compte = "pphp2a05";
$erreur = true;
$erreurNom = array();
$erreurPrenom = array();
$erreurAnnee_naiss= array();
$erreurAnnee_prem= array();
$erreurNationalite= array();
$erreurDoublon= "";
$annee_nationalite = "null";

if(isset($_POST["subButton"])){
    $erreur = false;
    if (!empty($_POST["nom"])){
        $nom = $_POST["nom"];
        $nom = beautifyNom($nom);
        if(!verifNom($nom, $erreurNom)){
            $erreur = true;
        }else{
            $_POST["nom"] = $nom;
        }
        $_POST["nomc"] = $nom;
    }
    else{
        $erreur = true;
        $erreurNom[] = "Le nom est vide";
    }

    if (!empty($_POST["prenom"])){
        $prenom = $_POST["prenom"];
        $prenom = beautifyPrenom($prenom);
        if(!verifPrenom($prenom, $erreurPrenom)){
            $erreur = true;
        }
        else {
            $_POST["prenom"] = $prenom;
        }
        $_POST["prenomc"] = $prenom;
    }
    else{
        $erreur = true;
        $erreurPrenom[] = "Le prénom est vide";
    }

    if (!empty($_POST["nationalite"])){
        $nationalite = $_POST["nationalite"];

        if(!verifNationalite($nationalite, $conn)){
            $erreur = true;
            $erreurNationalite[] = "La nationalité n'existe pas";
        }
    }
    else{
        $erreur = true;
        $erreurNationalite[] = "La nationalité est vide";
    }

    if (!empty($_POST["annee_naiss"])){
        $annee_naiss = $_POST["annee_naiss"];
        $annee_naiss = trim($annee_naiss);
        if(!verifAnneeNaissance($annee_naiss, $erreurAnnee_naiss)){
            $erreur = true;
        }
        $annee_nationalite = $annee_naiss;
    }else{
        $annee_naiss = 'null';
    }

    if(!empty($_POST["annee_prem"])){
        $annee_prem = $_POST["annee_prem"];
        $annee_prem = trim($annee_prem);
        if(!verifAnnee($annee_prem)){
            $erreur = true;
            $erreurAnnee_prem[] = "L'année de première participation n'est pas valide";
        }
    }else{
        $annee_prem = 'null';
    }

    if($annee_prem != 'null' && $annee_naiss != 'null'){
        if (count($erreurAnnee_prem) == 0 && count($erreurAnnee_naiss) == 0){
            if(!($annee_prem >= ($annee_naiss+20))){
                $erreur = true;
                $erreurAnnee_prem[] = "Un coureur ne peut participer au tour de france avant ses 20 ans";

            }
        }

    }
    if(empty($erreurNom) && empty($erreurPrenom)){
        if (doublon($nom, $prenom, $conn)) {
            $erreur = true;
            $erreurDoublon = "Un coureur avec ce nom et ce prénom existe déjà";
        }
    }

    if ($erreur){
        include('src/html/insertion_coureur.phtml');
    }
    else if ($_POST['subButton'] == "Envoyer" ){
        include('src/html/insertion_coureur.phtml');
    }
    else {
        $reqAjoutTDF_Coureur = $conn->prepare(
            "INSERT INTO TDF_COUREUR (N_COUREUR, NOM, PRENOM, ANNEE_NAISSANCE, ANNEE_PREM, COMPTE_ORACLE, DATE_INSERT)
                VALUES (inc_n_coureur.nextval, :nom, :prenom, ". $annee_naiss .",". $annee_prem . ", :compte, sysdate)
                RETURNING N_COUREUR INTO :p_n_coureur"
        );
        $reqAjoutTDF_Coureur->bindParam(':nom', $nom);
        $reqAjoutTDF_Coureur->bindParam(':prenom', $prenom);
        $reqAjoutTDF_Coureur->bindParam(':compte', $compte);
        $p_n_coureur = 5000;
        $reqAjoutTDF_Coureur->bindParam(':p_n_coureur', $p_n_coureur, PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT, 4000);
        if (!$reqAjoutTDF_Coureur->execute()){
            echo "Erreur lors de l'insertion du coureur";
            echo "<pre>";
            print_r($conn->errorInfo());
            echo "</pre>";
        }

        $reqAjoutTDF_APP_NATION = $conn->prepare(
            "INSERT INTO TDF_APP_NATION (N_COUREUR, CODE_CIO, ANNEE_DEBUT, COMPTE_ORACLE, DATE_INSERT) 
                VALUES (:p_n_coureur, :nationalite, ". $annee_nationalite .", :compte, sysdate)");
        $reqAjoutTDF_APP_NATION->bindParam(':p_n_coureur', $p_n_coureur);
        $reqAjoutTDF_APP_NATION->bindParam(':nationalite', $nationalite);
//    $reqAjoutTDF_APP_NATION->bindParam(':annee_debut', $annee_debut); // impossible à utiliser car prend parfois la valeur 'null' et voit ça comme un string
        $reqAjoutTDF_APP_NATION->bindParam(':compte', $compte);
        echo $reqAjoutTDF_APP_NATION->queryString . "<br>";
        if (!$reqAjoutTDF_APP_NATION->execute()){
            echo "Erreur lors de l'insertion de la nationalité";
            echo "<pre>";
            print_r($conn->errorInfo());
            echo "</pre>";

        }
        $_POST = array();
        $erreur = true;

        echo "<script>
                window.location.href = 'coureur.php';
                alert('Coureur ajouté');
            </script>";
    }
}
else{
include('src/html/insertion_coureur.phtml');
}