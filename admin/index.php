<?php
require('views/headeradministrador.php');
require_once('invernadero.class.php');
$app = new Invernadero;
$data = $app->readAll();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Area", {
                role: "style"
            }],
            <?php foreach ($data as $invernadero): ?>["<?php echo ($invernadero['invernadero']); ?>", <?php echo ($invernadero['area']); ?>, "#AF1740"],
            <?php endforeach; ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "Invernaderos por secciones",
            width: 1000,
            height: 500,
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
</script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>

<?php require('views/footer.php'); ?>