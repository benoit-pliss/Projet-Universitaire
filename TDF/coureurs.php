<?php

include "src/html/header.phtml";
include "src/php/util/info_conn.php";
include "src/php/util/fonction.php";

if (isset($_POST['supprimer'])) {
    supprimeCoureur($conn, $_POST['supprimer']);
    $_POST['supprimer'] = null;
}






include "src/html/coureurs.phtml";


//if (isset($_POST['supprimer'])) {

//}


