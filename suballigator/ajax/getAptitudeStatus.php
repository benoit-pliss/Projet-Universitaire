<?php

include_once('../php/util/pdo_oracle.php');
include_once('../php/informations/syntheseAll.php');

if(isset($_GET['aptitudeId'])) {
    $aptitude = getAptitudeStatus($_GET['aptitudeId'], $_GET['studentId']);
    echo json_encode($aptitude);
} else {
    echo json_encode(getAptitudeStatus(1, 1));
}