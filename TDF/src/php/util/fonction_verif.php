<?php

//fonction de remplacement

function beautifyNom($str){
    $str = retireEspaces($str);

    $str = removeCapitalAccent($str);
    $str = removeAccent($str);
    $str = retireEspaces($str);

    //remplacement spécifique
    $str = remplaceEszett($str);
    $str = replaceAe($str);
    $str = replaceOe($str);
    $str = replaceObarre($str);
    $str = replaceNtilde($str);
    $str = remplaceNonApostrophe($str);

//    $str = remplacePlus2tirets($str);
    $str = retireTiretsDebutFin($str);


    //mise en majuscule
    $str = mb_strtoupper($str);
    return $str;
}

function beautifyPrenom($str){
    $str = retireEspaces($str);
    $str = remplaceEszett($str);



    //remplacement spécifique
    $str = remplaceEszett($str);
    $str = replaceAe($str);
    $str = replaceOe($str);
    $str = replaceObarre($str);
    $str = replaceNtilde($str);
    $str = remplaceNonApostrophe($str);

//    $str = remplacePlus2tirets($str);
    $str = retireTiretsDebutFin($str);


//    $str = retirerEspaceInutile($str);
//    $str = removeCapitalAccent($str);

    $str = mb_strtolower($str);
    $str = capitalPremiereLettre($str);
    $str = removeCapitalAccent($str);
    return $str;
}

function remplaceEszett($str){
    $str = str_replace('ẞ', 'SS', $str);
    return str_replace('ß', 'ss', $str);
}

function retireEspaces($string) {
    $string = trim($string);
    $string = preg_replace('/\s+/', ' ', $string);
    $string = preg_replace("/-[ ]*/u", "-", $string);
    $string = preg_replace("/[ ]*-/", "-", $string);
    $string = preg_replace("/'[ ]*/u", "'", $string);
    $string = preg_replace("/[ ]*'/", "'", $string);
    $string = preg_replace("/''/u", "' '", $string);
    return $string;
}

function removeCapitalAccent($str){
    return strtr_utf8($str, "ÀÂÄÉÈÊËÏÎÔÖÙÛŬÜŸÇÑ", "AAAEEEEIIOOUUUUYCN");
}

function removeAccent($str){
    return strtr_utf8($str, "àâäéèêëïîôöùûŭüÿçñ", "aaaeeeeiioouuuuycn");
}

function replaceAe($str){
    $str = str_replace("æ", "ae", $str);
    $str = str_replace("Æ", "ae", $str);
    return $str;
}

function replaceOe($str){
    $str = str_replace("œ", "oe", $str);
    $str = str_replace("Œ", "oe", $str);
    return $str;
}

function replaceObarre($str){
    $str = str_replace('ø', 'o', $str);
    $str = str_replace('Ø', 'O', $str);
    return $str;
}

function replaceNtilde($str){
    return strtr_utf8($str, "ñ", "n");
}

//function remplacePlus2tirets($str){
//    return preg_replace('/-{3,}/u', '--', $str);
//}

function remplaceNonApostrophe($str){
    return preg_replace("/[’ʾ′ˊˈ‘ʿʻˋˊ΄ʹ՝՛՜՚ՙ]/u", "'", $str);
}

function retireTiretsDebutFin($str){
    $str =  preg_replace("/^-/u", "", $str);
    return preg_replace("/-$/u", "", $str);
}


function strtr_utf8($str, $from, $to) {
    $keys = array();
    $values = array();
    preg_match_all('/./u', $from, $keys);
    preg_match_all('/./u', $to, $values);
    $mapping = array_combine($keys[0], $values[0]);
    return strtr($str, $mapping);
}



function capitalPremiereLettre($str){
    $str = mb_strtoupper(removeCapitalAccent(mb_substr( $str, 0, 1 ))).mb_substr( $str, 1 );

    for($i = 0; $i < strlen(utf8_decode($str))-1; $i++){
        if(preg_match(("/( )[a-zA-Zàâäéèêëïîôöùûŭüÿç]/"),mb_substr( $str, $i, 2 ))
            || preg_match(("/(-)[a-zA-Zàâäéèêëïîôöùûŭüÿç]/"),mb_substr( $str, $i, 2 ))
            || preg_match(("/(')[a-zA-Zàâäéèêëïîôöùûŭüÿç]/"),mb_substr( $str, $i, 2 ))){
            $str = mb_substr( $str, 0, $i+1 ).mb_strtoupper(removeCapitalAccent(mb_substr( $str, $i+1, 1 ))).mb_substr( $str, $i+2 );
        }

    }
    return $str;
}




