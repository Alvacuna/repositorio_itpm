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
        $nombre = $_POST['nombre'];
        $sql = "INSERT INTO carreras (nombre_carrera) VALUES ('$nombre')";
        $mysqli->query($sql);
        echo '<script>alert("Se ingresaron los datos");</script>';
        header("Location: /Proyecto/Form/formularios/carreras.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>