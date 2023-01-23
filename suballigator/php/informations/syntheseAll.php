<?php


function authorizeUser($userIDSession){
    $conn = recupererConnexion();
    $sql = "SELECT COUNT(*) AS AUTHORIZE FROM Initiator WHERE initiatorId = $userIDSession";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab[0]["AUTHORIZE"];
}

function getFormations(){
    $conn = recupererConnexion();
    $sql = "SELECT * FROM Formation where formationDeleted = 0";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab;   
}


function getStudents($formationID){
    $conn = recupererConnexion();
    $sql = "SELECT Student.studentName, Student.studentId
    FROM Student
    JOIN Formation ON Student.formationId = Formation.formationId
    WHERE Formation.formationId = $formationID
    ORDER BY Student.studentName ASC";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab;
}


function getSkills($formationID){
    $conn = recupererConnexion();
    $sql = "SELECT Skill.skillName, Skill.skillId
    FROM Skill
    JOIN Level ON Skill.levelId = Level.levelId
    JOIN Formation ON Level.levelId = Formation.levelId
    WHERE Formation.formationId = $formationID
    AND Skill.skillDeleted = 0
    ORDER BY Skill.skillName ASC";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab;
}


function getSkillAptitudes($skillId){
    $conn = recupererConnexion();
    $sql = "SELECT Aptitude.aptitudeName, Aptitude.aptitudeId
    FROM Aptitude
    JOIN Skill ON Aptitude.skillId = Skill.skillId
    WHERE Skill.skillId = $skillId
    AND Aptitude.aptitudeDeleted = 0
    ORDER BY Aptitude.aptitudeName ASC";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab;
}

function getAptitudeStatus($aptitudeId, $studentId){
    $conn = recupererConnexion();
    $sql = "SELECT statusName, statusColor, statusId
    from Student join Participation using(studentId)
    join Status using(Statusid)
    join Content using(Contentid)
    join Aptitude using(Aptitudeid)
    join Session USING (sessionid) 
    where (Statusid = 3 or statusid = 4)
    and studentid = $studentId
    and Aptitudeid = $aptitudeId 
    order by Sessiondate desc limit 3";
    $cur = preparerRequetePDO($conn, $sql);
    LireDonneesPDOPreparee($cur, $tab);
    return $tab;
}

//path : php/informations/syntheseAll.php
