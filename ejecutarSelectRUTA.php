<?php
    require("db_config.php");

    $arreglo[][]="";
    $i=0;
    $sql = "SELECT rutId AS ID, rutNombre AS Nombre, rutNombreCorto AS NomCorto, rutDescripcion AS Descripcion, rutEstado AS Estado, rutFechaCreacion AS FechaCreacion FROM ruta";
    // ejecutar una multi consulta 
    if ($mbd->multi_query($sql)) {
        do {
            // primero almacenar el conjunto de resultados
            if ($resultado = $mbd->use_result()) {
                // Al usar MYSQLI_BOTH las columnas se duplican por que trae cada atributos con 2 etiquetas.
                // MYSQLI_BOTH: nombre, número. MYSQLI_ASSOC: nombre. MYSQLI_NUM: numero.
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    $tamañoColumnas = count($fila,0)/1;
                    $arreglo[$i] = $fila;
                    $i++;
                }
                $tamañoFilas = mysqli_num_rows($resultado);
                $resultado->close();
            }
            /* imprimir un separador
            if ($mbd->more_results()) {
                printf("-----------------\n");
            }*/
        } while ($mbd->next_result());
    }
    else {
        echo "Error: " . $mbd->error . "<br>";
    }
    //var_dump($arreglo);
    
    /*echo "Tamaños: filas " . $tamañoFilas . ", columnas " . $tamañoColumnas;
    echo "<br>";*/

    /*// Si ésta funcion no está activa, al llamar al required("data.php"), se tendrá el array para darle manejo.
    // Es decir, no estará "impreso" al ejecutar el php.
    // Esta función la usamos para ver de qué forma devolvió los datos la consulta.
    var_dump($arreglo);*/
    
    /*for($x=0;$x<$tamañoFilas;$x++)
        for($y=0;$y<$tamañoColumnas;$y++)
            echo $arreglo[$x][$y] . "<br>";*/

    mysqli_close($mbd);
?>