

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Panier</title>
    <link href="../style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../images/thumbnail.png">
</head>

<body>
    <header>
        <div class="image">
            <a href="../index.html" title="Retour à l'accueil">
                <img src="../images/logo.PNG" alt="logo" class="logo">
            </a>
        </div>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="../modelcarte.html">Notre carte</a></li>
                    <li><a href="../apropos.html">A propos de nous</a></li>
                </ul>
            </nav>
            <a class="commander" id="actif" href="#">Panier</a>
            <a class="commander" href="../Form/index.php">Connexion</a>
        </div>
    </header>
    <?php
    session_start();
    include_once "../Connexionfiles/connexion_oracle.php";
    include_once "../Panier/panierFonc.php";

    creerPanier();
?>
<!-- Début de la zone des commandes -->
<div>
    <div>
            <h1 class="panierbody">Récapitulatif de votre commande</h1>
        <hr>
    </div>
<?php

if (isset($_SESSION['panier'])){
    $nbligne = count($_SESSION['panier']['code']);

    for ($i = 0; $i < $nbligne ; $i++){
        //echo $_SESSION['panier']['code'][$i];
        $code = $_SESSION['panier']['code'][$i];
        $prix = $_SESSION['panier']['prix'][$i];
        $qte = $_SESSION['panier']['qte'][$i];
        //$modif = $_SESSION['panier']['modif'][$i];

        //echo $code;


        $sql = "select pla_nom , pla_lien_img as img from rap_plat
        where pla_num = '$code'";

        LireDonneesPDO2($conn, $sql, $donnee);

?>
        <table class="tableau">
    <tr>
        <td> <img src=" <?php echo $donnee[0]['IMG']; ?> " class="icone"> </td>
        <td> <h3> <?php  echo $donnee[0]['PLA_NOM']; ?> </h3> </td>
        <td>
            <form action="panierTrait.php" method="post">
                <button class="quantite" type="submit" name="moins" value="<?php  echo $code; ?>"> - </button>
            </form>
        </td>
        <td> <h2> Quantité : <?php echo $qte ?> </h2> </td>
        <td>
            <form action="panierTrait.php" method="post">
                <button type="submit" name="plus" value="<?php  echo $code; ?>"> + </button>
            </form>
        </td>
        <td> <h3> Prix unitaire : <?php  echo $prix ?> </h3> </td>
        <td>
            <form action="panierTrait.php" method="post">
                <button type="submit" name="supr" value="<?php  echo $code; ?>" > <img src="../images/delete.png" class="icone">  </button>
            </form>
        </td>


    </tr>
    </table >
<?php
    }
}
else{
    if (count($_SESSION['panier']['code']) == null){


    ?>
    <br>
    <table class="tableau">

        <h1>Votre panier est vide !</h1>
    </table>
    <br>

    <?php
}
}

//if (isset(_SESSION['panier']) && count($_SESSION['panier']['code']) == 0){
//    ?>
<!--    <br>-->
<!--    <table class="tableau">-->
<!---->
<!--        <h1>Votre panier est vide !</h1>-->
<!--    </table>-->
<!--    <br>-->
<!---->
<!--    --><?php
//}

?>

</div>
 <!-- Fin de la zone des commandes -->
 <hr>
 <!-- Début de la zone du total -->

 <div class="totalcommande">
    <h1>Prix total de la commande : <?php echo number_format(somme(),2) . " €";  ?></h1>
     <form action="panierTrait.php" method="post">
         <button type="submit" name="comm" value="<?php echo $_SESSION['panier'] ?>">
             Passer la commande
         </button>

     </form>
</div>
   
</body>

</html>