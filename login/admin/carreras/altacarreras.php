<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require '../conexion.php';
    try {
        $mysqli->autocommit(FALSE);
        $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
        error_reporting(E_ERROR);
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            if (preg_match($patron_texto, $nombre)) {
                $nombre = ucwords(mb_strtolower(trim($nombre)));
                $sql = "SELECT * FROM carreras WHERE nombre_carrera='$nombre'";
                $mysqli->query($sql);
                if ($mysqli->affected_rows <= 0) {
                    if ($stmt = $mysqli->prepare("INSERT INTO carreras (nombre_carrera) VALUES (?)")) {
                        $stmt->bind_param("s", $nombre);
                        $stmt->execute();
                        $error = ($stmt->affected_rows > 0) ? true : false;
                        $stmt->close();
                    }
                }
            } else {
                $error = false;
            }
        } else {
            $error = false;
        }
        if (!$error) {
            if (!$mysqli->rollback()) {
                echo '<script>alert("Falló la reversión de la transacción");';
            } else {
                $mysqli->query("ALTER TABLE carreras AUTO_INCREMENT = '$id'");
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
        echo'window.location = "carreras.php";</script>';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>