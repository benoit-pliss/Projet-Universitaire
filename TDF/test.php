<?php

include 'src/php/util/fonction_verif.php';
include 'src/php/util/fonction.php';
include 'src/php/util/info_conn.php';


$tabPhp = array ("Ébé-ébé","ébé-ébé","ébé-Ébé","éÉé-Ébé","'éÉ'é-É'bé'","'éæé-É'bé'","'éæé-É'Ŭé'","'é !é-É'Ŭé'","éé''éé--uù  gg","éé\"éé--uù  gg","Éééé--gg--gg","Éééé--gg-gg","DE LA TR€UC","DE LA TRUC","ééééééééééééééééééééééééééééééééééééééééééééééé","ùùùùùùùùùùùùùùùùùùùù","-péron-de - la   branche-","pied-de-biche","Ferdinand--SaintMalo ALAnage","Ferdinand--SaintMalo-ALAnage","A' ' b","A '' b","A'","a''","a' 'b","a '","a 'B","A ' B","A-'-B","A-'B","A'-B","'A-B'","A'-'B","'","x","bénard     ébert","ÆøœŒøñBæB","ÆœŒBæB","\a","\\a","b\\a","b\a","Æ'-'nO","çççç ççç ÇÇÇÇ ÇÇÇ","ÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇ","àâäéèêëïîôöùûüÿç","a΄aʹa՝a՛a՜a՚aՙa","ٽڿ۳","؏؁؂؂","ϴЭщ","Éèàùîôê-éèàùîôê","a    a       b","nªn","a---b","’aʾb′cˊdˈe‘fʿgʻhˋicˊ","ª");
echo "<table border='1'>";
foreach ($tabPhp as $valeur) {
    $nom = beautifyNom($valeur);
//    echo $nom . "<BR>";
    $prenom = beautifyPrenom($valeur);
//    echo $prenom . "<BR>";
    $err_nom = array();
    $err_prenom = array();
    verifNom($nom, $err_nom);
    verifPrenom($prenom, $err_prenom);

    //html table
    echo "<TR><TD>" . $valeur . "</TD><TD style='background: "; if (count($err_nom) > 0) echo '#ff8c8c'; else echo '#8cff8c'; echo ";'>" . $nom . "</TD><TD  style='background: "; if (count($err_prenom) > 0) echo '#ff8c8c'; else echo '#8cff8c'; echo ";'>" . $prenom . "</TD></TR>";


}
echo "</table>";
