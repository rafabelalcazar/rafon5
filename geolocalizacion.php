<!-- CARGA LAS RUTAS DE LA BASE DE DATOS, LAS MUESTRA EN UNA TABLA EN EL FLOATING-CONTENT Y EN EL MAPA. -->
<!-- PERMITE HACER UPDATE (aún en el floating-panel-1) DE UNA RUTA ESCOGIDA DE LA TABLA, Y DE SUS RESPECTIVOS MARCADORES -->
<!-- AL HACER SELECCIONAR (UNA RUTA) PARA UPDATE, TRAE LA RUTA CON SUS RESPECTIVOS MARCADORES.-->
<!-- CREA UNA RUTA POR DEFECTO Y LA MUESTRA, TAMBIEN ELIMINA CUALQUIER RUTA CON SEGURIDAD, FULL FULL -->
<!-- LOS ALERT SE USAN PARA MONITOREAR EL ESTADO DE LAS VARIABLES GLOBALES waypts, posicionOrigen, posicionDestino -->
<!-- SE ESTÁ IMPRIMIENTO EN UNA VENTANA alert TODOS LOS WayPoints AL ARASTRAR Y MODIFICAR LA RUTA -->
<!-- Usa ejecutarSelectRUTA.php, db_config.php y estilo-v3.3.css. Base de datos: move-popayan-->
<!-- estilo-v3.3.css SE AJUSTÓ COMPLETAMENTE, SE HIZO DEPURACIÓN, Y AJUSTE DE TODAS LAS FUNCIONALIDADES (MARCADORES, ETC.) -->

<!DOCTYPE html>
<html lang="en">


<head>
    <title>v4.2 Geolocalización del Usuario</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="./css/estilo-v3.3.css"/>
</head>


