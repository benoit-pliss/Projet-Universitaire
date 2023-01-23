<?php

include "util/info_conn.php";



if (isset($_GET['annee']) && isset($_GET['val'])) {

    if ($_GET['val'] == 'equipe'){
        $res = $conn->query("
            select N_EQUIPE, N_SPONSOR, NOM from TDF_PARTI_EQUIPE
            join TDF_SPONSOR using(N_SPONSOR, N_EQUIPE)
            where ANNEE = 2022
            order by NOM
        ")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($res as $equipe) :?>

            <div class="item" data-value="<?=$equipe['N_EQUIPE'] . '~' . $equipe['N_SPONSOR'];?>"><?=$equipe['NOM'];?></div>
        <?php endforeach;
    }
    elseif ($_GET['val'] == 'coureur'){
        $res = $conn->query("select c.NOM || ' ' || c.PRENOM as COUREUR, N_COUREUR, n.NOM as NATION,  lower(substr(CODE_ISO, 0, 2)) as CODE_ISO from TDF_COUREUR c
                                                            join TDF_APP_NATION using (N_COUREUR)
                                                            join TDF_NATION n using(CODE_CIO)
                                                            order by c.NOM")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $coureur) :?>
            <div class="item" data-value="<?= $coureur['N_COUREUR'];?>"><i class="<?= $coureur['CODE_ISO'] ?> flag"></i><?=$coureur['COUREUR'];?></div>
        <?php endforeach;
    }
    else{
        echo "Erreur";
    }
}
else{
    echo "Erreur";
}