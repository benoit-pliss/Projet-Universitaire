<?php
    session_start();
    include_once "../Connexionfiles/connexion_oracle.php";
    include_once "../Panier/panierFonc.php";
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);

    if (isset($_POST['pla']) && isset($_POST['leg']) && isset($_POST['boi']) && isset($_POST['des'])) {




        $numboi = $_POST['boi'];
        $numpla = $_POST['pla'];
        $numleg = $_POST['leg'];
        $numdes = $_POST['des'];

        $numpla = (int)$numpla;
        $planum =$numpla.$numleg.$numboi.$numdes;

        creerPanier();

        //echo $planum;


        $sql = "select pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
                where pla_num = '$planum'";
        $donnee = array();
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

        if (count($donnee) != 0){
            $prix = $donnee[0]['PRIX'];
            ajouterArticle($planum, $prix, 1);

            header('Location:itemsTrait.php');
            die();
        }else{ header('Location: menu.php'); die(); }










        


    }else{ header('Location: ../Form/index.php'); die();} // si le formulaire est envoyé sans aucune données



?>
