<?php


//requete form annee
$req2 = "select distinct(annee) from tdf_classements_generaux order by(annee)";


//include
include("src/html/header.phtml");
include("src/php/util/info_conn.php");
include("src/php/util/remplissage_form.php");
include("src/php/util/fonction.php");
include("src/php/util/fonction_verif.php");


LireDonneesPDO1($conn, $req2, $tab);

//traitement

if (isset($_GET["annee"]) && !empty($_GET["annee"])) {
    $annee = $_GET["annee"];
    $erreur = false;

} else {
    $annee = date("Y");
    $_GET['annee'] = $annee;

}
$reqCla = "select distinct n_coureur,n_equipe,rang_arrivee,dossard,nom,prenom,decode(tdf_parti_coureur.jeune,'o','JEUNE') as J,code_pays,equipe, 
            TO_CHAR(TRUNC(temps/3600),'FM9900') || ':' ||
            TO_CHAR(TRUNC(MOD(temps,3600)/60),'FM00') || ':' ||
            TO_CHAR(MOD(temps,60),'FM00') as HH_MM_SS
            from tdf_classements_generaux cg
            join tdf_parti_coureur using(n_coureur)
            where tdf_parti_coureur.annee = $annee and n_coureur not in(select n_coureur from tdf_parti_coureur where valide = 'R') and cg.annee = $annee
        UNION
           select distinct n_coureur,n_equipe, null as rang_arrivee,n_dossard as dossard,tdf_coureur.nom,prenom,JEUNES,tdf_app_nation.code_CIO as code_pays,tdf_sponsor.nom as equipe, 'ABAND' as HH_MM_SS
            from tdf_parti_coureur
            join tdf_coureur using(n_coureur)
            left join (select n_coureur, 'JEUNE' as JEUNES
            from TDF_PARTI_COUREUR 
            where jeune = 'o' and annee = $annee) using (n_coureur)
            join tdf_sponsor using (n_equipe,n_sponsor)
            join tdf_app_nation using(n_coureur)
            where n_coureur in(select n_coureur from tdf_abandon where annee = $annee)
            and 
            annee= $annee
            order by rang_arrivee";

LireDonneesPDO1($conn, $reqCla, $tabCla);

$reqSpon = "select tdf_coureur.nom,tdf_coureur.prenom,tdf_sponsor.nom as sponsor
        from tdf_parti_coureur 
        join tdf_sponsor using (n_equipe,n_sponsor)
        join tdf_coureur using(n_coureur) 
        where annee = $annee order by tdf_sponsor.nom";

LireDonneesPDO1($conn, $reqSpon, $tabSpon);

$reqEta = "select distinct n_etape,ville_d,ville_a,distance || ' km',decode(cat_code,'PRO','Prologue','CMI','Contre la montre individuel','CME','Contre la montre par équipe','ETA','Etape en ligne','Autre') 
        as TYPE_ETAPE,prenom || ' ' || nom from tdf_etape et
        join tdf_temps using (n_etape,n_comp)
        join tdf_coureur using(n_coureur)
        where (n_coureur,et.annee,n_etape,n_comp) in 
        (select n_coureur,annee,n_etape,n_comp from tdf_temps where annee=$annee and rang_arrivee=1) and et.annee=$annee order by n_etape";

LireDonneesPDO1($conn, $reqEta, $tabEta);

include("src/html/edition.phtml");
// include("src/html/tdf_info_annee.phtml");



