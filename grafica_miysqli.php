<!DOCTYPE HTML>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>v0.1 Graficas MYSQLI</title>

        <style type="text/css">
#container {
    min-width: 310px;
    max-width: 800px;
    height: 400px;
    margin: 0 auto
}
        </style>
    </head>
    <body>
<script src="code/highcharts.js"></script>
<script src="code/modules/series-label.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>

<div id="container"></div>
    <script type="text/javascript">
            Highcharts.chart('container', {
            title: {
                text: 'ESTADISTICAS "TEMPERATURA Y HUMEDAD"'
            },
            subtitle: {
                text: 'VEHICULO'
            },
            yAxis: {
                title: {
                    text: 'Datos en ºC(temperatura) y %(humedad)'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Temperatura',
                data: <?php 
                    include("ejecutarSelectTEMPERATURAHUMEDAD.php");
                    echo "[";
                    for($x=0;$x<$tamañoFilas;$x++)
                        echo $arreglo[$x]['temperatura'] . ", ";
                    echo "]";
                ?>
                //data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
            }, {
                name: 'Humedad',
                data: <?php 
                    include("ejecutarSelectTEMPERATURAHUMEDAD.php");
                    echo "[";
                    for($x=0;$x<$tamañoFilas;$x++)
                        echo $arreglo[$x]['humedad'] . ", ";
                    echo "]";
                ?>
                //data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
        </script>
    </body>
</html>