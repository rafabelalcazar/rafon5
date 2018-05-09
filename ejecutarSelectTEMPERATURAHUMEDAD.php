<?php
    require("db_config.php");

    $arreglo[][]="";
    $i=0;
    $sql="SELECT temperatura, humedad FROM datos_medidos LIMIT 50;";

    if ($mbd->multi_query($sql)) {
        do {
            // primero almacenar el conjunto de resultados
            if ($resultado = $mbd->use_result()) {
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    $tamañoColumnas = count($fila,0)/1;
                    $arreglo[$i] = $fila;
                    $i++;
                }
                $tamañoFilas = mysqli_num_rows($resultado);
                $resultado->close();
            }
        } while($mbd->next_result());
    }
    else
        echo "Error: " . $mbs->error . "<br>";
    
    mysqli_close($mbd);
?>