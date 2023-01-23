<?php
    /**
     * @param $arrayErreur array Tableau de chaines de caractères qui stockent les erreurs
     * @param $field string Nom du champ dans le formulaire HTML
     * @return void Affiche un appel à une fonction js si une erreur est présente
     */
    function afficheErreurField($field, array $arrayErreur): void
    {
        if (count($arrayErreur) > 0) {
            echo "addArrayErrorMessage('" . $field . "', " . json_encode($arrayErreur) . ");";
        }
    }

    /**
     * Recupere la liste des coureurs
     * @param $conn
     * @param $tri
     * @param $filtre
     * @return array Tableau des coureurs
     **/
    function getCoureurs($conn, $tri, $filtre){
        $req = "select co.n_coureur as n_coureur, co.nom as nom, co.prenom as prenom, co.annee_naissance as annee_naissance, 
                co.annee_prem as annee_prem, an.annee_debut as annee_debut, na.nom as nationalite, su.supprimable, lower(substr(na.CODE_ISO, 0, 2)) as CODE_ISO 
                from tdf_coureur co
                join tdf_app_nation an on co.n_coureur = an.n_coureur
                join tdf_nation na on an.code_cio = na.code_cio 
                left join (SELECT n_coureur,'1' as supprimable from tdf_coureur
                                where n_coureur not in
                                (
                                    select n_coureur from tdf_parti_coureur
                                )
                            ) su on co.n_coureur = su.n_coureur
                where an.annee_fin is null";
        if(isset($tri) && isset($filtre)){
            $req .= " order by $tri $filtre";
        }
        else{
            $req .= " order by n_coureur desc";
        }
        LireDonneesPDO1($conn, $req, $tab);
        return $tab;
    }

    /**
     * Recupere la liste des informations d'un coureur
     * @param $conn
     * @return Tableau des des infos
     **/
    
    function getCoureur($conn, $n_coureur){
        $req = "select co.n_coureur as n_coureur, co.nom as nom, co.prenom as prenom, co.annee_naissance as annee_naissance, 
            co.annee_prem as annee_prem, an.code_cio as code_cio, an.annee_debut as annee_debut, na.nom as nationalite
            from tdf_coureur co
            join tdf_app_nation an on co.n_coureur = an.n_coureur
            join tdf_nation na on an.code_cio = na.code_cio 
            where an.annee_fin is null and co.n_coureur = $n_coureur";
        LireDonneesPDO1($conn, $req, $tab);
        return $tab[0];
    }



    /**
     * Recupere la liste des nationalite
     * @param $conn
     * @return Tableau des des nationalite avec le code cio
     **/
    function getNationalite($conn){
        $req = 'select NOM, CODE_CIO from TDF_NATION order by NOM';
        LireDonneesPDO1($conn, $req, $tab);
        return $tab;
    }

    /**
     * Affiche la listes des coureurs
     * @param $tab contient la liste des coureurs
     **/
    function afficheCoureur($tab){

        ?>
        <table class="ui celled table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Naissance</th>
                <th>Nationnalité</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
   <?php
        foreach($tab as $row){
            ?>
                <tr onclick="window.location='coureur.php?n_coureur=<?php echo $row['N_COUREUR'] ?>'">

                    <td data-label="Nom"><?php echo $row['NOM']; ?></td>
                    <td data-label="Prénom"><?php echo $row['PRENOM']; ?></td>
                    <td data-label="Date de Naissance"><?php echo $row['ANNEE_NAISSANCE']; ?></td>
                    <td data-label="Nationnalité"><?php echo $row['NATIONALITE']; ?></td>
                    <td data-label="Supprimer">

                    <?php
                        if ($row['SUPPRIMABLE'] == 1){
                            ?>
                                <button class="ui button" type="submit" name="supprimer" value="<?php echo $row['N_COUREUR'] ?>" onclick="return confirmation('<?php echo $row['NOM'] ?>', '<?php echo $row['PRENOM'] ?>');"><i class="trash alternate icon"></i></button>
                            <?php

                        }
                    ?>
                    </td>  
                </tr>
<?php
        }
        ?>
        </tbody>
        </table>
<?php
    }

    /**
     * Verifie si un coureur avec le meme nom et prenom existe deja dans la table
     * @param $conn
     * @param $nom Nom du coureur
     * @param $prenom Prenom du coureur
     * @return boolean Renvoie vrai si le duo (nom, prenom) est deja present dans la table
     * */
    function existeDuo($conn, $nom, $prenom){
        $req = "SELECT count(*) as nb from TDF_COUREUR where NOM = '$nom' and PRENOM = '$prenom'";
        LireDonneesPDO1($conn, $req, $tab);
        return $tab[0]['NB'] != 0;
    }

    /**
     * Supprime un coureur de la base de données
     * @param $conn
     * @param $n_coureur Numero du coureur
     * */
    function supprimeCoureur($conn, $n_coureur){
        $sql = 'delete from tdf_app_nation where n_coureur = '.$n_coureur;
        majDonneesPDO($conn, $sql);
        $sql = 'delete from tdf_coureur where n_coureur = '.$n_coureur;
        majDonneesPDO($conn, $sql);
    }







    function modifierCoureur($conn, $donnees){
		$tab = getCoureur($conn, $donnees['n_coureur']);
		$erreur = false;

		if (isset($donnees['n_coureur'])) {

            if (!empty($donnees['modifNom']) && !empty($donnees['modifPrenom'])){
                $donnees['modifNom'] = beautifyNom($donnees['modifNom']);
                $donnees['modifPrenom'] = beautifyPrenom($donnees['modifPrenom']);
                if (!checkNom($donnees['modifNom'])) {
                    echo "Le Nom n'est pas valide.<br>";
                    $erreur = true;
                }
                if (!checkPrenom($donnees['modifPrenom'])) {
                    echo "Le Prenom n'est pas valide.<br>";
                    $erreur = true;
                }
                if (existeDuo($conn,$donnees['modifNom'], $donnees['modifPrenom'])) {
                    echo "Un coureur avec ce Nom et ce Prénom existe déjà.<br>";
                    $erreur = true;
                }
            }else{
                echo "Le champ Nom et Prenom est obligatoire.<br>";
                $erreur = true;
            }

            if (!empty($donnees['modifAnneeNaiss'])) {
                if(!verifAnneeNaissance($donnees['modifAnneeNaiss'])){
                    echo "L\'année de naissance n\'est pas valide.";
                    $erreur = true;
                }
            }else{
                $donnees['modifAnneeNaiss'] = "null";
            }


            if (!empty($donnees['modifAnneePrem'])) {
                
                    echo "L'année de premiere participation n'est pas valide";
                    $erreur = true;
                }
            }else{
                $donnees['modifAnneePrem'] = "null";
            }

            if (!empty($donnees['modifAnneeDebut'])) {
                if(!verifAnnee($donnees['modifAnneeDebut'])){
                    $erreurAnnee_debut = "L'année de début de nationalité n'est pas valide.";
                        $erreur = true;
                }
                    if(!($donnees['modifAnneeDebut'] >= $donnees['modifAnneeNaiss'])){
                        $erreurAnnee_debut = "L'année de début de nationalité doit être supérieure à l'année de naissance";
                        $erreur = true;
                    }
                
            }

            if (!$erreur) {
                $sql = "update tdf_coureur set nom = '".$donnees['modifNom']."' where n_coureur =". $donnees['n_coureur'];
                majDonneesPDO($conn, $sql);

                $sql = "update tdf_coureur set prenom = '".$donnees['modifPrenom']."' where n_coureur =". $donnees['n_coureur'];
                majDonneesPDO($conn, $sql);

                $sql = "update tdf_coureur set annee_naissance = ".$donnees['modifAnneeNaiss']." where n_coureur =". $donnees['n_coureur'];
                majDonneesPDO($conn, $sql);

                $sql = "update tdf_coureur set annee_prem = ".$donnees['modifAnneePrem']." where n_coureur =". $donnees['n_coureur'];
                majDonneesPDO($conn, $sql);

                $sql = "update tdf_coureur set annee_prem = ".$donnees['modifAnneePrem']." where n_coureur =". $donnees['n_coureur'];
                majDonneesPDO($conn, $sql);

                return true;
            }else{
                return false;
            }
    }

    function AfficherOptions($tab)
    {
        foreach($tab as $ligne){
            ?>
            <option value="<?= $ligne['ANNEE'] ?>" <?php verifierSelectGET("annee", $ligne['ANNEE']); ?>><?= $ligne['ANNEE'] ?></option>
            <?php
        }
    }
    function AfficheClassement($tab)
    {
        foreach($tab as $val){
            ?><tr><?php
            foreach($val as $value){ ?>
                <td><?= $value ?></td>
            <?php } ?>
            </tr>
        <?php }
    }

    function getRescoureur($conn, $n_coureur){
        $query = $conn->prepare("select c.NOM as NOM, PRENOM, ANNEE_NAISSANCE,
           (to_char(sysdate, 'yyyy') - ANNEE_NAISSANCE ) as AGE,
           n.NOM as NATNOM, CODE_CIO,
           lower(substr(CODE_ISO, 0, 2)) as CODE_ISO,
           an.annee_debut as annee_debut,
           an.annee_fin as annee_fin,
           c.annee_prem as annee_prem
            from TDF_COUREUR c
            join TDF_APP_NATION an using (n_coureur)
            join TDF_NATION n using (CODE_CIO)
            where N_COUREUR = :n_coureur
            order by annee_debut desc");
        $query->bindParam(":n_coureur", $n_coureur);
        $query->execute();
        $rescoureur = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $rescoureur;
    }

function getResparticoureur($conn, $n_coureur, $rescoureur){
    $query = $conn->prepare("select N_EQUIPE, N_SPONSOR, pc.ANNEE as ANNEE, N_DOSSARD, JEUNE, CODE_CIO, RANG_ARRIVEE, s.NOM as NOMSPONSOR, ROUND((TEMPS/3600), 2) as TEMPS from TDF_PARTI_COUREUR pc
                                    join TDF_SPONSOR s using (n_equipe, n_sponsor)
                                    join TDF_EQUIPE e using (n_equipe)
                                    join TDF_CLASSEMENTS_GENERAUX cg on pc.N_COUREUR = cg.N_COUREUR and cg.ANNEE = pc.ANNEE
                                    where pc.N_COUREUR = :n_coureur
                                    order by pc.ANNEE desc  ");
    $query->bindParam(":n_coureur", $n_coureur);
    $query->execute();
    $resparticoureur = $query->fetchAll(PDO::FETCH_ASSOC);

    //modification d'un coureur
    $code_cio = $rescoureur['CODE_CIO'];
    $query = $conn->prepare("select ANNEE_DEBUT from TDF_APP_NATION
                                    where CODE_CIO = :code_cio and N_COUREUR = :n_coureur");
    $query->bindParam(":n_coureur", $n_coureur);
    $query->bindParam(":code_cio", $code_cio);
    $query->execute();
    $tabAnneeDebut = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resparticoureur;
}

function getNationalitesCoureur($n_coureur, $conn){
    $sql = "select nat.* ,rownum as numero from 
			(
    			select N_COUREUR, CODE_CIO, ANNEE_DEBUT, ANNEE_FIN, nom
    			from tdf_app_nation 
    			join tdf_nation using(code_cio)
    			where N_COUREUR = ".$n_coureur." order by ANNEE_DEBUT
			) nat";
    $nbNat = LireDonneesPDO1($conn, $sql, $nationalites);
    return $nationalites;
}

function afficheMessagesErreur($erreurs){
    echo '<div class="ui red message"><ul class="list">';
    for ($i=0;$i<count($erreurs);$i++){
        echo "<li>".$erreurs[$i]."</li>";
    }
    echo '</ul></div>';
}



?>