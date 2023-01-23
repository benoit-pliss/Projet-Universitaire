<?php

class AuthorizationStrategie
{
    public function authorizedPages($session){
        $pageList = array();
        if($session['initiatorIsDirector'] == 1){
            array_push($pageList, array("NOM"=> "Informations de formations", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Modifier/Ajouter un élève", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Evaluer les aptitudes des élèves", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse d'élève", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse de formation", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Créer une séance", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Créer un compte initiateur", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Mise à jour de la MFT", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Attribuer un rôle", "URL"=> ""));
        }else if($session['isFormationDirector'] == 1){
            array_push($pageList, array("NOM"=> "Modifier/Ajouter un élève", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Evaluer les aptitudes des élèves", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse d'élève", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse de formation", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Créer une séance", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Saisir les compétences et aptitudes de ma formation", "URL"=> ""));
        }else{
            array_push($pageList, array("NOM"=> "Evaluer les aptitudes des élèves", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse d'élève", "URL"=> ""));
            array_push($pageList, array("NOM"=> "Synthèse de formation", "URL"=> ""));
        }

        return $pageList;
    }
}
