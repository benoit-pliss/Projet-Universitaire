<?php
include_once 'src/html/header.phtml';
include_once 'src/php/util/info_conn.php';
include_once 'src/php/util/remplissage_form.php';
$sql = "select annee from tdf_parti_coureur group by annee order by annee desc";
$nbAnnee = LireDonneesPDO1($conn,$sql,$tabAnnee);
$annee = $tabAnnee[0]['ANNEE'];
if(isset($_POST['choixAnnee'])) {
    $annee = $_POST['annee'];
}
include_once 'src/html/nations_participante.phtml';

?>