<body>
    <div id="floating-panel-1">
        <div id="barra-herramientas">
            <img src="icon/icons8-forgot-password-16.png" alt="key-icono" id="key-icono">
        </div><!--#sesion-activa-->
        <div id="cerrar-sesion">
            <a href="#">Cerrar Sesión</a>
        </div><!--#cerrar-sesion-->
        <br>
        <img src="icon/icons8-user-male-30.png" alt="icono-user">
        <h2>Administración Empresa</h2>
        <p>Bienvenido, Andrés<?php ?>.</p>
        <br>
        <b>Modo de viaje: </b>
        <select id="modoViaje">
            <option value="DRIVING">Driving (Conducción)</option>
        </select>
        <br><br>
        <button id="vamos">Vamos!</button>&ensp;
        <button onclick="reiniciarMapa()">Reinicia mapa</button>&ensp;
        <button onclick="guardarRuta()">Guardar Ruta</button>
        <br><br><br><br>
        <div id="contenedor-rutas">
            <section id="seccion-tabla-rutas">
                <table class=tabla id="tabla-rutas">
                    <caption>R&ensp;&ensp;U&ensp;&ensp;T&ensp;&ensp;A&ensp;&ensp;S</caption>
                    <?php
                        include('ejecutarSelectRUTA.php');
                        echo "<thead>";
                        for($x=0;$x<$tamañoColumnas;$x++){
                            $metadatos = array_keys($arreglo[0]);
                            echo "<th>" . $metadatos[$x] . "</th>";
                        }
                        echo "</thead>";
                        echo "<tbody style=" . "cursor:pointer" . ">";
                        for($x=0;$x<$tamañoFilas;$x++){
                            echo "<tr>";
                                echo "<td>" . $arreglo[$x][$metadatos[0]] . "</td>";
                                echo "<td>" . $arreglo[$x][$metadatos[1]] . "</td>";
                                echo "<td>" . $arreglo[$x][$metadatos[2]] . "</td>";
                                echo "<td>" . $arreglo[$x][$metadatos[3]] . "</td>";
                                echo "<td>" . $arreglo[$x][$metadatos[4]] . "</td>";
                                echo "<td>" . $arreglo[$x][$metadatos[5]] . "</td>";
                                echo "<td><a href='geolocalizacion-v4.2.php?rutId=" . $arreglo[$x]['ID'] . "'>e</td>";
                                echo "<td><a href='geolocalizacion-v4.2.php?rutId=" . $arreglo[$x]['ID'] . "&banderaEliminar=1'>x</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                    ?>
                </table>
            </section><!--#seccion-tabla-rutas-->
        </div><!--#contenedor-rutas-->
        
        <div id="gestion-rutas">
            <img src="icon/icons8-i-am-here-48.png" alt="hello-icon-page">
            <?php 
                if (isset($_GET['rutId'])){
                    $rutIdEditar = $_GET['rutId'];
                    // Recupera los datos -de la base de datos-, respectivos, a la ruta y sus marcadores.
                    $sql = "SELECT r.rutId AS ID, rutNombre AS Nombre, rutNombreCorto AS NomCorto, rutDescripcion AS Descripcion, rutEstado AS Estado, rutFechaCreacion AS FechaCreacion, marcId AS IDMarc, marcOrden AS Orden, marcLatitud AS Latitud, marcLongitud AS Longitud FROM ruta r , marcadorWayPoint m WHERE r.rutId = m.rutId AND r.rutId = " . $rutIdEditar;
                    
                    require("db_config.php");
                    $arreglo[][]="";
                    $i=0;
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
                    else
                        echo "Error: " . $mbd->error . "<br>";
                    
                    mysqli_close($mbd);
                    
                    for($x=0;$x<$tamañoColumnas;$x++)
                        $metadatos = array_keys($arreglo[0]);
                    
                    unset($tamañoColumnas);
                    $tamañoColumnas="";
                    //var_dump($tamañoColumnas);

                    echo "<script>posicionOrigen = {lat: " . $arreglo[0]["Latitud"] . ", lng: " . $arreglo[0]["Longitud"] . "};</script>";
            
                    echo "<script>posicionDestino = {lat: " . $arreglo[$tamañoFilas-1]["Latitud"] . ", lng: " . $arreglo[$tamañoFilas-1]["Longitud"] . "};</script>";
                    
                    echo "<script>var waypts = [];";
                    for ($z = 1; $z < $tamañoFilas-1; $z++)
                        echo "waypts.push({location: {lat:" . $arreglo[$z]["Latitud"] . ", lng:" . $arreglo[$z]["Longitud"] . "}, stopover: false});";
                    echo "</script>";
                    
                    unset($tamañoFilas);
                    $tamañoFilas="";
                    //var_dump($tamañoFilas);
                    
                    //echo "<script>alert(posicionOrigen.lat + ', ' + posicionDestino.lng + ', ' + waypts[0].lat);</script>";
                    //echo "<script>alert(JSON.stringify(waypts, null));</script>";
                    //echo "<script>alert(JSON.stringify(posicionOrigen, null));</script>";
                }

                // Si se va a eliminar, consulta todos los marcadores pertenecientes al ID de ruta escogido.
                if (isset($_GET['rutId']) && isset($_GET['banderaEliminar'])){
                    $rutIdEditar = $_GET['rutId'];
                    // Recupera los datos -de la base de datos-, respectivos, a la ruta y sus marcadores.
                    $sql = "SELECT r.rutId AS ID, rutNombreCorto AS NomCorto, rutEstado AS Estado, rutFechaCreacion AS FechaCreacion, marcId AS IDMarc, marcOrden AS Orden FROM ruta r , marcadorWayPoint m WHERE r.rutId = m.rutId AND r.rutId = " . $rutIdEditar;
                    
                    require("db_config.php");
                    $arreglo[][]="";
                    $i=0;
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
                    else
                        echo "Error: " . $mbd->error . "<br>";
                    // Comprueba que los marcadores a eliminar sean todos los disponibles
                    mysqli_close($mbd);
                    
                    // Consulta todos los marcadores, con las ID correspondientes, para contarlos.
                    $i=0;
                    for($x=0;$x<$tamañoFilas;$x++){
                        $sql="SELECT * FROM marcadorWayPoint WHERE marcId=" . $arreglo[$x]["IDMarc"] . ";";
                        //echo $sql;
                        require("db_config.php");
                        if ($mbd->multi_query($sql))
                            $i++;
                            //echo $i;
                        else
                            echo "Error: " . $mbd->error . "<br>";
                    }
                    $rest = $arreglo[$tamañoFilas-1]["IDMarc"]-$arreglo[0]["IDMarc"]+1;
                    //echo $i . ", se elmina con: " . $rest;

                    if($rest==$i && !isset($_GET['confirmacionEliminar'])){
                        //echo "Si se da ";
                        //echo "<script>eliminarConfirmacion();</script>";
                        echo "<script>var opcion = confirm('¿Seguro desea eliminar la ruta?');if (opcion == true) {window.open('geolocalizacion-v4.2.php?rutId=" . $rutIdEditar . "&banderaEliminar=1&confirmacionEliminar=1', '_self');} else {window.open('geolocalizacion-v4.2.php?rutId=" . $rutIdEditar . "&banderaEliminar=1&confirmacionEliminar=0', '_self');}</script>";
                        //echo $confirm;
                    }
                    
                    // Si la función anterior es "true", procede a eliminar.
                    if($_GET['confirmacionEliminar']==1) {
                        $y=0;
                        for($x=0;$x<$tamañoFilas;$x++){
                            $sql="DELETE FROM marcadorWayPoint WHERE marcID=" . $arreglo[$x]["IDMarc"] . ";";
                            //echo $sql;
                            require("db_config.php");
                            if ($mbd->multi_query($sql))
                                $y++;
                                //echo $i;
                            else
                                echo "Error: " . $mbd->error . "<br>";
                        }
                        $sql="DELETE FROM ruta WHERE rutID=" . $arreglo[0]["ID"] . ";";
                        //echo $sql;
                        if ($mbd->multi_query($sql)){
                            echo "<script> alert ('" . $y . " marcadores eliminados. Ruta eliminada.')</script>";
                            echo "<script> window.open('geolocalizacion-v4.2.php?', '_self')</script>";
                        }
                        else
                            echo "Error: " . $mbd->error . "<br>";
                    }
                    if($_GET['confirmacionEliminar']==0) {
                        
                            //echo "<script> alert ('No se eliminaron todos los marcadores.')</script>";
                            //echo "<script> window.open('geolocalizacion-v4.2.php?', '_self')</script>";
                            echo "<script> alert ('Proceso abortado.')</script>";
                            echo "<script> window.open('geolocalizacion-v4.2.php?', '_self')</script>";
                    
                        
                    }


                    
                    /*if($arreglo[$tamañoFilas-1]["IDMarc"]-$arreglo[0]["IDMarc"]+1==$i){
                        $sql="DELETE FROM ruta WHERE rutID=" . $arreglo[0]["ID"] . ";";
                        //echo $sql;
                        if ($mbd->multi_query($sql)){
                            echo "<script> alert ('Ruta eliminada.')</script>";
                            echo "<script> window.open('geolocalizacion-v4.2.php?', '_self')</script>";
                        }
                        else
                            echo "Error: " . $mbd->error . "<br>";
                    }
                    else
                        echo "<script> alert ('No se eliminaron todos los marcadores.')</script>";*/
                }

            ?>
            <br>

            <br>
            <!-- Utiliza los datos recogidos de las Rutas, y los refleja en los textfiles. -->
            <form method="post" id="formulario-update-ruta">
                <label for="<?php echo $metadatos[0]; ?>"><?php echo $metadatos[0] . ":";?>&ensp;&ensp;</label>
                <input type="text" id="<?php echo $metadatos[0]; ?>" name="<?php echo $metadatos[0]; ?>" value="<?php echo $arreglo[0][$metadatos[0]]; ?>" readonly="readonly"><br>
                <label for="<?php echo $metadatos[1]; ?>"><?php echo $metadatos[1] . ":";?>&ensp;&ensp;</label>
                <input type="text" id="<?php echo $metadatos[1]; ?>" name="<?php echo $metadatos[1]; ?>" value="<?php echo $arreglo[0][$metadatos[1]]; ?>"><br>
                <label for="<?php echo $metadatos[2]; ?>"><?php echo $metadatos[2] . ":";?>&ensp;&ensp;</label>
                <input type="text" id="<?php echo $metadatos[2]; ?>" name="<?php echo $metadatos[2]; ?>" value="<?php echo $arreglo[0][$metadatos[2]]; ?>"><br>
                <label for="<?php echo $metadatos[3]; ?>"><?php echo $metadatos[3] . ":";?>&ensp;&ensp;</label>
                <input type="text" id="<?php echo $metadatos[3]; ?>" name="<?php echo $metadatos[3]; ?>" value="<?php echo $arreglo[0][$metadatos[3]]; ?>"><br>
                <label for="<?php echo $metadatos[4]; ?>"><?php echo $metadatos[4] . ":";?>&ensp;&ensp;</label>
                <input type="text" id="<?php echo $metadatos[4]; ?>" name="<?php echo $metadatos[4]; ?>" value="<?php echo $arreglo[0][$metadatos[4]]; ?>"><br>
                <label for="<?php echo $metadatos[5]; ?>"><?php echo $metadatos[5] . ":";?>&ensp;&ensp;</label>
                <input type="date" id="<?php echo $metadatos[5]; ?>" name="<?php echo $metadatos[5]; ?>" value="<?php echo $arreglo[0][$metadatos[5]];  ?>" readonly="readonly"><br>
                <input type="checkbox" id="editaMarcadores" name="editaMarcadores" value='true'> ¿Editar Marcadores?
                <!-- input text invisibles para segmentar el Objeto '$pointsArray' extraido de la funcion 'result.routes[0].overview_path;' -->
                <!-- <input type='text' id='marcadores-text-tamaño' name='marcadores-text-tamaño'><br> -->
                <input type='hidden' id='marcadores-text-lat' name='marcadores-text-lat'>
                <input type='hidden' id='marcadores-text-lng' name='marcadores-text-lng'>
                <br>
                    
                <br><br>
                <input type="submit" name="actualizarRuta" onclick="computeTotalDistance(directionsDisplay.getDirections())" value="Actualizar Información de la Ruta">&ensp;&ensp;
                <input type="submit" name="crearRuta" id="crearRuta"  value="Crea una nueva Ruta!">
            </form><!--#formulario-update-ruta-->

            <?php
                //var_dump($arreglo);
                unset($arreglo);
                $arreglo[][]="";
                //echo "<br><br>";
                //var_dump($arreglo);

                //******CREAR RUTA**********
                if(isset($_POST['crearRuta'])){
                    require("db_config.php");
                    // Consulta el último ID de los elementos de las rutas, y crea el objeto justo en el siguiente.
                    $sql = "SELECT MAX(rutId) FROM ruta";
                    $i=0;
                    if ($mbd->multi_query($sql)) {
                        do {
                            // primero almacenar el conjunto de resultados
                            if ($resultado = $mbd->use_result()) {
                                // Al usar MYSQLI_BOTH las columnas se duplican por que trae cada atributos con 2 etiquetas.
                                // MYSQLI_BOTH: nombre, número. MYSQLI_ASSOC: nombre. MYSQLI_NUM: numero.
                                while ($fila = $resultado->fetch_array(MYSQLI_NUM)) {
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
                    else
                        echo "Error: " . $mbd->error . "<br>";
                    
                    //mysqli_close($mbd);

                    unset($tamañoColumnas);
                    $tamañoColumnas="";
                    unset($tamañoColumnas);
                    $tamañoFilas="";
                    $rutId=$arreglo[0][0]+1;
                    unset($arreglo);
                    $arreglo[][]="";
                    

                    // ********* Inserta la nueva Ruta ***********
                    date_default_timezone_set("America/Bogota");
                    $sql1 = "INSERT INTO ruta VALUES (" . $rutId . ", 'Ruta #', 'R#', 'Añada una descripción', 'disponible', '" . date("Y-m-d H:i:s") . "');";
                    //echo $sql;
                    
                    require("db_config.php");
                    if ($mbd->multi_query($sql1)){
                        $marcadorId = $rutId * 100;

                        //********* Inserta los marcadores de la nueva Ruta ***********
                        $sql2 = "INSERT INTO marcadorWayPoint VALUES (" . ($marcadorId + 0) . "," . 1 . ",2.44354,-76.6013199," . $rutId . "); INSERT INTO marcadorWayPoint VALUES (" . ($marcadorId + 1) . "," . 2 . ",2.440895,-76.606534," . $rutId . "); INSERT INTO marcadorWayPoint VALUES (" . ($marcadorId + 2) . "," . 3 . ",2.441985,-76.606434," . $rutId . ");";
                        echo $sql1;
                        require("db_config.php");
                        if ($mbd->multi_query($sql2)){
                            //if($x==2){
                                echo "<script> alert ('Ruta creada.')</script>";
                                echo "<script> window.open('geolocalizacion-v4.2.php?rutId=" . $rutId . "', '_self')</script>";
                                $rutId = 0;
                            //}
                        }
                        else
                            echo "Error: " . $mbd->error . "<br>";
                    }
                    else
                        echo "Error: " . $mbd->error . "<br>";
                    mysqli_close($mbd);

                    

                    

                    
                    //require("db_config.php");
                    //if ($mbd->multi_query($sql)){
                        //echo "<script> alert ('Ruta creada.')</script>";
                        //echo "<script> window.open('geolocalizacion-v4.2.php?rutId=" . $rutId . "', '_self')</script>";
                    //}
                    //else
                        //echo "Error: " . $mbd->error . "<br>";

                    //mysqli_close($mbd);

                    










                }
                //******ACTUALIZAR RUTA**********
                if(isset($_POST['actualizarRuta'])){
                    $rutIdEditar = $_POST[$metadatos[0]];
                    $actualizar_rutNombre = $_POST[$metadatos[1]];
                    $actualizar_rutNombreCorto = $_POST[$metadatos[2]];
                    $actualizar_rutDescripcion = $_POST[$metadatos[3]];
                    $actualizar_rutEstado = $_POST[$metadatos[4]];
                    $actualizar_rutFechaCreacion = $_POST[$metadatos[5]];
                    $actualizar_marcadores = "";
                    $actualizar_marcadoresLat = $_POST['marcadores-text-lat'];
                    $actualizar_marcadoresLng = $_POST['marcadores-text-lng'];
                    if(isset($_POST['editaMarcadores']))
                        $actualizar_marcadores = $_POST['editaMarcadores'];

                    unset($metadatos);
                    $metadatos[][]="";
                    //var_dump($metadatos);

                    if($actualizar_marcadores == 'true') {
                        require("db_config.php");
                        // Recupera los datos -de la base de datos-, respectivos, a la ruta y sus marcadores.
                        $sql = "SELECT marcId FROM ruta r , marcadorWayPoint m WHERE r.rutId = m.rutId AND r.rutId = " . $rutIdEditar;
                        $i=0;
                        if ($mbd->multi_query($sql)) {
                            do {
                                // primero almacenar el conjunto de resultados
                                if ($resultado = $mbd->use_result()) {
                                    // Al usar MYSQLI_BOTH las columnas se duplican por que trae cada atributos con 2 etiquetas.
                                    // MYSQLI_BOTH: nombre, número. MYSQLI_ASSOC: nombre. MYSQLI_NUM: numero.
                                    while ($fila = $resultado->fetch_array(MYSQLI_NUM)) {
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
                        else
                            echo "Error: " . $mbd->error . "<br>";
                        //mysqli_close($mbd);

                        unset($tamañoColumnas);
                        $tamañoColumnas="";
                        unset($tamañoColumnas);
                        $tamañoFilas="";
                        //var_dump($tamañoColumnas);
                        //var_dump($tamañoFilas);
                        //echo "<br><br>";
                        
                        //var_dump($arreglo);
                        //echo "<br><br>";
                        // Función para cambiar de columnas a filas
                        $idMarcador = array();
                        foreach ($arreglo as $key => $subarr) {
                            foreach ($subarr as $subkey => $subvalue) {
                                $idMarcador[$subkey][$key] = $subvalue;
                            }
                        }
                        unset($arreglo);
                        $arreglo[][] = "";
                        //var_dump($arreglo);
                        //echo "<br><br>";
                        //var_dump($idMarcador);
                        //echo "<br><br>";

                        // Elimina marcadores registrador anteriormente, para introducir nueva ruta en los mismos.
                        for($x=0;$x<count($idMarcador[0],0);$x++){
                            $sql = "DELETE FROM marcadorWayPoint WHERE marcId='" . $idMarcador[0][$x] . "';";

                            require("db_config.php");
                            $mbd = mysqli_query($mbd, $sql);
                            
                            //echo $sql . ", <br>";
                        }
                        //if ($mbd) {
                            //echo "<script> alert ('Marcadores eliminados.')</script>";
                        //}
                        // Segmenta el String '$pointsArray' extraido de la funcion 'result.routes[0].overview_path;'
                        //echo "Hola: " . $actualizar_text_marcadores;
                        //$arreglo = spr_split($actualizar_text_marcadores,42);
                        //var_dump($arreglo);

                        unset($wayptsLatNuevo);
                        unset($wayptsLngNuevo);
                        $wayptsLatNuevo[][] = "";
                        $wayptsLngNuevo[][] = "";

                        $wayptsLatNuevo = explode('|', $actualizar_marcadoresLat);
                        $wayptsLngNuevo = explode('|', $actualizar_marcadoresLng);
                        //var_dump($wayptsLngNuevo);
                        //var_dump($idMarcador);
                        for($x=0;$x<count($wayptsLatNuevo,0);$x++){
                            $sumaId = $idMarcador[0][0] - 1 + $x;
                            $sql = "INSERT INTO marcadorWayPoint VALUES (" . $sumaId . "," . $x . "," . $wayptsLatNuevo[$x] . "," . $wayptsLngNuevo[$x] . "," . $rutIdEditar . ");";

                            require("db_config.php");
                            $mbd = mysqli_query($mbd, $sql);
                            //echo $sql . "<br>";
                        }
                        if ($mbd){
                            echo "<script> alert ('Marcadores actualizados.')</script>";
                        }

                    }

                    unset($actualizar_marcadores);
                    $actualizar_marcadores="";
                    


                    $sql = "UPDATE ruta SET rutNombre='". $actualizar_rutNombre . "',rutNombreCorto='". $actualizar_rutNombreCorto . "', rutDescripcion='". $actualizar_rutDescripcion . "', rutEstado='". $actualizar_rutEstado . "', rutFechaCreacion='". $actualizar_rutFechaCreacion . "' WHERE rutId='" . $rutIdEditar . "';";
                    //echo "<p>" . $sql ."</p>";
                    require("db_config.php");
                    $mbd = mysqli_query($mbd, $sql);
                    if ($mbd) {
                        echo "<script> alert ('Datos actualizados')</script>";
                        echo "<script> window.open('geolocalizacion-v4.2.php', '_self')</script>";
                    }
                    //mysqli_close($mbd);
                }
            ?>
        </div><!--#gestion-rutas-->
        
    </div><!--#floating-panel 1-->
    

    <div id="floating-panel-2">
        <div id="encabezado-fp2">
            <img src="icon/icons8-map-marker-40.png" alt="icono directions">
            <br>
            <h2>Direcciones</h2>
        </div>
        <div id="panel-fp2">
        </div>
    </div><!--#floating-panel-2-->


    <div id="map"></div><!--#map-->


    <footer role="contentinfo">
        <div id="creditos">
            <label for="icons8">Iconos:</label>&nbsp;
            <a href="https://icons8.com" id="icons8" target="_blank">Icon pack by Icons8.</a>
        </div>
    </footer>


    <script id='google-maps'>
        var lat;
        var lng;
        var posicionOrigen;
        var posicionDestino;
        var waypts;
        var pointsArray;
        var parqueCaldas = { lat: 2.440985, lng: -76.606434 };
        var pueblitoPatojo = { lat: 2.44354, lng: -76.6013199 };

        function initMap() {
            var directionsService = new google.maps.DirectionsService;

            var cursorInfo = "No me puedo mover";
            var markersOpciones = {
                draggable: true,
                animation: google.maps.Animation.DROP,
                cursor: cursorInfo
            }

            var directionsDisplay = new google.maps.DirectionsRenderer({
                draggable: true,
                map: map,
                markerOptions: markersOpciones,
                suppressPolylines: false,
                panel: document.getElementById('panel-fp2'),
            });

            // ******************** MAPA ******************
            var mapOpciones = {
                center: parqueCaldas,
                zoom: 15,
                //panControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                //noClear: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                mapTypeId: 'roadmap'
            }
            var map = new google.maps.Map(document.getElementById('map'), mapOpciones);
            directionsDisplay.setMap(map);

            var infoWindow = new google.maps.InfoWindow({ map: map });

            // ******************** MARCADOR INICIO (posicionInicio) ****************
            // Coloca un marcador arrastrable en el mapa DESTINO
            var iconoPuntero = {
                url: 'icon/icons8-map-pin-40.png'
            }
            var markerInicio = new google.maps.Marker({
                position: parqueCaldas,
                map: map,
                draggable: true,
                icon: iconoPuntero,
                animation: google.maps.Animation.DROP,
                title: "¿Marker?",
                zIndex: 1
            });
            // Extraé la ubicación del markerUbicacion
            markerInicio.addListener('dragend'/*'mouseover'*/, function () {
                posicionInicio = markerInicio.getPosition();
                var inicioString = '<div class="infoWindow"><p>Latitud: </p>' + posicionInicio.lat() + ',<br><p>Longitud: </p>' + posicionInicio.lng() + ',<br><p>Velocidad: </p>' + posicionInicio.speed + '</div>';
                var inicioInfoWindow = new google.maps.InfoWindow({
                    content: inicioString,
                    maxWidth: 400
                });
                toggleBounce();
                inicioInfoWindow.open(map, markerInicio);
                //calculateAndDisplayRoute();
                setTimeout(function () {
                    inicioInfoWindow.setMap(null);
                }, 1500);
            });
            function toggleBounce() {
                if (markerInicio.getAnimation() != null) {
                    markerInicio.setAnimation(null);
                }
                else {
                    markerInicio.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(function (){
                        markerInicio.setAnimation(null);
                    }, 500); 
                }
            }
            //******************** WAYPOINTS ******************
            document.getElementById('vamos').addEventListener('click', function () {
                //alert(posicionOrigen.lat + ', ' + posicionDestino.lng + ', ' + waypts[0].lat);
                calculateAndDisplayRoute(directionsService, directionsDisplay);
            });
            document.getElementById('editaMarcadores').addEventListener('change', function () {
                //alert(posicionOrigen.lat + ', ' + posicionDestino.lng + ', ' + waypts[0].lat);
                //alert(JSON.stringify(pointsArray, null));
            });

            directionsDisplay.addListener('directions_changed', function () {
                computeTotalDistance(directionsDisplay.getDirections());
            });

            function computeTotalDistance(result) {
                var total = 0;
                var myroute = result.routes[0];
                guardarRuta(result);
                for (var i = 0; i < myroute.legs.length; i++) {
                    total += myroute.legs[i].distance.value;
                }
                total = total / 1000;
                document.getElementById('total').innerHTML = total + ' km';
            }
        } //function initMap()

        //******************** WAYPOINTS ******************
        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            //alert(posicionOrigen.lat + ', ' + posicionDestino.lng + ', ' + waypts[0].lat);
            //alert(JSON.stringify(waypts, null));
            var modoSeleccionado = document.getElementById('modoViaje').value;
            var ruta = directionsService.route({
                origin: posicionOrigen,
                destination: posicionDestino,
                optimizeWaypoints: true,
                waypoints: waypts,
                travelMode: google.maps.TravelMode[modoSeleccionado]
            }, function(response, status) {
                if (status == 'OK') {
                    //alert(posicionOrigen.lat + ', ' + posicionDestino.lng + ', ' + waypts[0].lat);
                    directionsDisplay.setDirections(response);
                    //var route = response.routes[0];
                }
                else
                    window.alert('Directions request failed due to ' + status);
            });
        }

        //*************** Funciones Varias ******************
        function reiniciarMapa(){
            window.open ('geolocalizacion-v4.2.php', '_self');
        }

        document.getElementById('key-icono').addEventListener('click', function (){
            window.open ('panel-control-v4.2.php', '_self');
        });
        
        function eliminarConfirmacion() {
            var opcion = confirm("¿Seguro desea eliminar la ruta?");
            if (opcion == true) {
                document.getElementsByName("confirma-eliminar")[0].value = "true";
            } else {
                document.getElementsByName("confirma-eliminar")[0].value = "false";
            }
        }

        function guardarRuta(result) {
            pointsArray = [];
            pointsArray = result.routes[0].overview_path;
            //arreglo = result.routes[0].overview_path;
            //alert(JSON.stringify(arreglo, null));

            //var escr = JSON.stringify(pointsArray, null);
            //alert(JSON.stringify(pointsArray, null));
            
            //document.getElementsByName("marcadores-text-tamaño")[0].value = pointsArray.length;
            
            //alert(pointsArray.length);
            wayptsLat = [];
            wayptsLng = [];
            

            for (x=0; x<pointsArray.length; x++){
                wayptsLat += pointsArray[x].lat() + "|";
                wayptsLng += pointsArray[x].lng() + "|";
            }
            //for (x=0; x<pointsArray.length; x++)
                //wayptsNuevo += '|' + pointsArray[x];
            //for(var x=0; x<pointsArray.length; x++) 
            document.getElementsByName("marcadores-text-lat")[0].value = JSON.stringify(wayptsLat, null);
            document.getElementsByName("marcadores-text-lng")[0].value = JSON.stringify(wayptsLng, null);
        }

        //************** COPIA AL PORTAPAPELES ***************
        function copiar(id_elemento) {
            if(document.queryCommandSupported('copy')){
                // Crea un campo de texto "oculto"
                var aux = document.createElement("input");
                // Asigna el contenido del elemento especificado al valor del campo
                aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
                // Añade el campo a la página
                document.body.appendChild(aux);
                // Selecciona el contenido del campo
                aux.select();
                // Copia el texto seleccionado
                document.execCommand("copy");
                // Elimina el campo de la página
                document.body.removeChild(aux);
                //console.log("texto copiado");
                window.alert('Texto copiado.');
            }
            else
                window.alert('Navegador no soporta "execCommand".');
        }

    </script><!--#google-maps-->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBThifWtCcNmQl1UuVhVxCMhknuh3Gx7vk&callback=initMap">
    </script>
</body>

</html>