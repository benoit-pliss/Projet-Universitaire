<?php

include 'util/info_conn.php';


if (isset($_GET['filtre']) && $_GET['filtre'] != 'undefined') {
    $filtre = $_GET['filtre'];
}else {
    $filtre = "TC.NOM";
}

if (isset($_GET['sens']) && $_GET['sens'] != 'undefined') {
    $sens = $_GET['sens'];
}else {
    $sens = "ASC";
}

if (isset($_GET['search']) && $_GET['search'] != 'undefined' && !empty($_GET['search'])) {
    $search =  $_GET['search'] . "%";
}else {
    $search = "%%";
}
//echo $nom;
//echo $filtre;
//echo $sens;



$req = $conn->prepare("select TC.N_COUREUR as N_COUREUR, TC.NOM as TC_NOM, TC.PRENOM as TC_PRENOM, TC.ANNEE_NAISSANCE as TC_NAISS, TN.NOM as NAT, lower(substr(TN.CODE_ISO, 0, 2)) as CODE_ISO, SUPP from TDF_COUREUR TC
                            join TDF_APP_NATION TAN on TC.N_COUREUR = TAN.N_COUREUR
                            join TDF_NATION TN using (CODE_CIO)
                            left join (
                                select TC2.N_COUREUR, 'true' as SUPP from TDF_COUREUR TC2
                                where TC2.N_COUREUR not in (
                                    select N_COUREUR from TDF_PARTI_COUREUR
                                )
                            ) TC2 on TC.N_COUREUR = TC2.N_COUREUR
                            where ANNEE_DEBUT =
                                  (
                                        select max(ANNEE_DEBUT) from TDF_APP_NATION TAN2
                                        where TAN2.N_COUREUR = TC.N_COUREUR
                                        group by N_COUREUR
                                        )
                                and upper($filtre) like upper(:search) 
                                order by $filtre $sens");
$req->bindParam(':search', $search);


if($req->execute()){
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {?>
        <tr onclick="window.location.href='coureur.php?n_coureur=<?=$row['N_COUREUR'] ?>'">
            <td><?php echo $row['TC_NOM']; ?></td>
            <td><?php echo $row['TC_PRENOM']; ?></td>
            <td><?php echo $row['TC_NAISS']; ?></td>
            <td><i class="flag <?= $row['CODE_ISO']?>"></i> <?php echo $row['NAT']; ?></td>
            <td>
            <?php if($row['SUPP'] == 'true'){ ?>
                    <button class="negative ui icon button" type="submit" name="supprimer" value="<?php echo $row['N_COUREUR']; ?>" onclick="return confirmation('<?php echo $row['TC_NOM'] ?>', '<?php echo $row['TC_PRENOM'] ?>');"><i class="trash icon"></i></button>
            <?php } ?>
            </td>
        </tr>
<?php
    }
}else {
    echo "Récupération des données impossible";
}