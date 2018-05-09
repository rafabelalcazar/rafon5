<!DOCTYPE HTML>
<?php
session_start();
if (@!$_SESSION['nombre']) {
	header("Location:index.php");
}elseif ($_SESSION['rol']==3) {
	header("Location:adminsis.php");
}
?>

<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

// LAs siguientes son líneas de código HTML simple, para crear una página web
?>



<!--
	Spectral by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="icon" href="../../../../favicon.ico"> -->

  <link rel="stylesheet" href="assets/css/font-awesome.min.css">

  <title>Administrador de Empresa</title>

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->

  <link href="assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-uppercase " href="index.php">
      <i class="fab fa-accusoft"></i> MovePopayán</a>
    <input class="form-control form-control-dark w-100 " type="text" placeholder="Buscar" aria-label="Search">
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">

        <a class="nav-link" href="desconectar.php">Cerrar sesión</a>
        <a href="#">Bienvenido <strong><?php echo $_SESSION['nombre'];?></strong> </a></li>


      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      
      <div class="col-12 ">
        
      </div>
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky m-y-4 p-y-4">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                  <i class="fas fa-home"></i>
                Inicio
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fab fa-hubspot"></i>
                Crear rutas
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="formulario.php">
                <i class="fas fa-bus"></i>
                style="color: rgb(153, 153, 153)"
                Crear vehículo
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="gestcond.php">
                <i class="fas fa-users"></i>
                Crear conductor
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/estadisticas_V1/grafica_miysqli.php">
                <i class="fas fa-chart-line"></i>
                Reportes Estadisticos
              </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="layers"></span>
                  Integrations
                </a>
              </li> -->
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Guardar Reportes</span>
            <a class="d-flex align-items-center text-muted" href="#">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="far fa-file"></i>
                Este mes
              </a>
            </li>

          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <!-- <h1 class="h2">Ejemplo: Sotracauca</h1> -->

          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <!-- Disponible para Sprint3 -->
              <!-- <button class="btn btn-sm btn-outline-secondary">Compartir</button> -->
              <!-- <button class="btn btn-sm btn-outline-secondary">Exportar</button> -->
            </div>
            .
<!--             <button disabled="" class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              Esta semana
            </button> -->
          </div>
        </div>

        <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>  -->

        <h2>Información de vehículo</h2>
        <div  class=" table-responsive">
          <table  class="table table-striped bg-light table-sm table-bordered table-hover">
            <thead align="center" class="bg-dark text-white">
              
                <!-- <th>#ID</th> -->
                <th>Vehiculo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Temperatura</th>
                <th>Humedad</th>
                <th>Pasajero sube</th>
                <th>Pasajero baja</th>
            </thead>
            <tbody align="center">
              
            
            <?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from datos_medidos where ID_TARJ=1 order by id DESC LIMIT 30"; // Aquí se guarda en la variable sql la sentencia de consulta a realizar
// la siguiente línea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexión a la base de datos mysqli
$result1 = $mysqli->query($sql1);
// la siguiente linea es el inicio de un ciclo while, que se ejecuta siempre que la respuesta a la consulta de la base de datos
// tenga algún registro resultante. Como la consulta arroja 5 resultados, los últimos que tenga la tabla, se ejecutará 5 veces el siguiente ciclo while.
// el resultado de cada registro de la tabla, se almacena en el arreglo row, row[0] tiene el dato del 1er campo de la tabla, row[1] tiene el dato del 2o campo de la tabla, así sucesivamente
$contador = 0;
$totalsuben = 0;
$totalbajan = 0;

while($row1 = $result1->fetch_array(MYSQLI_NUM))
{
  
 $temp = $row1[2];
 $hum = $row1[3];
 $fecha = $row1[4];
 $hora = $row1[5];
 $sube = $row1[6];
 $baja= $row1[7];
 $ID_TARJ = 1;
 $contador++;
 $totalsuben=$totalsuben+$sube;
 $totalbajan=$totalbajan+$baja;


?>


            <tbody>
              <tr>
                <!-- <td><?php echo $contador; ?> </td> -->
                <td><?php echo $ID_TARJ; ?></td>
                <td><?php echo $fecha; ?> </td>
                <td><?php echo $hora; ?></td>
                <td><?php echo $temp." ºC"; ?> </td>
                <td><?php echo $hum." %"; ?></td>
                <td><?php echo $sube; ?></td>
                <td><?php echo $baja; ?></td>
              </tr>
<?php
}
?>
            </tbody>
          </table>
        </div>
       
       <?php 
        $totalsuben=$totalsuben+$sube;
        $totalbajan=$totalbajan+$baja;
        $abordo = $totalsuben - $totalbajan;
       echo "Hay " .$abordo. " pasajeros en el vehiculo"; ?> 


   
      </main>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>

  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
  </script>

  <!-- Graphs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        datasets: [{
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false
            }
          }]
        },
        legend: {
          display: false,
        }
      }
    });
  </script>
</body>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
  crossorigin="anonymous"></script>

</html>