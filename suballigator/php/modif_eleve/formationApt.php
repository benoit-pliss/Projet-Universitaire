<?php
include '../php/util/conn.php';

if (!empty($_GET['skillId'])){

    include '../php/util/pdo_oracle.php';
    $skillId = $_GET['skillId'];
    $levelId = $_GET['levelId'];

    //when adding an aptitude
    if(isset($_POST['addBut'])){

        if (!empty($_POST['name'])){
            $aptitudeId = 'select max(aptitudeId)+1 as aptId from Aptitude';
            $nblignes = LireDonneesPDO1($mysqlConnection, $aptitudeId, $all);

            $sql = "insert into Aptitude (aptitudeId, aptitudeName, skillId, aptitudeDeleted) values ('" .$all[0]['aptId']."','". $_POST['name']."','".$_GET['skillId']."','0')";
            $sqlStatement = $mysqlConnection->prepare($sql);
            $sqlStatement->execute();
            //echo '<script>window.location.href = "formationApt.php?skillId=' . $skillId . '&levelId=' . $levelId . '";</script>';

        }
    }

    //when "deleting" an aptitude
    if (!empty($_POST['suppr'])) {
        $sql = 'SELECT aptitudeid, aptitudename from Aptitude where skillId = :skillId and aptitudedeleted = 0';
        $sqlStatement = $mysqlConnection->prepare($sql);
        $sqlStatement->bindParam(':skillId', $skillId);
        $sqlStatement->execute();
        $all = $sqlStatement->fetchAll();

        for ($i = 0; $i < count($all); $i++) {
            if ($all[$i]['aptitudeid'] == $_POST['suppr']) {
                $sql = 'UPDATE Aptitude SET aptitudedeleted = 1 WHERE aptitudeid = :aptitudeid';
                $sqlStatement = $mysqlConnection->prepare($sql);
                $sqlStatement->bindParam(':aptitudeid', $_POST['suppr']);
                $sqlStatement->execute();
            }
        }
        //echo '<script>window.location.href = "formationApt.php?skillId=' . $skillId . '&levelId=' . $levelId . '";</script>';
    }

    //when updating an aptitude
    if (isset($_POST['valid'])){
        $sql = "update Aptitude set aptitudeName = '". $_POST['name'] ."' where aptitudeId = '" . $_POST['valid'] . "'";
        majDonneesPDO($mysqlConnection, $sql);
        unset ($_POST['valid']);
        //echo '<script>window.location.href = "formationApt.php?skillId=' . $skillId . '&levelId=' . $levelId . '";</script>';
    }

    if (!empty($_POST['back'])){
        echo "<meta http-equiv='refresh' content='0;url=addSkillForm.phtml?levelId=".$_POST['back']."'>";
        die();
    }

    // List of aptitude required in this formation
    $sql = 'SELECT aptitudeid, aptitudename from Aptitude where skillId = :skillId and aptitudedeleted = 0';
    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->bindParam(':skillId', $skillId);
    $sqlStatement->execute();
    $all = $sqlStatement->fetchAll();

}




















