<?php

include 'php/util/conn.php';

// affiche trois liens vers des formations différentes

$sql = 'select FormationId, FormationName from TrainingManager 
join Formation using(FormationId)
where InitiatorId = 1 
order by FormationId ASC';

$sqlStatement = $mysqlConnection->prepare($sql);
$sqlStatement->execute();
$all = $sqlStatement->fetchAll();

for($i=0;$i<count($all);$i++){
    echo '<a href="php/formation.php?formationId=' . $all[$i]['FormationId'] . '">Formation ' . $all[$i]['FormationName'] . '</a></br>';
}

// bouton de déconnexion

echo '<a href="php/auth/logout.php">Deconnexion</a>';

?>
