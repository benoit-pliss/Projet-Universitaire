<?php
include_once('../php/util/conn.php');


if (!empty($_GET['levelId'])){

    include '../php/util/pdo_oracle.php';
    $levelId = $_GET['levelId'];

    //when adding a skill
    if(isset($_POST['addBut'])){

        if (!empty($_POST['name'])){
            $skillId = 'select max(skillId)+1 as skiId from Skill';
            $nblignes = LireDonneesPDO1($mysqlConnection, $skillId, $all);

            $sql = "insert into Skill (skillId, skillName, skillDeleted, levelId) values ('" .$all[0]['skiId']."','". $_POST['name']."','0','".$_GET['levelId']."')";
            $sqlStatement = $mysqlConnection->prepare($sql);
            $sqlStatement->execute();
            //echo '<script>window.location.href = "formationSkill.php?levelId=' . $levelId . '";</script>';

        }
    }

    //when "deleting" a skill
    if (!empty($_POST['suppr'])) {
        $sql = 'SELECT skillid, skillname from Skill where LevelId = :levelId and skilldeleted = 0';
        $sqlStatement = $mysqlConnection->prepare($sql);
        $sqlStatement->bindParam(':levelId', $levelId);
        $sqlStatement->execute();
        $all = $sqlStatement->fetchAll();

        for ($i = 0; $i < count($all); $i++) {
            if ($all[$i]['skillid'] == $_POST['suppr']) {
                $sql = 'UPDATE Skill SET skilldeleted = 1 WHERE skillid = :skillid';
                $sqlStatement = $mysqlConnection->prepare($sql);
                $sqlStatement->bindParam(':skillid', $_POST['suppr']);
                $sqlStatement->execute();
            }
        }
        //echo '<script>window.location.href = "formationSkill.php?levelId=' . $levelId . '";</script>';
    }

    //when updating a skill
    if (isset($_POST['valid'])){
        $sql = "update Skill set skillName = '". $_POST['name'] ."' where skillId = '" . $_POST['valid'] . "'";
        majDonneesPDO($mysqlConnection, $sql);
        unset ($_POST['valid']);
        //echo '<script>window.location.href = "formationSkill.php?levelId=' . $levelId . '";</script>';

    }

    if (!empty($_POST['aptitude'])){
        echo "<meta http-equiv='refresh' content='0;url=addAptForm.phtml?skillId=".$_POST['aptitude']."&levelId=".$_GET['levelId']."'>";
        die();
    }

    if (!empty($_POST['back'])){
        //rediriger sur majMFT.phtml
        echo "<meta http-equiv='refresh' content='0;url=majMFT.phtml'>";
        die();
    }

//-----------------------------------------------------------------------------------------------------------------------------------
        //when adding an aptitude
        if(isset($_POST['addButApt'])){

            if (!empty($_POST['nameapt'])){
                $aptitudeId = 'select max(aptitudeId)+1 as aptId from Aptitude';
                $nblignes = LireDonneesPDO1($mysqlConnection, $aptitudeId, $all);
    
                $sql = "insert into Aptitude (aptitudeId, aptitudeName, skillId, aptitudeDeleted) values ('" .$all[0]['aptId']."','". $_POST['nameapt']."','".$_POST['addButApt']."','0')";
                $sqlStatement = $mysqlConnection->prepare($sql);
                $sqlStatement->execute();
                //echo '<script>window.location.href = "formationSkill.php?levelId=' . $_GET['levelId'] . '";</script>';
    
            }
        }
    
        //when "deleting" an aptitude
        if (!empty($_POST['aptsuppr'])) {
            $tab = explode("/", $_POST['aptsuppr']);

            $sql = 'SELECT aptitudeid, aptitudename from Aptitude where skillId = :skillId and aptitudedeleted = 0';
            $sqlStatement = $mysqlConnection->prepare($sql);
            $sqlStatement->bindParam(':skillId', $tab[0]);
            $sqlStatement->execute();
            $all = $sqlStatement->fetchAll();
    
            for ($i = 0; $i < count($all); $i++) {
                if ($all[$i]['aptitudeid'] == $tab[1]) {
                    $sql = 'UPDATE Aptitude SET aptitudedeleted = 1 WHERE aptitudeid = :aptitudeid';
                    $sqlStatement = $mysqlConnection->prepare($sql);
                    $sqlStatement->bindParam(':aptitudeid', $tab[1]);
                    $sqlStatement->execute();
                }
            }
            //echo '<script>window.location.href = "formationSkill.php?levelId=' . $_GET['levelId']. '";</script>';
        }
    
        //when updating an aptitude
        if (isset($_POST['aptvalid'])){

            $sql = "update Aptitude set aptitudeName = '". $_POST['aptname'] ."' where aptitudeId = '" .$_POST['aptvalid'] . "'";

            majDonneesPDO($mysqlConnection, $sql);
            unset ($_POST['aptvalid']);
            //echo '<script>window.location.href = "formationSkill.php?levelId=' . $_GET['levelId']. '";</script>';
        }


    // List of skill required in this formation
    $sql = 'SELECT skillid, skillname from Skill where LevelId = :levelId and skilldeleted = 0';
    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->bindParam(':levelId', $levelId);
    $sqlStatement->execute();
    $all = $sqlStatement->fetchAll();
}
?>



















