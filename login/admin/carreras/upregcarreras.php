<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require '../conexion.php';
    if (isset($_POST['nombre'])) {
        $mysqli->autocommit(FALSE);
        error_reporting(E_ERROR);
        $exchange = true;
        $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        if (preg_match($patron_texto, $nombre)) {
            $nombre = ucwords(mb_strtolower(trim($nombre)));
                if ($stmt = $mysqli->prepare("UPDATE carreras SET nombre_carrera = ? WHERE id_carrera = $id")) {
                    $stmt->bind_param("s", $nombre);
                    $stmt->execute();
                    $exchange = ($stmt->affected_rows > 0) ? true : false;
                    $stmt->close();
                }
        } else {
            $exchange = false;
        }
    } else {
        $error = false;
    }
    if (!$exchange) {
        if (!$mysqli->rollback()) {
            echo '<script>alert("Falló la reversión de la transacción");';
        } else {
            echo '<script>alert("No se ingresaron los datos");';
        }
    } else {
        if (!$mysqli->commit()) {
            echo '<script>alert("Falló la consignación de la transacción");';
        } else {
            echo '<script>alert("Datos registrados correctamente");';
        }
    }
    $mysqli->close();
    echo'window.history.go(-2);</script>';
?>