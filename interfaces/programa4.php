<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

// LAs siguientes son l�neas de c�digo HTML simple, para crear una p�gina web
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> DATOS MAXIMOS DEL VEHÍCULO
		  </title>
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div>
    <h1>datos máximos</h1>
    </div>
      <table class="tablafechas" align=center>
      <tbody>

<?php

if ((isset($_POST["enviado"])))  // Ingresa a este if si el formulario ha sido enviado..., al ingresar actualiza los datos ingresados en el formulario, en la base de datos.
{
  $enviado = $_POST["enviado"];
  if ($enviado == "S1")
  {
    $temp_max = $_POST["temp_max"];  // en estas variables se almacenan los datos de fechas recibidos del formulario HTML inicial
    $hum_max = $_POST["hum_max"];
    $mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
    // la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. 
    // se actualiza la tabla de valores m�ximos
    $sql1 = "UPDATE datos_maximos set maximo='$temp_max' where id=1";  
    // la siguiente l�nea ejecuta la consulta guardada en la variable sql1, con ayuda del objeto de conexi�n a la base de datos mysqli
    $result1 = $mysqli->query($sql1);
    
    $sql2 = "UPDATE datos_maximos set maximo='$hum_max' where id=2"; 
    // la siguiente l�nea ejecuta la consulta guardada en la variable sql1, con ayuda del objeto de conexi�n a la base de datos mysqli
    $result2 = $mysqli->query($sql2);
    
    if (($result1 == 1)&&($result2 == 1))
    $mensaje = "Datos actualizados correctamente";
    else
    $mensaje = "Inconveniente actualizando datos";
    
    header('Location: programa4.php?mensaje='.$mensaje);
    
  } // FIN DEL IF, si ya se han recibido los datos del formulario
}  // FIN DEL IF, si la variable enviado existe, que es cuando ya se env�o el formulario

// AQUI CONSULTA LOS VALORES ACTUALES DE HUMEDAD y TEMPERATURA, PARA PRESENTARLOS EN EL FORMULARIO

// CONSULTA TEMPERATURA MAXIMA
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
$sql1 = "SELECT * from datos_maximos where id=1"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
$row1 = $result1->fetch_array(MYSQLI_NUM);
$temp_max = $row1[3];  

// CONSULTA HUMEDAD MAXIMA
$sql2 = "SELECT * from datos_maximos where id=2"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result2 = $mysqli->query($sql2);
$row2 = $result2->fetch_array(MYSQLI_NUM);
$hum_max = $row2[3];  

if ((isset($_GET["mensaje"])))
{
  $mensaje = $_GET["mensaje"];
  echo '<tr>	
  <td bgcolor="#EEEEFF" align=center colspan=2> 
  <font FACE="arial" SIZE=2 color="#000044"> <b>'.$mensaje.'</b></font>  
  </td>	
  </tr>';
}
?>    

     <form method=POST action="programa4.php">
 	     <tr>	
      		<td  align=center> 
			   	  <font FACE="arial" SIZE=2 color="#000044"> <b>Valor Máximo Temperatura: </b></font>  
				  </td>	
				  <td  align=center> 
				    <input type="number" name="temp_max" value="<?php echo $temp_max; ?>" required>  
          </td>	
	     </tr>
 	     <tr>	
      		<td align=center> 
			   	  <font FACE="arial" SIZE=2 color="#000044"> <b>Valor Máximo Humedad: </b></font>  
				  </td>	
				  <td align=center> 
				    <input type="number" name="hum_max" value="<?php echo $hum_max; ?>" required>  
          </td>	
	     </tr>
       <tr>	
				  <td  align=center colspan=2> 
				    <input type="hidden" name="enviado" value="S1">  
				    <input class="button" type="submit" value="Actualizar" name="Actualizar">  
          </td>	
	     </tr>
      </form>	  

        </tbody>
       </table>
     </body>
   </html>