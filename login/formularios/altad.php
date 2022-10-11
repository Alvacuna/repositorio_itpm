<?php
    require 'conexion.php';
    try {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $sql = "INSERT INTO tutor (nombre_tutor,apellido_tutor) VALUES ('$nombre','$apellido')";
        $mysqli->query($sql);
        echo '<script>alert("Se ingresaron los datos");</script>';
        header("Location: /Proyecto/Form/formularios/docentes.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>