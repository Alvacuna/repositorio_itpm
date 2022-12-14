<?php
session_start();
if (!isset ($_SESSION['usuario'])){
    echo '
    <script>
    alert ("Debes iniciar sesion");
    window.location = "../index.php";
    </script>
    ';
    session_destroy();
    die();
}
    require 'conexion.php';
    try {
        $mysqli->autocommit(FALSE);
        $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
        error_reporting(E_ERROR);
        if (isset($_POST['nombre'])) {
            $nom = $_POST['nombre'];
            if (preg_match($patron_texto, $nom)) {
                $nombre = ucwords(trim($nom));
                $sql = "SELECT id_carrera FROM carreras WHERE nombre_carrera='$nombre'";
                $mysqli->query($sql);
                if ($mysqli->affected_rows <= 0) {
                    $sql = "INSERT INTO carreras (nombre_carrera) VALUES ('$nombre')";
                    $mysqli->query($sql);
                    $error = ($mysqli->affected_rows > 0) ? true : false;
                    $id=$mysqli->insert_id;
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
        echo'window.history.back();</script>';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>