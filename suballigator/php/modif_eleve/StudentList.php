<?php
    include '../util/conn.php';
    $sql = 'SELECT studentname, StudentPhone from Student where Formationid = 1 ';

    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->execute();
    $all = $sqlStatement->fetchAll();

    for($i=0;$i<count($all);$i++){
        echo $all[$i]['studentname'] . "</br>";
    }