//function verifApostrophe($chaine){
//    $chaine = trim($chaine);
//    $chaine =preg_replace("/' '/", "''", $chaine);
//    for($i = 0; $i<strlen(utf8_decode($chaine))-1; $i++){
//        if($chaine[$i] == "'" && $chaine[$i+1] == " " && preg_match("/[A-Za-z]/", $chaine[$i+2])){
//            $pattern = "/(') (".$chaine[$i+2].")/";
//            $replacement  = "'".$chaine[$i+2];
//            $chaine = preg_replace($pattern, $replacement, $chaine);
//        }
//        else if(  preg_match("/[A-Za-z]/", $chaine[$i]) && $chaine[$i+1] == " " && $chaine[$i+2] == "'"){
//            $pattern = "/(".$chaine[$i].") (')/";
//            $replacement  = $chaine[$i]."'";
//            $chaine = preg_replace($pattern, $replacement, $chaine);
//        }
//    }
//    return $chaine;
//}



//-------------------------------------------------------------------
//-----------------------Les Verifs----------------------------------



//si il a des chiffres ce n'est pas un nom
//function verifNombre($str){
//    return !preg_match("/[0-9]/",$str);
//}

// permet de verifier si une chaine de caracrères contient deux fois des double tirets







function verifNom($str, &$errmsg){
    regexNom($str, $errmsg);
    tropLong($str, $errmsg);
    verifCapitale($str, $errmsg);
//    verifPlusdeDeuxTirets($str, $errmsg);
    verif2apostrophes($str, $errmsg);
    verif2fois2tirets($str, $errmsg);
    verifContientCapitale($str, $errmsg);
    verifDebutFin($str, $errmsg);
    verifApostropheTirets($str, $errmsg);
    verifPlusdeTroisTirets($str, $errmsg);
    verifApostrophe($str, $errmsg);
    return count($errmsg) == 0;
}

function regexNom($str, &$errmsg){
    if (preg_match("/^[A-Z\-' ]*$/u",$str))
        return true;
    $errmsg[] = "Le Nom ne peut contenir que des lettres majuscules, des tirets et des espaces";
    return false;
}

function verif2fois2tirets($str, &$errmsg){
    $matches = array();

    preg_match_all("/(--)/u",$str,$matches);
    if (count($matches[0]) > 1){
        $errmsg[] = "Il ne peut pas y avoir plus d'une fois deux tirets consécutifs";
        return false;
    }
    return true;
}

function verifPlusdeTroisTirets($str, &$errmsg){
    if(preg_match("/-{3,}/u",$str)){
        $errmsg[] = "Il ne peut pas y avoir plus de trois tirets consécutifs pour un nom";
        return true;
    }
    return false;
}

function verifPrenom($str, &$errmsg){
    regexPrenom($str, $errmsg);
    tropLong($str, $errmsg);
    verifCapitale($str, $errmsg);
    verifPlusdeDeuxTirets($str, $errmsg);
    verifContientCapitale($str, $errmsg);
    verif2apostrophes($str, $errmsg);
    verifDebutFin($str, $errmsg);
    verifApostropheTirets($str, $errmsg);
    verifApostrophe($str, $errmsg);
    return count($errmsg) == 0;
}

function regexPrenom($str, &$errmsg){
    if(preg_match("/^[A-Za-z'ç-öù-ýÿ\-à-å ]*$/u",$str))
        return true;
    $errmsg[] = "Le Prénom ne peut contenir que des lettres, des tirets, des espaces et des apostrophes";
    return false;
}

function tropLong($str, &$errmsg){
    if(preg_match("/^.{30,}$/u",$str)){
        $errmsg[] = "Le Nom ou le Prénom ne peut pas dépasser 30 caractères";
        return true;
    }
    return false;
}

function verifCapitale($str, &$errmsg){
    //renvoie true si les caractères après des espaces, tirets ou apostrophes sont des majuscules
    if (preg_match("/[' \-]+[^A-Z\-' ]/u",$str))
        $errmsg[] = "Les majuscules ne sont pas correctes";
    if (preg_match("/^[^A-Z']/u",$str))
        $errmsg[] = "La première lettre doit être une majuscule ou un apostrophe";
    return false;
}


