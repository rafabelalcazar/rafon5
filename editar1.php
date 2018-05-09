<?php 

if (isset($_GET['editar1'])){
	$editar_id = $_GET['editar1'];

	$consulta = "SELECT*FROM login WHERE id='$editar_id'";
	$ejecutar = mysqli_query($con, $consulta);

	$fila = mysqli_fetch_array($ejecutar);

	$nombre = $fila ['nombre'];
	$apellido = $fila ['apellido'];
	$mail = $fila ['user'];
	$rol = $fila ['rol'];
	$contrasena = $fila ['passadmin'];

}
 ?>
 <br>

 <form method="post" action="">
 	<input type="text" name="nombre" value="<?php echo $nombre; ?>">
 	<input type="text" name="apellido" value="<?php echo $apellido; ?>">
 	<input type="text" name="correo" value="<?php echo $mail; ?>">
 	<input type="text" name="rol" value="<?php echo $rol; ?>">
<input type="text" name="contrasena" value="<?php echo $contrasena; ?>">

    <input type="submit" name="actualizar" value="Actualizar Datos del administrador de la empresa">


 </form>

 <?php
 if(isset($_POST['actualizar'])){
  $actualizar_nombre = $_POST ['nombre'];
  $actualizar_apellido = $_POST ['apellido'];
  $actualizar_correo = $_POST ['correo'];
  $actualizar_rol = $_POST ['rol'];
    $actualizar_contrasena = $_POST ['contrasena'];



$actualizar = "UPDATE login SET nombre = '$actualizar_nombre', apellido='$actualizar_apellido', user='$actualizar_correo',	 rol='$actualizar_rol', passadmin='$actualizar_contrasena' WHERE id = '$editar_id'";
$ejecutar = mysqli_query($con, $actualizar);

if ($ejecutar) {
	echo "<script> alert ('Datos actualizados')</script>";

	echo "<script> window.open ('adminsis.php', '_self')</script>";
	# code...
}
}
 ?>