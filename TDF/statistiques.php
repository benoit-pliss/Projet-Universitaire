<?php
    include_once "src/html/header.phtml";
    include_once "src/php/util/info_conn.php";
    include_once "src/php/util/pdo_oracle.php";
    include_once "src/php/util/remplissage_form.php";

    $sql = "select distinct ANNEE from TDF_PARTI_COUREUR order by ANNEE";
    $lignesAnnee = LireDonneesPDO1($conn, $sql, $tabAnnee);



?>

<form class="ui form" action="" method="post">
    <div class="two fields">
        <div class="field" style="width: 100px; margin-left: 150px;">
            <select class="ui search dropdown" name="annee">
                <?php

                if (isset($_POST['annee'])){
                    for($i = 0; $i < $lignesAnnee; $i++){
                        ?>

                        <option value="<?= $tabAnnee[$i]['ANNEE']; ?>" <?php VerifierSelect('annee', $tabAnnee[$i]['ANNEE']); ?>> <?= $tabAnnee[$i]['ANNEE']; ?> </option>

                        <?php
                    }
                } else {
                    for($i = 0; $i < $lignesAnnee-1; $i++){
                        ?>

                        <option value="<?= $tabAnnee[$i]['ANNEE']; ?>" <?php VerifierSelect('annee', $tabAnnee[$i]['ANNEE']); ?>> <?= $tabAnnee[$i]['ANNEE']; ?> </option>

                        <?php
                    }
                    ?>
                    <option value="<?= date("Y") ?>" selected> <?= date("Y"); ?> </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="field">
            <button class="ui submit button"  type="submit" name="valider">Valider</button>
        </div>
    </div>
</form>

<div style=" display: flex" class="field">
    <?php
        include_once "src/php/stats/jeuneStats.php";
        include_once "src/php/stats/nouveauStats.php";
    ?>
</div>
<div class="field">
    <?php
    include_once "src/php/stats/vainqueurStat.phtml";
    ?>
</div>
<div class="field" style="margin: 200px">
    <?php
    include_once "src/php/stats/nationStat.php";
    ?>
</div>


