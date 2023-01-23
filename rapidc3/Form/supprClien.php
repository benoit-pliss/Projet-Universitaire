<?php
session_start();

include_once "../Connexionfiles/connexion_oracle.php";
$conn = OuvrirConnexionPDO($db,$db_username,$db_password);


    if (isset($_POST['suppr'])){
        $num = $_POST['suppr'];
        $sql = "delete from rap_client where cli_num = '$num'";
        majDonneesPDO($conn, $sql);
    }

header('Location: index.php'); die();
?>
