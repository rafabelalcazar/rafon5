<?php
include "conexion.php";  // Conexión tiene la información sobre la conexión de la base de datos.
$mysqli = new mysqli($host, $user, $pw, $db); // Aquí se hace la conexión a la base de datos.

// LAs siguientes son líneas de código HTML simple, para crear una página web
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 	Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
    <head>
      <title> Datos Generales
		  </title>
      <meta http-equiv="refresh" content="15" />
      <link rel="stylesheet" href="css/style.css">
      
    </head>
    <body>
      <div class="cabecera">
        <h1>Conteo de pasajeros</h1>

      </div>
      <table align=center class="mytable">
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
               <b>Pasajeros que entran</b>
            </td>
            <td class="headt" valign="top" align=center>
               <b>Pasajeros que salen</b>
            </td>
           </tr>
        </thead>

<?php
// la siguiente linea almacena en una variable denominada sql1, la consulta en lenguaje SQL que quiero realizar a la base de datos. Se consultan los datos de la tarjeta 1, porque en la tabla puede haber datos de diferentes tarjetas.
$sql1 = "SELECT * from datos_medidos where ID_TARJ=1 order by id DESC LIMIT 7"; // Aquí se guarda en la variable sql la sentencia de consulta a realizar
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
  
// $temp = $row1[2];
//  $hum = $row1[3];
 $fecha = $row1[4];
 $hora = $row1[5];
 $sube = $row1[6];
 $baja= $row1[7];
 $ID_TARJ = 1;
 $contador++;
 $totalsuben=$totalsuben+$sube;
 $totalbajan=$totalbajan+$baja;


?>
    	 <tr>
        </td>
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
         <!-- <td valign="top" align=center>
           <?php echo $temp." ºC"; ?> 
         </td>
         <td valign="top" align=center>
           <?php echo $hum." %"; ?> 
         </td> -->

         <td valign="top" align=center>
           <?php echo $sube; ?> 
         </td>
          <td valign="top" align=center>
           <?php echo $baja; ?> 
         
               
        </tr>
        
<?php
}
?>
       </table>
       <?php 
        $totalsuben=$totalsuben+$sube;
        $totalbajan=$totalbajan+$baja;
        $abordo = $totalsuben - $totalbajan;
       echo "Hay " .$abordo. " pasajeros en el vehiculo"; ?>  
     </body>
   </html>