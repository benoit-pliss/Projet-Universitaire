<?php

//includes
include "src/php/util/fonction_verif.php";

//Fonctions
function afficheMessagesErreur($erreurs){
	echo '<div class="ui red message"><ul class="list">';
        for ($i=0;$i<count($erreurs);$i++){
            echo "<li>".$erreurs[$i]."</li>";
        }
    echo '</ul></div>';
}

//Variables
$erreursDateDebut = array();
$erreursNationalite = array();

//Traitement bouton ajout de nationalite
if (isset($_POST['ajouterNationalite'])) {
	include "src/html/nation_coureur_form.phtml";
}

//Traitement bouton suppression de nationalite
if (isset($_POST['supprimerNationalite']) && count($nationalites)>1) {
	$sql = "delete from tdf_app_nation where n_coureur=".$n_coureur." and code_cio='".$anneeEnCours['CODE_CIO']."'";
	MajDonneesPDO($conn, $sql);
	
	$nationalites = getNationalitesCoureur($n_coureur, $conn);
	$anneeEnCours = $nationalites[count($nationalites)-1];	
	$sql = "update tdf_app_nation set annee_fin='' where CODE_CIO='".$anneeEnCours['CODE_CIO']."' and n_coureur=".$n_coureur;
	MajDonneesPDO($conn, $sql);
		
	$nationalites = getNationalitesCoureur($n_coureur, $conn);
	$anneeEnCours = $nationalites[count($nationalites)-1];
}

//Traitement bouton d'Insertion de nationalite
if (isset($_POST['insertionNationalite'])) {
	
	//Verification de l'année de début saisie
	if (empty($_POST['anneeDebut'])) {
		$erreursDateDebut[] = "Veuillez entrer une année de début de Nationalité.";
	}else{
		if(!verifAnnee($_POST['anneeDebut'])){
			$erreursDateDebut[] = "L'année doit contenir seulement des chiffres.";
		}
		if ($_POST['anneeDebut'] <= $anneeEnCours['ANNEE_DEBUT']) {
			$erreursDateDebut[] = "L'annéede début doit être supérieur à l'année de début de la Nationalité en cours.";
		}
	}

	//Verification de la nationalité saisie
	if (empty($_POST['nationalite'])) {
		$erreursNationalite[] = "Veuillez choisir un nationalité.";
	}else{
		if(!verifNationalite($_POST['nationalite'], $conn)){
			$erreursNationalite[] = "Cette nationalité n'est pas valide.";
		}
		if ($_POST['nationalite'] == $anneeEnCours['CODE_CIO']) {
			$erreursNationalite[] = "La nationalité doit être différente de la Nationalité en cours.";
		}
	}

	//Insertion de la Nationalité ou erreur
	if (count($erreursDateDebut)!==0 || count($erreursNationalite)!==0){
		include "src/html/nation_coureur_form.phtml";
	}
	else{
		$sql = "update tdf_app_nation set annee_fin=".$_POST['anneeDebut']."-1 where CODE_CIO='".$anneeEnCours['CODE_CIO']."' and n_coureur=".$n_coureur;
		MajDonneesPDO($conn, $sql);
		$sql = "insert into tdf_app_nation(n_coureur, code_cio, annee_debut) values (".$n_coureur.", '".$_POST['nationalite']."', ".$_POST['anneeDebut'].")";
		MajDonneesPDO($conn, $sql);
	}
}

//Modification

//Variables
$nationaliteEnModif;
$nationalitePrecedente;
$nationaliteSuivante;
//Traitement du bouton appelant le formulaire de modification de nationalite
if (isset($_POST['modifierNationalite'])) {
	foreach ($nationalites as $nationalite) {
		if ($nationalite['NUMERO'] == $_POST['modifierNationalite']) {
			$nationaliteEnModif = $nationalite;
		}
		if ($nationalite['NUMERO']-1 == $_POST['modifierNationalite']) {
			$nationalitePrecedente = $nationalite;
		}
		if ($nationalite['NUMERO']+1 == $_POST['modifierNationalite']) {
			$nationaliteSuivante = $nationalite;
		}
	}
	include "src/hmtlnation_coureur_form.phtml";
}

//Traitement du bouton confirmation modification de nationalite
if (isset($_POST['confirmModifNation'])) {
	foreach ($nationalites as $nationalite) {
		if ($nationalite['NUMERO'] == $_POST['confirmModifNation']) {
			$nationaliteEnModif = $nationalite;
		}
		if ($nationalite['NUMERO']+1 == $_POST['confirmModifNation']) {
			$nationalitePrecedente = $nationalite;
		}
		if ($nationalite['NUMERO']-1 == $_POST['confirmModifNation']) {
			$nationaliteSuivante = $nationalite;
		}
	}
	//Verification de l'année de début saisie
	if (empty($_POST['anneeDebut'])) {
		$erreursDateDebut[] = "Veuillez entrer une année de début de Nationalité.";
	}else{
		if(!verifAnnee($_POST['anneeDebut'])){
			$erreursDateDebut[] = "L'année doit contenir seulement des chiffres.";
		}
		if (isset($nationalitePrecedente)) {
			if ($_POST['anneeDebut'] <= $nationalitePrecedente['ANNEE_DEBUT']) {
				$erreursDateDebut[] = "L'année de début doit être supérieur à l'année de début de la Nationalité précédente.";
			}
		}
		if (isset($nationaliteSuivante)) {
			if ($_POST['anneeDebut'] >= $nationaliteSuivante['ANNEE_DEBUT']) {
				$erreursDateDebut[] = "L'année de début doit être inférieur à l'année de début de la Nationalité suivante.";
			}
		}
	}

	//Verification de la nationalité saisie
	if (empty($_POST['nationalite'])) {
		$erreursNationalite[] = "Veuillez choisir un nationalité.";
	}else{
		if(!verifNationalite($_POST['nationalite'], $conn)){
			$erreursNationalite[] = "Cette nationalité n'est pas valide.";
		}
		foreach ($nationalites as $nationalite) {
			if ($nationalite['CODE_CIO'] == $_POST['nationalite']) {
				$erreursNationalite[] = "La nationalité doit être différente des autres nationalités.";
			}
		}
	}

	//Modification de la Nationalité ou erreur
	if (count($erreursDateDebut)!==0 || count($erreursNationalite)!==0){
		include "src/html/nation_coureur_form.phtml";
	}
	else{
		if (isset($nationalitePrecedente)) {
			$sql = "update tdf_app_nation set annee_fin=".$_POST['anneeDebut']."-1 where CODE_CIO='".$nationalitePrecedente['CODE_CIO']."' and n_coureur=".$n_coureur;
			MajDonneesPDO($conn, $sql);
		}
		$sql = "update tdf_app_nation set annee_debut=".$_POST['anneeDebut'].", CODE_CIO='".$_POST['nationalite']."' where CODE_CIO='".$nationaliteEnModif['CODE_CIO']."' and n_coureur=".$n_coureur;
		MajDonneesPDO($conn, $sql);
	}
}
$nationalites = getNationalitesCoureur($n_coureur, $conn);
$anneeEnCours = $nationalites[count($nationalites)-1];
?>