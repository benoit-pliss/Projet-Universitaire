<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Connexion</title>
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
                    <li><a href="../apropos">A propos de nous</a></li>
                </ul>
            </nav>
            <a class="commander" href="../phpfiles/panier.php">Panier</a>
            <a class="commander" href="#" id="actif">Connexion</a>
        </div>
    </header>

<div class = "topvente">
    <?php
session_start();

include_once "../Connexionfiles/connexion_oracle.php";
$conn = OuvrirConnexionPDO($db,$db_username,$db_password);
?>
        <?php
    if(isset($_GET['login_err']))
    {
        $err = htmlspecialchars($_GET['login_err']);

        switch($err)
        {
            case 'password':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> mot de passe incorrect
                </div>
                <?php
                break;

            case 'email':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> email incorrect
                </div>
                <?php
                break;

            case 'already':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> compte non existant
                </div>
                <?php
                break;
        }
    }

    if (!(isset($_SESSION['nomUser']))){


    ?>
            <h1>Vous n'êtes pas connecté</h1>
        <form action="connexion.php" method="post">

            <h2 class="text-center">Connexion</h2>
            <div class="form-group">
                <input type="email" name="courriel" class="form-control" placeholder="Email" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Connexion</button>
            </div>
        </form>

        <p class="text-center">Vous n'avez pas de compte ?<a href="inscription.php"><br> Inscrivez vous</a></p>

    <?php


    }else{
        // On récupere les données de l'utilisateur
        $sql = 'select * from rap_client';
        $donnee = array();
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

        $row = 0;

        for ($i = 0; $i < $nbligne; $i++){
            if ($donnee[$i]['CLI_NOM'] == $_SESSION['nomUser'] && $donnee[$i]['CLI_PRENOM'] == $_SESSION['prenomUser']){
                $row = $i;
            }
        }

        ?>
    <div class="text-center">
        <h1 class="p-5">Vous êtes connecté sous le Compte : <?php echo $donnee[$row]['CLI_PRENOM']; ?> !</h1>

        <a href="deconnexion.php" class="btn btn-danger btn-lg">Déconnexion</a>
    </div>
    <?php


    if (($_SESSION['nomUser'] == "admin" && $_SESSION['prenomUser'] == "admin")){
        ?>
    <h2>Liste des clients inscrits</h2>
    <table>
        <tr>
            <td><h2>CLI_NUM</h2></td>
            <td><h2>CLI_NOM</h2></td>
            <td><h2>CLI_PRENOM</h2></td>
            <td><h2>CLI_COURRIEL</h2></td>
            <td><h2>COMMANDE(S)</h2></td>
        </tr>
        <?php
            $sql = "select * from rap_client order by cli_num desc";
            $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

            for ($i = 0; $i < $nbligne; $i++){
                ?>
        <tr>
            <td><p><?php echo $donnee[$i]['CLI_NUM'] ?></p></td>
            <td><p><?php echo $donnee[$i]['CLI_NOM'] ?></p></td>
            <td><p><?php echo $donnee[$i]['CLI_PRENOM'] ?></p></td>
            <td><p><?php echo $donnee[$i]['CLI_COURRIEL'] ?></p></td>
            <td>
                <form class="nostyle" action="index.php" method="post">
                    <button type="submit" name="commande" value="<?php echo $donnee[$i]['CLI_NUM'] ?>">Voir les Commandes</button>
                </form>
                <form action="supprClien.php" method="post">
                    <button type="submit" name="suppr" value="<?php echo $donnee[$i]['CLI_NUM'] ?>">Supprimer Client</button>
                </form>
            </td>
        </tr>

                <?php
            }
        }
    ?>
    </table>
    <?php

        if (isset($_POST['commande'])){
            ?>
        <table>
            <tr>
                <th><p>COM_NUM</p></th>
                <th><p>COM_DATE</p></th>
                <th><p>COM_HEURE_RECUP</p></th>
                <th><p>COM_PRIX_TOTAL</p></th>
                <th
            </tr>
        <?php
        $val = $_POST['commande'];
        $sql = "select * from rap_commande where cli_num = '$val'";
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

        for ($i = 0; $i < $nbligne; $i++){
            ?>
            <tr>
                <td><p<<?php echo $donnee[$i]['CLI_NUM'] ?></p></td>
                <td><p><?php echo $donnee[$i]['COM_NUM'] ?></p></td>
                <td><p><?php echo $donnee[$i]['COM_DATE'] ?></p></td>
                <td><p><?php echo $donnee[$i]['COM_HEURE_RECUP'] ?></p></td>
                <td><p><?php echo $donnee[$i]['COM_PRIX_TOTAL'] ?></p></td>
            </tr>
            <?php
        }
        }
        }
        ?>
    </table>

</div>


<style>
    .nostyle{
        border: 0px;
    }

</style>
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