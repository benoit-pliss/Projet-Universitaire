<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Accueil</title>
    <link href="../style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../images/thumbnail.png">
</head>

<body>
<header>
    <div class="image">
        <a href="../index.html">
            <img src="../images/logo.PNG" alt="logo" class="logo">
        </a>
    </div>
    <div class="container">
        <nav>
            <ul>
                <li><a href="../modelcarte.html" id="actif">Notre carte</a></li>
                <li><a href="../apropos">A propos de nous</a></li>
            </ul>
        </nav>
        <a class="commander" href="panier.php">Panier</a>
        <a class="commander" href="../Form/index.php">Connexion</a>
        
    </div>
</header>


<div class="topvente">
    <h1>Nos Meilleures Ventes</h1>

    <?php

    include_once "../Connexionfiles/connexion_oracle.php";
    include_once "../Panier/panierFonc.php";



    $sql = "select pla_lien_img as img,substr(pla_num,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
join rap_pizza using(pla_num)";
    $nbligne = LireDonneesPDO2($conn, $sql, $donnee);


    for ($i = 0; $i < $nbligne; $i++) {
        ?>
            <div class='item'>
                <h3><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
                <img src='<?php echo $donnee[$i]['IMG']; ?>'>

                <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
                <form method="post" action="itemsTrait.php">
                    <!--                    <input type="submit" name="envoyer" value="envoyer" onclick="--><?php //ajouterArticle() ?><!--">-->

                    <button name="keb" value="<?php echo $donnee[$i]['PLA_NUM']; ?>" type="submit" class="bouton">Ajouter au panier</button>
                    <input name="num" id="number" type="number" value="1" min="1" max="50" class="qtyselec">
                </form>
            </div>
        <?php
    }
    ?>
</div>
    <footer>
        <p>Pour votre santé mangez 5 kebabs et pizzas par jour. mangerbouger.fr</p>
        <ul>
            <li>Notre Facebook : <a href="https://www.facebook.com/">RapidC3Officiel</a></li>
            <li>Notre Twitter : <a href="https://twitter.com/">RapidC3Officiel</a></li>
            <li>Notre Instagram : <a href="https://www.instagram.com/">RapidC3Officiel</a></li>
        </ul>
        <p><br>Tout droits réservés Copyright 2022 CHERUEL BELLAN LEROUX PLISSONNIER LANGLOIS SEVAUX BRIZE</p>
    </footer>
</body>
    
</html>