<?php


/**
 * @param $n_coureur int Numéro du coureur
 * @param $annee int Année de la participation
 * @param $conn PDO Connexion à la base de données
 * @return bool Vrai si le coureur n'est pas déjà inscrit à cette année
 */
function verifSeulParticipation($n_coureur, $annee, $conn): bool
{
    $req = $conn->prepare("SELECT * FROM TDF_PARTI_COUREUR WHERE n_coureur = :n_coureur and annee = :annee");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->bindParam(':annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        return true;
    }
    return false;
}

/**
 * @param $n_sponsor int Numéro du sponsor
 * @param $n_equipe int Numéro de l'équipe
 * @param $annee int Année de la participation
 * @param $conn PDO Connexion à la base de données
 * @return int Nombre de coureurs inscrits dans l'équipe
 */
function nbCoureurEquipe(int $n_equipe, int $n_sponsor, int $annee, PDO $conn): int
{
    $req = $conn->prepare("SELECT count(*) as nb FROM TDF_PARTI_COUREUR WHERE n_sponsor = :n_sponsor and annee = :annee and N_EQUIPE = :n_equipe");
    $req->bindParam(':n_sponsor', $n_sponsor);
    $req->bindParam(':annee', $annee);
    $req->bindParam(':n_equipe', $n_equipe);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['NB'];
}

/**
 * @param $n_equipe int  Numero de l'équipe
 * @param $annee int Année de la participation
 * @param $n_sponsor int Numero du sponsor
 * @param $conn PDO Connexion à la base de données
 * @return bool Vrai si l'équipe est Inscrite à l'année donnée
 */
function verifEquipeParticipante(int $n_equipe, int $n_sponsor, int $annee, PDO $conn): bool
{
    $req = $conn->prepare("select * from TDF_PARTI_EQUIPE
                            where N_EQUIPE = :n_equipe
                            and N_SPONSOR = :n_sponsor
                            and ANNEE = :n_annee");
    $req->bindParam(':n_equipe', $n_equipe);
    $req->bindParam(':n_sponsor', $n_sponsor);
    $req->bindParam(':n_annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        return false;
    }
    return true;
}

/**
 * @param $n_coureur int Numéro du coureur
 * @param $conn PDO Connexion à la base de données
 * @return bool Vrai si le numéro de coureur correspond à un coureur dans la BDD
 */
function verifCoureurExiste(int $n_coureur, PDO $conn): bool
{
    $req = $conn->prepare("select * from TDF_COUREUR where N_COUREUR = :n_coureur");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        return false;
    }
    return true;
}

/**
 * @param int $n_dossard Numéro de dossard
 * @param int $annee Année de la participation
 * @param PDO $conn Connexion à la base de données
 * @return bool Vrai si le numéro de dossard n'est pas déjà pris pour un coureur de l'année indiquée
 */
function verifNDossardNonExistant(int $n_dossard, int $annee, PDO $conn): bool
{
    $req = $conn->prepare("select * from TDF_PARTI_COUREUR where N_DOSSARD = :n_dossard and ANNEE = :annee");
    $req->bindParam(':n_dossard', $n_dossard);
    $req->bindParam(':annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        return true;
    }
    return false;
}


/**
 * @param int $n_coureur Numéro du coureur
 * @param int $annee Année de la participation
 * @param array &$erreurs Tableau de chaines de caractères qui stockent les erreurs
 * @param PDO $conn Connexion à la BDD
 * @return bool Vrai si le coureur peut être inscrit à l'année indiquée, faux si trop jeune, trop vieux, ou déjà inscrit
 */
function verifCoureur(int $n_coureur, int $annee, array &$erreurs, PDO $conn) : bool
{
    $req = $conn->prepare("select * from TDF_COUREUR where N_COUREUR = :n_coureur");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        $erreurs[] = "Le coureur n'existe pas";
        return false;
    }
    $req = $conn->prepare("select * from TDF_PARTI_COUREUR where N_COUREUR = :n_coureur and ANNEE = :annee");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->bindParam(':annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) != 0){
        $erreurs[]= "Le coureur est déjà inscrit à cette année";
        return false;
    }
    $req = $conn->prepare("select * from TDF_COUREUR where N_COUREUR = :n_coureur and :annee - ANNEE_NAISSANCE < 18");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->bindParam(':annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) != 0){
        $erreurs[] = "Le coureur est trop jeune pour participer à cette année";
        return false;
    }
    $req = $conn->prepare("select * from TDF_COUREUR where N_COUREUR = :n_coureur and :annee - ANNEE_NAISSANCE > 60");
    $req->bindParam(':n_coureur', $n_coureur);
    $req->bindParam(':annee', $annee);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) != 0){
        $erreurs[] = "Le coureur est trop vieux pour participer à cette année";
        return false;
    }
    return true;

}

function verifDirecteurPasDejaParticipant(int $n_directeur, int $annee, PDO $conn): bool
{
    $req = $conn->prepare("select N_PRE_DIRECTEUR as DIRECTEUR from TDF_PARTI_EQUIPE
                                where ANNEE = :annee
                                and (N_PRE_DIRECTEUR = :n_directeur
                                or N_SEC_DIRECTEUR = :n_directeur
                                or N_TROi_DIRECTEUR = :n_directeur)");
    $req->bindParam(':annee', $annee);
    $req->bindParam(':n_directeur', $n_directeur);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    if(count($result) == 0){
        return false;
    }
    return true;


}

