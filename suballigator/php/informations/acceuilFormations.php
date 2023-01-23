<?php

include '../php/util/conn.php';

// affiche trois liens vers des formations différentes

$sql = 'select distinct FormationId, FormationName from TrainingManager 
join Formation using(FormationId)
where InitiatorId = 1 
order by FormationId ASC';

$sqlStatement = $mysqlConnection->prepare($sql);
$sqlStatement->execute();
$all = $sqlStatement->fetchAll();

for($i=0;$i<count($all);$i++){
    
    $sql2 = 'select count(*) as nb from Student where FormationId = ' . $all[$i]['FormationId'] . ' and studentDeleted = 0';
    $sqlStatement2 = $mysqlConnection->prepare($sql2);
    $sqlStatement2->execute();
    $all2 = $sqlStatement2->fetchAll();

    echo '
    <div class="card w-96 bg-primary text-primary-content">
  <div class="card-body">
    <h2 class="card-title">' . $all[$i]['FormationName'] . '</h2>
    <p>'. $all2[0]["nb"] .' étudiant(s) suivent cette formation</p>
    <div class="card-actions justify-end">
    <button class="btn" onclick="window.location.href = \'' . 'displayFormation.phtml?formationId=' . $all[$i]['FormationId'] . '\';">Détail</button>
    </div>
  </div>
</div>';

}
