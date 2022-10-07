<?php

    session_start();
    include 'conexionBackend.php';

    $usuario = $_POST ['usuario'];
    $contrasena = $_POST ['contrasena'];
    $contrasena = hash('sha512', $contrasena);
    $validar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'
                AND contrasena = '$contrasena'");
    if (mysqli_num_rows($validar) > 0){
        $_SESSION ['usuario'] = $usuario;
        header("location: ../sesion.php");
    $query =mysqli_query($conexion, "INSERT INTO historial (usuario)
                    values ('$usuario')");
        exit;
    }else{
        echo '
        <script>
        alert ("Ingresa el correo y la contraseña correcta");
        window.location = "../index.php";
        </script>
        ';
        exit;
    }

?>