<?
    $username="root";
    $password="";
    $database="sistransporte";
    $host="localhost";

    // ******************** CONEXIÓN *********************
    $mbd = new mysqli($host, $username, $password, $database);
    // comprobar la conexión
    if ($mbd->connect_errno) {
        printf("Falló la conexión: %s\n", $mbd->connect_error);
        exit();
    }
?>