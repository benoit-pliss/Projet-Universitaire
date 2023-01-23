<?php
$sql = "select JEUNE, count(*) as nombre from TDF_PARTI_COUREUR
                                     where ANNEE = 2022
        group by JEUNE";

$query = $conn->prepare("select JEUNE, count(*) as nombre from TDF_PARTI_COUREUR
                                     where ANNEE = :annee group by JEUNE");
if (isset($_POST['annee'])) {
    $annee = $_POST['annee'];
} else {
    $annee = date("Y");
}

$query->bindParam(":annee", $annee);
$query->execute();
$tabJeune = $query->fetchAll(PDO::FETCH_ASSOC);

$tabJeune[0]['JEUNE'] = 'Coureur';
$tabJeune[1]['JEUNE'] = 'Jeune';
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
            foreach ($tabJeune as $row) {
                echo "['" . $row["JEUNE"] . "', " . $row["NOMBRE"] . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Part de Jeune coureur pendant le tour <?= $annee ?>',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('JeuneStat'));
        chart.draw(data, options);
    }

</script>

<div id="JeuneStat" style="width: 900px; height: 500px;"></div>




