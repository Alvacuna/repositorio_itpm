<?php
session_start();
if (!isset($_SESSION['usuario'])) {
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

        $id = $_POST['id_a'];
        $nombre = $_POST ['nombre'];
        $email = $_POST ['correo'];
        $usuario = $_POST ['usuario'];
        $contrasena = $_POST ['contrasena'];

        // encriptando la contraseña 
        $contrasena = hash('sha512',$contrasena);
        if(!empty($nombre) && !empty($email)&& !empty($usuario)&& !empty($contrasena)){
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            $usuario = filter_var($usuario, FILTER_SANITIZE_STRING);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                    // insertando la informacion en la BD 
        $query = mysqli_query($conexion,"UPDATE usuarios SET nombre_usuario = '$nombre', email = '$email',
        usuario = '$usuario', contrasena = '$contrasena' WHERE id_usuario = '$id'");
        }else{
            echo'<script>
                alert ("introduzca todos los datos");
                window.location = "modificar.php";
                </script>';
        }


    if ($query){
    echo'<script>
    alert ("Usuario Actualizado exitosamente");
    window.location = "admin_usuario.php";
    </script>';
    }else{
    echo'<script>
    alert ("Error intentelo nuevamente");
    window.location = "modificar.php";
    </script>';
    }

?>