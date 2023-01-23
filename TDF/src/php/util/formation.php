<?php
include 'php/util/conn.php';
if (!empty($_GET['formationId'])){

    $formationId = $_GET['formationId'];

    // recherche AJAX pour ajouter des Student à la formation



    // List of student who participate at this formation
    $sql = 'SELECT studentid, studentname, StudentPhone from Student where Formationid = :formationId ';

    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->bindParam(':formationId', $formationId);
    $sqlStatement->execute();
    $all = $sqlStatement->fetchAll();

    // supprimer une eleve de la formation

    if (!empty($_POST['suppr'])){
        echo $_POST['suppr'];
    }

    echo '<table>';
    echo '<tr><th>Nom</th><th>Phone</th><th>Supprimer</th></tr>';
    for($i=0;$i<count($all);$i++){
        echo '<tr>
                <td>' . $all[$i]['studentname'] . '</td>
                <td>' . $all[$i]['StudentPhone'] . '</td>
                <td>
                <form action="" method="post">
                    
                    <input type="submit" name="suppr" value="' . $all[$i]['studentid'] . '">
                </form>
                </td>
              </tr>';
    }
    echo '</table>';

}


