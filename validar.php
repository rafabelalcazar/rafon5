<?php
//include("connect_db.php");

//$miconexion = new connect_db;


    $username=$_POST['log'];
	$pass=$_POST['pass'];
	$pass1=md5($pass);
session_start();
require("conexiondb.php");
	//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
	$sql2=mysqli_query($mysqli,"SELECT * FROM login WHERE user LIKE'$username'");
	if($f2=mysqli_fetch_assoc($sql2)){
		if($pass1==$f2['passadmin']){
			$_SESSION['id']=$f2['id'];
			$_SESSION['nombre']=$f2['nombre'];
			$_SESSION['apellido']=$f2['apellido'];
			$_SESSION['rol']=$f2['rol'];
			$_SESSION['estado']=$f2['estado'];
			if ($_SESSION['estado']==1)
			{
				if ($_SESSION['rol']==1)
			{

			echo '<script>alert("BIENVENIDO ADMINISTRADOR")</script> ';
			echo "<script>location.href='adminempresa1.php'</script>";
			}
			if($_SESSION['rol']==2)
				{

			echo '<script>alert("BIENVENIDO USUARIO")</script> ';
			echo "<script>location.href='usuario.php'</script>";
			}

            if($_SESSION['rol']==3)
				{

			echo '<script>alert("BIENVENIDO USUARIO")</script> ';
			echo "<script>location.href='adminsis.php'</script>";
			}


			else{ 
			echo '<script>alert("NO TIENES PERMISO DE ADMINISTRADOR")</script> ';}
			}
			else{ 
			echo '<script>alert("USUARIO INACTIVO CONTACTE CON SU ADMINISTRADOR")</script> ';
			echo "<script>location.href='index.php'</script>";}
				
		}
		else{
			echo '<script>alert("CONTRASEÑA INCORRECTA")</script> ';
		
			echo "<script>location.href='index.php'</script>";
		}
	}else{
		
		echo '<script>alert("ESTE USUARIO NO EXISTE, PORFAVOR REGISTRESE PARA PODER INGRESAR")</script> ';
		
		echo "<script>location.href='index.php'</script>";
	}


	
?>