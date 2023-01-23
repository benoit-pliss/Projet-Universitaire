<?php
include '../util/conn.php';
if (!empty($_GET['formationId'])){


    //include 'html/addStudentForm.phtml';
    include '../util/pdo_oracle.php';
    $formationId = $_GET['formationId'];

    if(isset($_POST['addBut'])){

        if (!empty($_POST['firstName']) && !empty($_POST['surname']) && !empty($_POST['phone'])){
            $studentId = 'select max(studentId)+1 as stuId from Student';
            $nblignes = LireDonneesPDO1($mysqlConnection, $studentId, $all);



            $sql = "insert into Student (studentId, studentName, formationId, studentDeleted, studentPhone) values ('" .$all[0]['stuId']."','". mb_strtoupper($_POST['surname']) ." " . $_POST['firstName'] ."','" . $_GET['formationId'] . "', '0', '" . $_POST['phone'] . "')";
            $sqlStatement = $mysqlConnection->prepare($sql);
            $sqlStatement->execute();
            //echo $sql;
            echo '<script>window.location.href = "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/html/formation.phtml?formationId=' . $formationId . '";</script>';

        }
    }

    if (isset($_POST['valid'])){
        print_r($_POST);
        $sql = "update Student set studentName = '". $_POST['name'] ."', studentPhone = '". $_POST['phone'] ."' where studentId = '" . $_POST['valid'] . "'";

        majDonneesPDO($mysqlConnection, $sql);
        unset ($_POST['valid']);
        echo '<script>window.location.href = "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/html/formation.phtml?formationId=' . $formationId . '";</script>';

    }

    // List of student who participate at this formation
    $sql = 'SELECT studentid, studentname, StudentPhone from Student where Formationid = :formationId and studentdeleted = 0';

    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->bindParam(':formationId', $formationId);
    $sqlStatement->execute();
    $all = $sqlStatement->fetchAll();

    if (!empty($_POST['suppr'])) {
        // check if Student is in this formation
        for ($i = 0; $i < count($all); $i++) {
            if ($all[$i]['studentid'] == $_POST['suppr']) {
                $sql = 'UPDATE Student SET studentdeleted = 1 WHERE studentid = :studentid';
                $sqlStatement = $mysqlConnection->prepare($sql);
                $sqlStatement->bindParam(':studentid', $_POST['suppr']);
                $sqlStatement->execute();
            }
        }
        echo '<script>window.location.href = "https://dev-sae301grp1.users.info.unicaen.fr/romaindev/html/formation.phtml?formationId=' . $formationId . '";</script>';
    }


}




















