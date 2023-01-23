<?php


$query = $conn->prepare("select sum(case when ANNEE_PREM != :annee then 1 else 0 end) as ancient, sum(case when ANNEE_PREM = :annee then 1 else 0 end) as nouveau
from TDF_COUREUR
join TDF_PARTI_COUREUR TPC on TDF_COUREUR.N_COUREUR = TPC.N_COUREUR
where ANNEE = :annee");

if (isset($_POST['annee'])) {
    $annee = $_POST['annee'];
} else {
    $annee = date("Y");
}

$query->bindParam(":annee", $annee);
$query->execute();
$tabNouveau = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            echo "['ANCIENS', " . $tabNouveau[0]["ANCIENT"] . "],";
            echo "['NOUVEAUX', " . $tabNouveau[0]["NOUVEAU"] . "],";
            ?>
        ]);

        var options = {
            title: 'Part des nouveaux coureur pendant le tour <?= $annee ?>',
            pieHole: 0.4,
            //colors: ['#FFFF00', '#282828']
            //colors: ['#282828', '#CACBCD']
        };

        var chart = new google.visualization.PieChart(document.getElementById('NouveauxStat'));
        chart.draw(data, options);
    }

</script>

<body>

<div id="NouveauxStat" style="width: 900px; height: 500px;"></div>


</body>



