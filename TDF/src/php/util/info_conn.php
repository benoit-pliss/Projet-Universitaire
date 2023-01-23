<?php
	//E.Porcq	ident.php 13/10/2017
	include 'pdo_oracle.php';
	
	// pour dev
	$infoConn['login'] = 'PPHP2A_05';
	$infoConn['mdp'] = 'boulets14';
	$infoConn['instanceOCI'] = 'kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr';
	$infoConn['pdo'] = 'oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8';

	$conn = OuvrirConnexionPDO($infoConn['pdo'],$infoConn['login'],$infoConn['mdp']);

	//----------------------------------------------------
	// pour perso
	/*
	$infoConn['login'] = '';
	$infoConn['mdp'] = '';
	$infoConn['instance_OCI'] = 'XE';
	$infoConn['pdo'] = 'oci:dbname=xe;charset=AL32UTF8';
	*/
	//----------------------------------------------------
 
?>
