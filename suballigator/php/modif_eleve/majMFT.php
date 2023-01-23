<?php

// affiche trois liens vers des formations différentes
$sql = 'select levelId, levelName from Level order by levelName ASC';

$sqlStatement = $mysqlConnection->prepare($sql);
$sqlStatement->execute();
$all = $sqlStatement->fetchAll();

echo '<div class="flex flex-row justify-center items-center gap-x-2">';
for($i=0;$i<count($all);$i++){
    echo '<button onclick="window.location.href = \'' . 'addSkillForm.phtml?levelId=' . $all[$i]['levelId'] . '\';" class="btn btn-secondary">' . $all[$i]['levelName'] . '</button>';
}
echo '</div>';
