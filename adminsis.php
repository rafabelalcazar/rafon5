<!DOCTYPE html>
<?php
session_start();
if (@!$_SESSION['nombre']) {
  header("Location:index.php");
}elseif ($_SESSION['rol']==2) {
  header("Location:usuario.php");
}
?>





<!DOCTYPE html>
<meta charset="utf-8">
<?php 
 $con = mysqli_connect("localhost","root","","sistransporte") or die ("Error en la conexion");
?>


<html>
  <head>
    <title>Admin Sistem</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Importando bootstrap -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Importando Font-Awesome -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

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


  <div class="container-fluid p-3 mt-4 bg-dark text-white text-center">
    <div class="container p-3">
    <form class="form-grop" method="post" action="adminsis.php">
        <h2 class="display-4">ADMINISTRADOR SISTEMA</h2>

        <h3 class="h4">Aqui puede crear Usuarios tipo Administrador de Empresa</h3>
        <input class="mt-4 col-md-12 form-control col-12" required type="text" name="nombre" placeholder="Escriba el nombre">
	      <input class="mt-4 col-md-12 form-control col-12" required type="text" name="apellido" placeholder="Escriba el apellido">
        <input class="mt-4 col-md-12 form-control col-12" required type="mail" name="correo" placeholder="Escriba el correo">
        <input class="mt-4 col-md-12 form-control col-12" required type="password" name="contrasena" placeholder="Escriba la contraseña">

        <!-- Botones  -->
        <input class="mt-4 btn btn-primary col-lg-4 text-uppercase col-8" type="submit" name="ingresar" value="registrar">
        <input class="mt-4 btn btn-secondary col-lg-4 text-uppercase col-8" type="reset" name="ingresar" value="Limpiar"> 
    </form>
    </div>
  </div>

  <div class="container-fluid">
    <div class="container">
    <?php
       if (isset($_POST['ingresar'])){

      	$nombre = $_POST['nombre'];
      	$apellido = $_POST['apellido'];
      	//$nauto = $_POST['numauto'];
        $mail = $_POST ['correo'];
     
        $contrasena = $_POST ['contrasena'];



      	$insertar = "INSERT INTO login (`nombre`,`apellido`,`user`,`password`, `passadmin`,`rol`, `estado` ) VALUES ('$nombre', '$apellido','$mail', '',md5('$contrasena'), '1','1')";
      	$ejecutar = mysqli_query($con, $insertar);

      	if ($ejecutar) {   
      		echo "<h2> El Administrador de la empresa se ha ingresado correctamente</h3>";
      		# code...
      	}
      }
      ?>

      <h4 class="p-4">Ver lista de administradores de empresa</h4>
      <table class="table table-striped table-bordered table-hover table-sm table-responsiv">
      <thead align= "center">  
        <th>id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>mail</th>
        <th>rol</th>
        <th>password</th>
        <th>Opción</th>
      </thead>
<?php

$consulta = "SELECT * FROM login where rol='1'";
$ejecutar = mysqli_query ($con, $consulta);

$i=0;
 

while ($fila = mysqli_fetch_array($ejecutar)){
 $id = $fila['id'];
 $nombre = $fila ['nombre'];
 $apellido = $fila ['apellido'];
 $mail = $fila ['user'];
 $rol = $fila ['rol'];
 $contrasena = $fila ['passadmin'];


 $i++;
?>


	<tr align= "center">
		<td> <?php echo $id; ?></td>
		<td> <?php echo $nombre; ?></td>
		<td> <?php echo $apellido; ?></td>
		<td> <?php echo $mail; ?></td>
    <td> <?php echo $rol; ?></td>
    <td> <?php echo $contrasena; ?></td>
    <td> <a class="btn btn-warning btn-sm text-white" href="adminsis.php?editar1=<?php echo $id; ?>">EDITAR</a></td>
        

</tr>

<?php 
} ?>
<?php 
if (isset($_GET['editar1'])) {
	include ("editar1.php");
	# code...
}
?>
</table>

    </div>
  </div>




</body>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
  crossorigin="anonymous"></script>
</html>