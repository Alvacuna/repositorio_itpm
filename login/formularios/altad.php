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
    if (isset($_POST['nombre']) && isset($_POST['apellido'])) {
        $n = $_POST['nombre'];
        $a = $_POST['apellido'];
        $nom = filter_var($n, FILTER_SANITIZE_STRING);
        $ape = filter_var($a, FILTER_SANITIZE_STRING);
        if (preg_match($patron_texto, $nom) && preg_match($patron_texto, $ape)) {
            $nombre = ucwords(mb_strtolower(ltrim(rtrim($nom))));
            $apellido = ucwords(mb_strtolower(ltrim(rtrim($ape))));
            $sql = "SELECT id_tutor FROM tutor WHERE nombre_tutor='$nombre' AND apellido_tutor='$apellido'";
            $mysqli->query($sql);
            if ($mysqli->affected_rows <= 0) {
                $sql = "INSERT INTO tutor (nombre_tutor,apellido_tutor) VALUES ('$nombre','$apellido')";
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
            $mysqli->query("ALTER TABLE tutor AUTO_INCREMENT = '$id'");
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