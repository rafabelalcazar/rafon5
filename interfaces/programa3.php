<?php
include "conexion.php";  // Conexi�n tiene la informaci�n sobre la conexi�n de la base de datos.

// LAs siguientes son l�neas de c�digo HTML simple, para crear una p�gina web
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title>Consulta datos</title>
      <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <div>
        <h1>consulta de datos medidos</h1>
      </div>
      <table class="tablafechas" align=center >
        <thead>

        </thead>

        <tbody>
            
          
          
          <?php

if ((isset($_POST["enviado"])))
{
  $enviado = $_POST["enviado"];
  if ($enviado == "S1")
  {
    $fecha_ini = $_POST["fecha_ini"];  // en estas variables se almacenan los datos de fechas recibidos del formulario HTML inicial
    $fecha_fin = $_POST["fecha_fin"];
    $mysqli = new mysqli($host, $user, $pw, $db); // Aqu� se hace la conexi�n a la base de datos.
    ?>
    	 <tr>
         <td valign="top" align=center colspan=6>
           <b>Rango de fechas consultado: desde <?php echo $fecha_ini; ?> hasta <?php echo $fecha_fin; ?></b>
          </td>
        </tr>
        <tr>
          <td valign="top" align=center>
            <b>#</b>
          </td>
          <td valign="top" align=center>
            <b>Id de la Tarjeta</b>
          </td>
          <td valign="top" align=center>
            <b>Fecha</b>
          </td>
          <td valign="top" align=center>
            <b>Hora</b>
          </td>
          <td valign="top" align=center>
            <b>Temperatura</b>
          </td>
          <td valign="top" align=center>
            <b>Humedad</b>
          </td>
 	     </tr>
        <?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from datos_medidos where ID_TARJ=1 and fecha >= '$fecha_ini' and fecha <= '$fecha_fin' order by fecha"; 
// la siguiente l�nea ejecuta la consulta guardada en la variable sql, con ayuda del objeto de conexi�n a la base de datos mysqli
$result1 = $mysqli->query($sql1);
// la siguiente linea es el inicio de un ciclo while, que se ejecuta siempre que la respuesta a la consulta de la base de datos
// tenga alg�n registro resultante. Como la consulta arroja X resultados, se ejecutar� X veces el siguiente ciclo while.
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
}  // FIN DEL WHILE
echo '
<tr>	
<form method=POST action="programa3.php">
<td bgcolor="#EEEEEE" align=center colspan=6> 
<input type="submit" value="Volver" name="Volver">  
</td>	
</form>	
</tr>';


} // FIN DEL IF, si ya se han recibido las fechas del formulario
}  // FIN DEL IF, si la variable enviado existe, que es cuando ya se env�o el formulario
else
{
  ?>    
     <form method=POST action="programa3.php">
       <tr>	
         <td  align=center> 
           <font FACE="arial" SIZE=2 > <b>Fecha Inicial:</b></font>  
				  </td>	
				  <td  align=center> 
            <input type="date" name="fecha_ini" value="" required>  
          </td>	
        </tr>
 	     <tr>	
          <td  align=center> 
            <font FACE="arial" SIZE=2 > <b>Fecha Final:</b></font>  
				  </td>	
				  <td  align=center> 
            <input type="date" name="fecha_fin" value="" required>  
          </td>	
        </tr>
        <tr>	
          <td  align=center colspan=2> 
            <input class="button"type="hidden" name="enviado" value="S1">  
				    <input class="button" type="submit" value="Consultar" name="Consultar">  
          </td>	
        </tr>
      </form>	  
      
      <?php
    } 
    ?>    

          </tbody>
       </table>

      </body>
      <footer>
      <div class="divfoot">
      <p>
           Selecciona el rango de fechas para realizar la Consulta
         </p>
      </div>
      </footer>
   </html>