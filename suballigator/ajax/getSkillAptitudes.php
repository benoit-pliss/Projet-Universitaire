<?php

include_once('../php/util/pdo_oracle.php');
include_once('../php/informations/syntheseAll.php');

if(isset($_GET['skillId'])) {
    $skill = getSkillAptitudes($_GET['skillId']);
    echo json_encode($skill);
} else {
    echo json_encode(getSkillAptitudes(1));
}