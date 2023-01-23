<?php
	// E.Porcq : programme de test pour le projet Agile
	// connexion_oracle.php 29/05/2021
	include_once "pdo_agile.php";
	include_once "param_connexion.php";
	echo '<meta charset="utf-8"> ';
	$conn = OuvrirConnexionPDO($db,$db_username,$db_password);





//	function insererDonnee($c)
//	{
//		$sql = "INSERT INTO bidon VALUES (25,'Valise')";
//		$res = majDonneesPDO($c,$sql);
//		echo "Résultats de la requête " ,$res . "<br/>";
//
//
//		$sql = "INSERT INTO bidon VALUES (26,'Valise')";
//		$res = majDonneesPDO($c,$sql);
//		echo "Résultats de la requête ",$res . "<br/>";
//	}
//
//	function conneerrigerDos($c)
//	{
//		$sql = "update bidon set b='trousse' where b='Valise'";
//		$res = majDonneesPDO($c,$sql);
//		echo "Résultats de la requête " . $res . "<br/>";
//	}

	function lireDonnees($c)
	{
		$sql = "select pla_nom, (pla_prix_vente_unit_ht*(pla_tva/100+1)) as prix from rap_plat
join rap_boisson using(pla_num)";

		LireDonneesPDO2($c,$sql,$donnee);
		foreach($donnee as $cle => $ligne)
		{
			foreach($ligne as $cle => $contenu)
				echo $contenu;
			// html
			echo "<br/>";
		}
		return $donnee;
	}




	function afficherTab($obj)
	{
		echo "<PRE>";
		print_r($obj);
		echo "</PRE>";
	}

 ?>
