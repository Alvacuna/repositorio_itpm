<?php
    $mysqli = new mysqli("localhost", "root", "", "repositorio");

    /* verificar la conexión */
    if (mysqli_connect_errno()) {
        printf("Falló la conexión: %s\n", mysqli_connect_error());
        exit();
    }

    /* cambiar el conjunto de caracteres a utf8 */
    if (!$mysqli->set_charset("utf8")) {
        printf("Error cargando el conjunto de caracteres utf8: %s\n", $mysqli->error);
        exit();
    }
?>