







<?php
$hostDb="localhost";
$nombreDb="sistransporte";
$usuario="root";
$clave="";
$conexion=mysqli_connect($hostDb, $usuario, $clave ,$nombreDb);
if (!$conexion){//Solo si no se conect? a la Bd
  echo "Error al conectar a la Base de datos";
  exit();

}
else { echo "conectado"; 

//$conexion=mysqli_connect('localhost','root','','ultima');
}?>
<!DOCTYPE html>
<html>

<head>
    <title>Registrate</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css" />

</head>

<body>
    <!-- Header -->
    <header id="header">
        <h1>
            <a href="index.php">MovePopayán</a>
        </h1>
        <nav id="nav">
            <ul>
                <li class="special">
                    <a href="#menu" class="menuToggle">
                        <span>Menu</span>
                    </a>
                    <div id="menu">
                        <ul>
                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <!-- <li><a href="generic.html">Generic</a></li> -->
                            <!-- <li><a href="elements.html">Elements</a></li> -->
                            <li>
                                <a href="registrarse.php">Registrarse</a>
                            </li>
                            <li>
                                <a href="login.php">Iniciar sesión</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </header>


    <div class="divform">

        <div class="form">
            <h3>Regístrate</h3>
            <form action="" method="post">

                <!--  -->
                <div class="row uniform">
                    <div class="6u 12u$(xsmall)">
                        <input required type="text" name="nombre" id="demo-name" value="" placeholder="Nombre" />
                    </div>
                    <div class="6u$ 12u$(xsmall)">
                        <input required type="text"  name="apellido" id="apellido" value="" placeholder="Apellidos" />
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <input required type=email name="demo-email" id="demo-email" value="" placeholder="Email" />
                    </div>
                    <div class="12u$ 12u$(xsmall)">
                        <input required type="password" name="password" id="password" value="" placeholder="Contraseña" />
                    </div>

                    <div class="12u$ 12u$(xsmall)">
                        <!-- Para Sprint3 -->
                        <!-- <input required type="password" id="password-confirm" value="" placeholder="Confirmar contraseña" /> -->
                    </div>
                    <div>
                        <input class="special mybtn" type="submit" name= "submit" value="registrar">
                        <input id="mybtn" type="reset" value="limpiar">
                    </div>
 <?php
        if(isset($_POST['submit'])){
            require("registro.php");
        }
    ?>
                </div>
            </form>
           
   
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
    <script src="assets/js/main.js"></script>
</body>

</html>




 
