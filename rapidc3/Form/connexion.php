<?php
    session_start();
    include_once "../Connexionfiles/connexion_oracle.php";
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);


        if (isset($_POST['courriel']) && isset($_POST['mdp']))
        {
            $courriel = htmlspecialchars($_POST['courriel']);
            $mdp = htmlspecialchars($_POST['mdp']);

            // On vérifie si l'utilisateur existe
            $sql = 'select * from rap_client';
            $donnee = array();
            $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

            $row = 0;

            for ($i = 0; $i < $nbligne; $i++){
                if ($donnee[$i]['CLI_COURRIEL'] == $courriel && $donnee[$i]['CLI_PASSWORD'] == $mdp){
                    $row = $i;
                }
            }
            if ($row > 0){
                if ($donnee[$row]['CLI_COURRIEL'] == $courriel){

                    if ($donnee[$row]['CLI_PASSWORD'] == $mdp){

                        $_SESSION['nomUser'] = $donnee[$row]['CLI_NOM'];
                        $_SESSION['prenomUser'] = $donnee[$row]['CLI_PRENOM'];
                        $_SESSION['numUser'] = $donnee[$row]['CLI_NUM'];
                        header('Location:index.php');
                        die();
                }else{ header('Location: index.php?login_err=password'); die(); }
            }else{ header('Location: index.php?login_err=email'); die(); }
        }else{ header('Location: index.php?login_err=already'); die(); }
    }else{ header('Location: index.php'); die();} // si le formulaire est envoyé sans aucune données


?>