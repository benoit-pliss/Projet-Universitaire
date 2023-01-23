<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>RapidC3 | Inscription</title>
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
            <a class="commander" href="../panier.html">Panier</a>
            <a class="commander" href="index.php">Connexion</a>
        </div>
    </header>
    
    <?php
    if(isset($_GET['reg_err']))
    {
        $err = htmlspecialchars($_GET['reg_err']);

        switch($err)
        {
            case 'success':
                ?>
                <div class="alert alert-success">
                    <strong>Succès</strong> Inscription réussie !
                </div>
                <?php
                break;

            case 'password':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Mot de passe différent
                </div>
                <?php
                break;

            case 'email':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Email non valide
                </div>
                <?php
                break;

            case 'courriel_length':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Email trop long
                </div>
                <?php
                break;

            case 'nom_length':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Nom trop long
                </div>
            <?php
            case 'already':
                ?>
                <div class="alert alert-danger">
                    <strong>Erreur</strong> Compte déjà existant
                </div>
            <?php

        }
    }
    ?>
    <form action="traitement_form.php" method="post" class="signUp">
        <table id = "table">
            <thead>
                <tr>
                    <th colspan="2"><h1>Inscription</h1></th>
                </tr>
            </thead>
            <tr>
                <td><label class = "donSignUp">Nom : </label></td>
                <td><input type="text" name="nom", id="nom" required></td>
                <br/>
            </tr>
            <tr>
                <td><label class = "donSignUp">Prénom : </label></td>
                <td><input type="text" name="prenom" id="prenom" required></td>
                <br>
            </tr>
            <tr>
                <td><label class = "donSignUp">Adresse Mail :</label></td>
                <td><input type="text" name="courriel" id="courriel"><td>
                <br>
            </tr>
            <tr>
                <td><label class = "donSignUp">Mot de Passe : </label></td>
                <td><input type="password" name="mdp" id="mdp"></td>
            </tr>
        </table>
        
        <br>

        <button type="submit" class="btn btn-primary btn-block">Inscription</button>
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