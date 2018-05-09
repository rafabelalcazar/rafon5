<?php 

if (isset($_GET['editar'])){
	$editar_id = $_GET['editar'];

	$consulta = "SELECT*FROM conductor WHERE id='$editar_id'";
	$ejecutar = mysqli_query($con, $consulta);

	$fila = mysqli_fetch_array($ejecutar);

	$nombre = $fila ['nombre'];
	$apellido = $fila ['apellido'];
	$nauto = $fila ['nauto'];
}
 ?>
 <br>

 <h3>Actualizar Conductor</h3>

 <form class="container form-group d-flex row justify-content-between" method="post" action="">

 	<input class="form-control col-12 col-md-2 m-1" required placeholder="Nombres" type="text" name="nombre" value="<?php echo $nombre; ?>">
	
 	<input class="form-control col-12 col-md-2 m-1" required placeholder="Apellidos" type="text" name="apellido" value="<?php echo $apellido; ?>">
 	<input class="form-control col-12 col-md-2 m-1" required placeholder="N° de vehículo" type="text" name="nauto" value="<?php echo $nauto; ?>">
    <input class="btn col-12 col-md-2 btn-primary m-1" type="submit" name="actualizar" value="Actualizar">

	

 </form>

 <?php
 if(isset($_POST['actualizar'])){
  $actualizar_nombre = $_POST ['nombre'];
  $actualizar_apellido = $_POST ['apellido'];
  $actualizar_nauto = $_POST ['nauto'];


$actualizar = "UPDATE conductor SET nombre = '$actualizar_nombre', apellido='$actualizar_apellido', nauto='$actualizar_nauto' WHERE id = '$editar_id'";
$ejecutar = mysqli_query($con, $actualizar);

if ($ejecutar) {
	echo "<script> alert ('Datos actualizados')</script>";

	echo "<script> window.open ('gestcond.php', '_self')</script>";
	# code...
}
}
 ?>
