

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Confirmation</title>
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
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);


    if (isset($_POST['keb']) && isset($_POST['num'])){
        $planum = $_POST['keb'];
        $sql = "select pla_nom,(trim(to_char(round(pla_prix_vente_unit_ht*(pla_tva/100+1),2),'999990D00')) || ' €') as prix from rap_plat
        where pla_num = '$planum'";
        $donnee = array();
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);
        $prix = $donnee[0]['PRIX'];

        ajouterArticle($_POST['keb'], $prix, $_POST['num']);
    }
?>
        <h1 class = "conf">Le produit a bien été ajouté à votre panier !</h1>
        <div class="continuers">
        <a class = "continuer" href="../modelcarte.html">Continuer mes achats</a>
        <a class = "continuer" href="panier.php">Aller au panier</a>
</div>
</body>
<footer>
        <p>Pour votre santé mangez 5 kebabs et pizzas par jour. mangerbouger.fr</p>
        <ul>
            <li>Notre Facebook : <a href="https://www.facebook.com/">RapidC3Officiel</a></li>
            <li>Notre Twitter : <a href="https://twitter.com/">RapidC3Officiel</a></li>
            <li>Notre Instagram : <a href="https://www.instagram.com/">RapidC3Officiel</a></li>
        </ul>
        <p><br>Tout droits réservés Copyright 2022 CHERUEL BELLAN LEROUX PLISSONNIER LANGLOIS SEVAUX BRIZE</p>
    </footer>
</html>