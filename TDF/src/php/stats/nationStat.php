<?php


$query = $conn->prepare("select TN.NOM,  upper(substr(CODE_ISO, 0, 2)) as CODE_ISO, count(CODE_CIO) as NB from TDF_PARTI_COUREUR
                                                                                          join TDF_COUREUR TC using (N_COUREUR)
                                                                                          join TDF_APP_NATION TAN using (N_COUREUR)
                                                                                          join TDF_NATION TN using (CODE_CIO)
where ANNEE = :annee
group by TN.NOM, CODE_ISO");

if (isset($_POST['annee'])) {
    $annee = $_POST['annee'];
} else {
    $annee = date("Y");
}

$query->bindParam(":annee", $annee);
$query->execute();
$tabNation = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['geochart'],
    });
    google.charts.setOnLoadCallback(drawRegionsMap);

    function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
            ['Country', 'Popularity'],
            <?php
            foreach ($tabNation as $row) {
                echo "['" . $row["CODE_ISO"] . "', " . $row["NB"] . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Nombre de participant par pays',
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
    }
</script>
<body>

<div id="regions_div" style="width: 900px; height: 500px;"></div>


</body>



