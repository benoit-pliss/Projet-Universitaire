<?php
session_start();
include_once "../Connexionfiles/connexion_oracle.php";
include_once "../Panier/panierFonc.php";
$conn = OuvrirConnexionPDO($db,$db_username,$db_password);

    if (isset($_POST['supr'])){

        $nb_ligne = count($_SESSION['panier']['code']);

        for ($i = 0; $i < $nb_ligne; $i++){
            if ($_SESSION['panier']['code'] == $_POST['supr']){
                $qte = $_SESSION['panier']['qte'][$i];
            }
        }
        supprimerArticle($_POST['supr'], $qte);
        header('Location:panier.php');
        die();
    }

    if (isset($_POST['plus'])){
        ajouterQte($_POST['plus']);
        header('Location:panier.php');
        die();
    }

    if (isset($_POST['moins'])){
        enleveQte($_POST['moins']);
        header('Location:panier.php');
        die();
    }


    if (isset($_POST['comm'])) {
        if (isset($_SESSION['panier'])) {
            $nb_ligne = count($_SESSION['panier']['code']);


            echo $_SESSION['nomUser'];
            if (isset($_SESSION['nomUser'])) {
                $num = (int)$_SESSION['numUser'];
                echo $num;

                $sql = "insert into rap_commande(com_num, cli_num, com_date) values((
    select max(com_num) from rap_commande) + 1, $num , sysdate)";
            } else {
                $sql = "insert into rap_commande(com_num, cli_num, com_date) values((
    select max(com_num) from rap_commande) + 1, 0 , sysdate)";
            }

            majDonneesPDO($conn, $sql);


            for ($i = 0; $i < $nb_ligne; $i++) {
                $num = (int)$_SESSION['panier']['code'][$i];
                $sql = "insert into rap_appartenir values((select max(com_num) from rap_commande), $num , <quantite>)";

                majDonneesPDO($conn, $sql);
            }

            $sql = "update rap_commande

set com_prix_total = (
    select sum(pla_prix_vente_unit_ht * (pla_tva/100+1) * app_quantite) from rap_plat join rap_appartenir
    using(pla_num) where com_num in (select max(com_num) from rap_commande)
),
com_duree_totale_prepa = (
    select sum(pla_duree_preparation * app_quantite) from rap_plat join rap_appartenir using(pla_num)
    where com_num in (select max(com_num) from rap_commande)
)
where com_num in (
    select max(com_num) as num from rap_commande
)";
            majDonneesPDO($conn, $sql);

            supprimePanier();

            header('Location: panier.php');
            die();


        } else {
            header('Location: panier.php');
            die();
        }
    }

?>
