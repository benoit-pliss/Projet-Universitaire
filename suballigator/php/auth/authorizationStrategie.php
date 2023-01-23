<?php

class AuthorizationStrategie
{

    public function addToPageList(&$pageList, $page)
    {
        $exists = false;
        foreach ($pageList as $p) {
            if ($p['NOM'] == $page['NOM'] && $p['URL'] == $page['URL']) {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            array_push($pageList, $page);
        }
    }

    public function authorizedPages()
    {
        $pageList = array();
        if (isset($_SESSION['initiatorId'])) {
            if ($_SESSION['initiatorIsDirector'] == 1) {
                $this->addToPageList($pageList, array("NOM" => "Accueil", "URL" => "accueil.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Modifier/Ajouter un élève", "URL" => "addStudent.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Evaluer les aptitudes des élèves", "URL" => "evaluation.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse d'élève", "URL" => "studentSkills.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse de formation", "URL" => "syntheseAll.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Créer/Modifier une séance", "URL" => "choiceSession.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Créer un compte initiateur", "URL" => "Ajout_Initiateur.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Créer une formation", "URL" => "addFormation.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Mise à jour de la MFT", "URL" => "majMFT.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Attribuer un rôle", "URL" => "Modifier_Initiateur.phtml"));
            } else if ($_SESSION['initiatorIsManager'] == 1) {
                $this->addToPageList($pageList, array("NOM" => "Accueil", "URL" => "accueil.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Modifier/Ajouter un élève", "URL" => "addStudent.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Evaluer les aptitudes des élèves", "URL" => "studentSkills.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse d'élève", "URL" => "studentSkills.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse de formation", "URL" => "syntheseAll.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Créer/Modifier une séance", "URL" => "choiceSession.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Saisir les compétences et aptitudes de ma formation", "URL" => "majMFT.phtml"));
            } else {
                $this->addToPageList($pageList, array("NOM" => "Accueil", "URL" => "accueil.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Evaluer les aptitudes des élèves", "URL" => "studentSkills.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse d'élève", "URL" => "studentSkills.phtml"));
                $this->addToPageList($pageList, array("NOM" => "Synthèse de formation", "URL" => "syntheseAll.phtml"));
            }
        } else {
            $this->addToPageList($pageList, array("NOM" => "Connectez-vous pour accéder aux fonctionnalités", "URL" => ""));
        }


        return $pageList;
    }
}
