<?php
    session_start();
    include_once "../Connexionfiles/connexion_oracle.php";



	echo '<meta charset="utf-8"> ';
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);

    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['courriel']) && !empty($_POST['mdp']))
    {
        // Patch XSS
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $courriel = htmlspecialchars($_POST['courriel']);
        $mdp = htmlspecialchars($_POST['mdp']);
    
        // On vérifie si l'utilisateur existe
        $sql = 'select * from rap_client';
        $donnee = array();
        $nbligne = LireDonneesPDO2($conn, $sql, $donnee);

        $row = 0;

        for ($i = 0; $i < $nbligne; $i++){
            if ($donnee[$i]['CLI_NOM'] == $nom && $donnee[$i]['CLI_PRENOM'] == $prenom){
                $row = 1;
            }
        }




//        $check = $bdd->prepare('SELECT nom, prenom, courriel FROM rap_client WHERE prenom = ?');
//        $check->execute(array($prenom));
//        $data = $check->fetch();
//        $row = $check->rowCount();

        $courriel = strtolower($courriel); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..

        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas
        if($row == 0){
            if(strlen($nom) <= 100){ // On verifie que la longueur du nom <= 100
                if(strlen($courriel) <= 100){ // On verifie que la longueur du mail <= 100

//                            // On stock l'adresse IP
//                            $ip = $_SERVER['REMOTE_ADDR'];
//
//                            // On insère dans la base de données
//                            $sql = "select nvl(max(cli_num),0) as maxi from rap_client";
//                            LireDonneesPDO2($conn,$sql,$donnee);
//                            $cli_num = $donnee[0]['MAXI'] + 1;
////                            $sql = "  INSERT INTO rap_client VALUES ($cli_num,'".$nom."','".$prenom."','".$courriel."','".$mdp."')    ";
//
//                            $sql = " insert into rap_client values(( $cli_num, upper('$nom'), initcap('$prenom'), '$courriel', '$mdp') ";
//
//                            $res = majDonneesPDO($conn,$sql);
//
//
//                            $sql = "insert into rap_fidelisation values(select max(cli_num), sysdate, 0)";
//                            majDonneesPDO($conn, $sql);

                            // On stock l'adresse IP
                            $ip = $_SERVER['REMOTE_ADDR'];

                            // On insère dans la base de données
                            $sql = "select nvl(max(cli_num),0) as maxi from rap_client";
                            LireDonneesPDO2($conn,$sql,$donnee);

                            $cli_num = $donnee[0]['MAXI'] + 1;
                            $sql = "INSERT INTO rap_client VALUES ($cli_num,'".$nom."','".$prenom."','".$courriel."','".$mdp."')";

                            $res = majDonneesPDO($conn,$sql);




                    // On redirige avec le message de succès
                            header('Location:inscription.php?reg_err=success');
                            die();
                }else{ header('Location: inscription.php?reg_err=courriel_length'); die();}
            }else{ header('Location: inscription.php?reg_err=nom_length'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
   }


//    afficherTab($_POST);
//
//    $nom = $_POST["nom"];
//    $prenom = $_POST["prenom"];
//    $courriel =  $_POST["courriel"];
//    $mdp =  $_POST["mdp"];
//
//
//
//
//    //permet d'incrémenter le num client de 1
//    $sql = "select nvl(max(cli_num),0) as maxi from rap_client";
//    LireDonneesPDO2($conn,$sql,$donnee);
//    afficherTab($donnee);
//    $per_num = $donnee[0]['MAXI'] + 1;
//
//
//    $sql = "INSERT INTO rap_client VALUES ($per_num,'".$nom."','".$prenom."','".$courriel."','".$mdp."')";
//    afficherTab($sql);
//    $res = majDonneesPDO($conn,$sql);
//    echo "Résultats de la requête ",$res . "<br/>";
//    afficherTab($res);
//
//
////



//    function afficherTab($obj)
//    {
//        echo "<PRE>";
//        print_r($obj);
//        echo "</PRE>";
//    }


?>