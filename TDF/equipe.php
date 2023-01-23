<?php
include 'src/html/header.phtml';
include 'src/php/util/info_conn.php';

if(isset($_GET['n_equipe']) && !empty($_GET['n_equipe'])){
    $sql = "select annee, n_equipe, n_sponsor, sponsor.nom as NOM_EQUIPE, 
            directeur_pre.nom as NOM_DIRECTEUR_PRE, directeur_pre.prenom as PRENOM_DIRECTEUR_PRE, 
            nvl(directeur_sec.nom, 'Aucun') as NOM_DIRECTEUR_SEC, directeur_sec.prenom as PRENOM_DIRECTEUR_SEC
            from tdf_equipe equipe
            join tdf_sponsor sponsor using(n_equipe)
            join tdf_parti_equipe parti_equipe using(n_equipe, n_sponsor)
            join tdf_directeur directeur_pre on parti_equipe.n_pre_directeur = directeur_pre.n_directeur
            left join tdf_directeur directeur_sec on parti_equipe.n_sec_directeur = directeur_sec.n_directeur
            where n_equipe = ".$_GET['n_equipe']."
            order by annee desc";
    LireDonneesPDO1($conn,$sql,$tabHistoriqueEquipe);

    include 'src/html/equipe.phtml';
}else{
    echo "<h1>Erreur Aucune Equipe sélectionné</h1>";
}





