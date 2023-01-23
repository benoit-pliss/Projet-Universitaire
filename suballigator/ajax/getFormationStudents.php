<?php

include_once('../php/util/pdo_oracle.php');
include_once('../php/informations/syntheseAll.php');

if(isset($_GET['formationId'])) {
    $formation = getStudents($_GET['formationId']);
    echo json_encode($formation);
} else {
    echo json_encode(getStudents(1));
}