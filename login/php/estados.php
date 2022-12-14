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
    include 'conexionBackend.php';

    $Activo = "";
    $Inactivo = "";
    $id=$_POST['id'];
    if (isset($_POST['Activo'])){
    $Activo=$_POST['Activo'];
    $query = mysqli_query($conexion, "UPDATE  usuarios SET estado = '$Activo' WHERE id_usuario = '$id' ");
    }
    if (isset($_POST['Inactivo'])){
    $Inactivo=$_POST['Inactivo'];
    $query = mysqli_query($conexion, "UPDATE  usuarios SET estado = '$Inactivo' WHERE id_usuario = '$id' "); 
    }
    if ($query){
        Header("Location: admin_usuario.php");
    }
?>