function verif2apostrophes($str, &$errmsg){
    if (preg_match("/('')/u",$str) || preg_match("/^(' ')/u",$str) || preg_match("/(' ')$/u",$str)) {
        $errmsg[] = "Il ne peut pas y avoir deux apostrophes à la suite";
        return false;
    }
    return true;
}

function verifPlusdeDeuxTirets($str, &$errmsg){
    if(preg_match("/-{2,}/u",$str)){
        $errmsg[] = "Il ne peut pas y avoir plus de deux tirets consécutifs pour un prénom";
        return true;
    }
    return false;
}

function verifContientCapitale($chaine, &$errmsg){
    if(preg_match("/[A-Z]/u",$chaine)){
        return true;
    }
    $errmsg[] = "Un nom ou prénom doit forcément contenir une majuscule.";
    return false;
}

function verifDebutFin($str, &$errmsg){
    if(preg_match("/-$/u",$str)){
        $errmsg[] = "Le Nom ou le Prénom ne peut pas commencer ou finir par un tiret";
        return false;
    }
    return true;
}

function verifApostropheTirets($str, &$errmsg){
    if(preg_match("/(-'-)/u",$str)){
        $errmsg[] = "Un apostrophe doit être entourée d'une lettre";
        return false;
    }
    return true;
}

//regex that check if an apostrophe is at least stick to one word
function verifApostrophe($str, &$errmsg){
    if(preg_match("/^('-)|(-')$/u",$str)) {
        $errmsg[] = "Un apostrophe doit être entourée d'une lettre";
        return false;
    }
    return true;
}


//fonction de vérificattion des doublons

function doublon($nom, $prenom, $conn){
    $req = $conn->prepare("SELECT COUNT(*) FROM TDF_COUREUR WHERE NOM = :nom AND PRENOM = :prenom");
    $req->bindParam(':nom', $nom);
    $req->bindParam(':prenom', $prenom);
    $req->execute();
    $res = $req->fetch();
    if ($res[0] > 0){
        return true;
    }
    return false;
}



//fonction de vérification des années
function verifAnneeNaissance($annee, &$erreur)
{
    if(is_numeric($annee)){
        if($annee > date("Y")){
            $erreur[] = "L'année de naissance ne peut pas être supérieure à l'année actuelle.";
            return false;
        }
        if($annee < date("Y")-60){
            $erreur[] = "L'année de naissance ne peut pas être inférieure à l'année actuelle - 60.";
            return false;
        }
        return true;
    }
    //si l'année n'est pas un nombre
    $erreur[] = "L'année de naissance doit être numérique.";
    return false;
}

function verifAnnee($annee){
    if(!is_numeric($annee)) return false;
    return true;
}

function verifNationalite($str, $conn){
    if (strlen($str) != 3) return false;
    if ($conn->query("SELECT COUNT(*) FROM TDF_NATION WHERE CODE_CIO = '$str'")->fetch()[0] == 0)
        return false;
    return true;
}

/**
 * @param $str string Nom du sponsor à vérifier
 * @param $erreur array Tableau d'erreurs
 * @return bool Vrai si le nom du sponsor est correct, faux sinon
 */
function verifNomSponsor($str, &$erreur)
{
    if (strlen($str) > 50){
        $erreur[] = "Le nom du sponsor ne peut pas dépasser 50 caractères.";
    }
    if (strlen($str) == 0){
        $erreur[] = "Le nom du sponsor ne peut pas être vide.";
    }
    if (preg_match("/[À-ÖØ-Ý]/u",$str)){
        $erreur[] = "Le nom du sponsor ne peut contenir que des majuscules sans accents.";
    }


}

/**
 * @param $str string Nom abrégé du sponsor à vérifier
 * @param $erreur array
 * @param $conn PDO
 * @return bool Vrai si le nom abrégé du sponsor est correct, faux sinon
 */
function verifNomAbregeSponsor($str, &$erreur)
{
    if (strlen($str) > 3){
        $erreur[] = "Le nom abrégé du sponsor ne peut pas dépasser 3 caractères.";
    }
    if (strlen($str) == 0){
        $erreur[] = "Le nom abrégé du sponsor ne peut pas être vide.";
    }
    if (preg_match("/[À-ÖØ-Ý]/u",$str)){
        $erreur[] = "Le nom abrégé du sponsor ne peut contenir que des majuscules.";
    }


}

