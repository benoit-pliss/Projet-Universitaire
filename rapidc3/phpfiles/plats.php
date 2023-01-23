<?php

include_once "Connexionfiles/connexion_oracle.php";



$sql = "select pla_nom, (pla_prix_vente_unit_ht*(pla_tva/100+1)) as prix from rap_plat
join rap_pizza using(pla_num)
union
select pla_nom, (pla_prix_vente_unit_ht*(pla_tva/100+1)) as prix from rap_plat
join rap_kebab using(pla_num)";
$nbligne = LireDonneesPDO2($conn, $sql, $donnee);

//afficherTab($donnee);


//$result = mysql_query($a);
//echo $result;

for ($i = 0; $i < $nbligne; $i++) {
?>
	<a href='#'>
        <div class='item'>
        <h3><?php echo $donnee[$i]['PLA_NOM']; ?></h3>
        <img src='images/burger.jpg'>

            <h3><?php echo $donnee[$i]['PRIX']; ?></h3>
      </div>
    </a>
<?php
}
?>