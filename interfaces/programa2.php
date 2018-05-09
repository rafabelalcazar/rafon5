<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.

// LAs siguientes son l�neas de c�digo HTML simple, para crear una p�gina web
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> ULTIMOS datos registrados en el automovil
		  </title>
      <meta http-equiv="refresh" content="15" />
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <div class="cabecera">
        <h1>Últimos datos medidos</h1>
      </div>
      <table class="mytable"  align="center">
        <thead>
              <tr>
                <td class="headt" valign="top" align=center>
                    <b>N°</b>
                </td>
                <td class="headt" valign="top" align=center>
                    <b>Id de la Tarjeta</b>
                </td>
                <td class="headt" valign="top" align=center>
                    <b>Fecha</b>
                </td>
                <td class="headt" valign="top" align=center>
                    <b>Hora</b>
                </td>
                <td class="headt" valign="top" align=center>
                    <b>Temperatura</b>
                </td>
                <td class="headt" valign="top" align=center>
                    <b>Humedad</b>
                </td>
              </tr>

        </thead>
<?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from datos_medidos where ID_TARJ=1 order by id DESC LIMIT 5"; // Aqu� se guarda en la variable sql la sentencia de consulta a realizar
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
// la siguiente linea es el inicio de un ciclo while, que se ejecuta siempre que la respuesta a la consulta de la base de datos
// tenga alg�n registro resultante. Como la consulta arroja 5 resultados, los �ltimos que tenga la tabla, se ejecutar� 5 veces el siguiente ciclo while.
// el resultado de cada registro de la tabla, se almacena en el arreglo row, row[0] tiene el dato del 1er campo de la tabla, row[1] tiene el dato del 2o campo de la tabla, as� sucesivamente
$contador = 0;
while($row1 = $result1->fetch_array(MYSQLI_NUM))
{
 $temp = $row1[2];
 $hum = $row1[3];
 $fecha = $row1[4];
 $hora = $row1[5];
 $ID_TARJ = 1;
 $contador++;
?>
    	 <tr>
         <td valign="top" align=center>
           <?php echo $contador; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $ID_TARJ; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $fecha; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hora; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $temp." ºC"; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hum." %"; ?> 
         </td>
 	     </tr>
<?php
}
?>
       </table>
     </body>
   </html>