<?php 

    include 'conexionBackend.php';
        // recibiendo los datos 
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
        $query = "INSERT INTO usuarios (nombre_usuario,email,usuario,contrasena)
        values ('$nombre','$email','$usuario','$contrasena')";
        }else{
            echo'<script>
                alert ("introduzca todos los datos");
                window.location = "../index.php";
                </script>';
        }

        // asegurarse que el correo no se repita en la BD
        $ver_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$email'");

        if (mysqli_num_rows($ver_correo) > 0){
            echo '<script>
            alert ("introduzca otro correo");
            window.location = "../index.php";
            </script>';
            exit();
        }

        // asegurarse que el usuario no se repita en la BD
        $ver_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

        if (mysqli_num_rows($ver_usuario) > 0){
            echo '<script>
            alert ("introduzca otro usuario");
            window.location = "../index.php";
            </script>';
            exit();
        }

        // ejecutando la conexion a la BD
        $ejecutar = mysqli_query($conexion, $query);

    if ($ejecutar){
    echo'<script>
    alert ("Usuario Registrado");
    window.location = "../index.php";
    </script>';
    }else{
    echo'<script>
    alert ("Error intentelo nuevamente");
    window.location = "../index.php";
    </script>';
    }
mysqli_close($conexion);
