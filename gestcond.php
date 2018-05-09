<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['nombre']) {
	header("Location:index.php");
}elseif ($_SESSION['rol']==3) {
	header("Location:usuario.php");
}
?>
<meta charset="utf-8">
<?php 
 $con = mysqli_connect("localhost","root","","sistransporte") or die ("Error en la conexion");
?>


<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- Importando bootstrap -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

		<!-- Importando floating-labels para formularios -->
		<!-- <link href="assets/css/floating-labels.css" rel="stylesheet"> -->


		<title>Gestion de Conductores</title>
	</head>

	<body>


		<div class="container-fluid  p-3 bg-dark text-white text-center">
		<div class="container p-3">
		
		
			<form class="form-grop" method="post" action="gestcond.php">
			<h2>Registro de conductores</h2>
			
			<input class="mt-4 col-md-12 form-control col-12" type="text" name="nombre" placeholder="Escriba el nombre">
	
			<input class="mt-4 col-md-12 form-control col-12" type="text" name="apellido" placeholder="Escriba el apellido">
	
			<input class="mt-4 col-md-12 form-control col-12" type="text" name="numauto" placeholder="Número del vehiculo">
			<input class="mt-4 btn btn-primary col-lg-4 text-uppercase col-8" type="submit" name="ingresar" value="registrar">
			<br>
		</form>
		</div>
		</div>

		<div class="container-fluid bg-light p-0 mt-3">
			<div class="container">

		
		<?php
		if (isset($_POST['ingresar'])){

			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$nauto = $_POST['numauto'];

			$insertar = "INSERT INTO conductor(`nombre`,`apellido`,`nauto`) VALUES ('$nombre', '$apellido',$nauto)";
			$ejecutar = mysqli_query($con, $insertar);

			if ($ejecutar) {
				echo "<h2> El conductor se ha ingresado correctamente</h3>";
				# code...
			}
		}
	?>

	

		<h4>Ver lista de Conductores</h4>
	<table class="table table-striped table-bordered table-hover table-sm table-responsiv">
		<thead align= "center">

		<th>id</th>
		<th>Nombre</th>
		<th>Apellido</th>
		<th>N° Vehículo</th>
		<th>Opcion</th>
	</thead>

	<?php

	$consulta = "SELECT * FROM conductor";
	$ejecutar = mysqli_query ($con, $consulta);

	$i=0;

	while ($fila = mysqli_fetch_array($ejecutar)){
	$id = $fila['id'];
	$nombre = $fila ['nombre'];
	$apellido = $fila ['apellido'];
	$nauto = $fila ['nauto'];

	$i++;
	
	



	?>


		<tr align= "center">
			<td> <?php echo $id; ?></td>
			<td> <?php echo $nombre; ?></td>
			<td> <?php echo $apellido; ?></td>
			<td> <?php echo $nauto; ?></td>
			<td> <a class="btn btn-warning btn-sm" href="gestcond.php?editar=<?php echo $id; ?>">EDITAR</a></td>
			

		</tr>

	<?php 
	} ?>

	</table>
	<?php 
	if (isset($_GET['editar'])) {
		include ("editar.php");
		# code...
	}
	?>
	</div>
	</div>
	</body>
</html>