<?php
require 'conexion.php';
try {
    $mysqli->autocommit(FALSE);
    $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
    error_reporting(E_ERROR);
    $n = $_POST['nombre'];
    $nom = filter_var($n, FILTER_SANITIZE_STRING);
    $a = $_POST['apellido'];
    $ape = filter_var($a, FILTER_SANITIZE_STRING);
    if (preg_match($patron_texto, $nom) && preg_match($patron_texto, $ape)) {
        $nombre = ucwords(ltrim(rtrim($nom)));
        $apellido = ucwords(ltrim(rtrim($ape)));
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