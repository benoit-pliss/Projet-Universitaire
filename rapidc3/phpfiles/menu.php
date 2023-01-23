<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Menu</title>
    <link href="../style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../images/thumbnail.jpg">
    <script type="text/javascript"></script>
    <script> 
        function changeColorPlat() {
            for(let i = 0; i<13; i++) {
                if (m.pla[i].checked == true) {
                    radioCheck('plat'+i);
                } else {
                    radioDisable('plat'+i);
                }
            }
        }

        function changeColorLegume() {
            for(let i = 0; i<13; i++) {
                if (m.leg[i].checked == true) {
                    radioCheck('legume'+i);
                } else {
                    radioDisable('legume'+i);
                }
            }
        }

        function changeColorBoisson() {
            for(let i = 0; i<6; i++) {
                if (m.boi[i].checked == true) {
                    radioCheck('boisson'+i);
                } else {
                    radioDisable('boisson'+i);
                }
            }
        }

        function changeColorDessert() {
            for(let i = 0; i<6; i++) {
                if (m.des[i].checked == true) {
                    radioCheck('dessert'+i);
                } else {
                    radioDisable('dessert'+i);
                }
            }
        }

        function radioCheck(identifiant) {
            document.getElementById(identifiant).style.backgroundColor = '#15C22C';
            document.getElementById(identifiant).style.borderColor = '#ADD8E6';
            document.getElementById(identifiant).style.borderWidth = "3px"
        }

        function radioDisable(identifiant) {
            document.getElementById(identifiant).style.backgroundColor = 'white';
            document.getElementById(identifiant).style.borderColor = 'black';
            document.getElementById(identifiant).style.borderWidth = "1px"
        }
        </script>
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
                <li><a href="../modelcarte.html">Notre carte</a></li>
                <li><a href="../apropos">A propos de nous</a></li>
            </ul>
        </nav>
        <a class="commander" href="panier.php">Panier</a>
        <a class="commander" href="../Form/index.php">Connexion</a>
    </div>
</header>




<form action="menuTrait.php" method="post" name="m">
    <div class="plats">

        <h1 class = "titremenu">PLATS</h1>

        <?php

        include_once "../Connexionfiles/connexion_oracle.php";



        $sql = "select pla_lien_img as img, substr(pla_num,1,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
join rap_kebab using(pla_num)";
    $nbligne = LireDonneesPDO2($conn, $sql, $donnee);


        for ($i = 0; $i < $nbligne; $i++) {
            ?>
            <input id="<?php echo $donnee[$i]['PLA_NOM']; ?>" name="pla" type="radio" class="platitems" value="<?php echo $donnee[$i]['PLA_NUM']; ?> " onClick="changeColorPlat()"/>
            <label for="<?php echo $donnee[$i]['PLA_NOM']; ?>">
            <div class="item" id="<?php echo 'plat'.$i; ?>">
                <h3 id="plat"><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
                <img src="<?php echo $donnee[$i]['IMG']; ?>" alt="" />
                

                <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
            </div>
            </label>
            <?php
        }
        ?>

        <?php

        $sql = "select pla_lien_img as img,substr(pla_num,1,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
join rap_pizza using(pla_num)";
    $nbligne2 = LireDonneesPDO2($conn, $sql, $donnee);


        for ($i = $nbligne; $i < $nbligne2+$nbligne; $i++) {
            ?>
            <input id="<?php echo $donnee[$i-$nbligne]['PLA_NOM']; ?>" name="pla" type="radio" class="platitems" value="<?php echo $donnee[$i-$nbligne]['PLA_NUM']; ?>" onClick="changeColorPlat()"/>
            <label for="<?php echo $donnee[$i-$nbligne]['PLA_NOM']; ?>">
                <div class="item" id="<?php echo 'plat'.$i; ?>">
                    <h3 name="plat"><?php echo $donnee[$i-$nbligne]['PLA_NOM']; ?></h3>
                    <img src="<?php echo $donnee[$i-$nbligne]['IMG']; ?>" alt="" />
                    

                    <h3><?php echo $donnee[$i-$nbligne]['PRIX']; ?></h3>
                    
                </div>
                </label>
            <?php
        }
        ?>
    </div>

    <hr>

    <div class="acompagnement">
        <h1 class = "titremenu">LEGUMES</h1>

        <?php

        include_once "../Connexionfiles/connexion_oracle.php";



        $sql = "select pla_lien_img as img, substr(pla_num,1,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
join rap_legume using(pla_num)";
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);


        for ($i = 0; $i < $nbligne; $i++) {
            $nom =  $donnee[$i]['PLA_NOM'];
            ?>
            <input id="<?php echo $donnee[$i]['PLA_NOM']; ?>" name="leg" type="radio" class="legumeitems" value="<?php echo $donnee[$i]['PLA_NUM']; ?>" onClick="changeColorLegume()"/>
            <label for="<?php echo $donnee[$i]['PLA_NOM']; ?>">
            <div class='item' id="<?php echo 'legume'.$i; ?>">
                <h3 name="legume"><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
                <img src="<?php echo $donnee[$i]['IMG']; ?>" alt="" />
                

                <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
                
            </div>
            </label>
            <?php
        }
        ?>

    </div>

    <hr>

    <div class="boissons">
        <h1 class = "titremenu">BOISSONS</h1>
        <?php

        include_once "../Connexionfiles/connexion_oracle.php";



        $sql = "select pla_lien_img as img, substr(pla_num,1,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
join rap_boisson using(pla_num)";
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);


        for ($i = 0; $i < $nbligne; $i++) {
            ?>
            <input id="<?php echo $donnee[$i]['PLA_NOM']; ?>" name="boi" type="radio" class="boissonitems" value="<?php echo $donnee[$i]['PLA_NUM']; ?>" onClick="changeColorBoisson()"/>
            <label for="<?php echo $donnee[$i]['PLA_NOM']; ?>">
            <div class='item' id="<?php echo 'boisson'.$i; ?>">
                <h3 class="boisson"><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
                <img src="<?php echo $donnee[$i]['IMG']; ?>" alt="" />
                

                <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
                

            </div>
            </label>
            <?php
        }
        ?>
    </div>

    <hr>

    <div class="dessert">
        <h1 class = "titremenu">DESSERTS</h1>

        <?php

        include_once "../Connexionfiles/connexion_oracle.php";



        $sql = "select pla_lien_img as img,substr(pla_num,1) as pla_num, pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
where pla_num in (
    select pla_num from rap_dessert
)";
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);


        for ($i = 0; $i < $nbligne; $i++) {
            ?>
            <input name="des" id="<?php echo $donnee[$i]['PLA_NOM']; ?>" type="radio" class="dessertitems" value="<?php echo $donnee[$i]['PLA_NUM']; ?>" onClick="changeColorDessert()"/>
            <label for="<?php echo $donnee[$i]['PLA_NOM']; ?>">
            <div class='item' id="<?php echo 'dessert'.$i; ?>">
                <h3 class="dessert"><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
                <img src="<?php echo $donnee[$i]['IMG']; ?>" alt="" />
                

                <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
       
            </div>
            </label>
            <?php
        }
        ?>
    </div>

    <button type="submit" id="ajouterMenu">Ajouter à la commande</button>

</form>

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