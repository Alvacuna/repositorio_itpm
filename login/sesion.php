<?php 

    session_start();

    if (!isset ($_SESSION['usuario'])){
        echo '
        <script>
        alert ("Debes iniciar sesion");
        window.location = "index.php";
        </script>
        ';
        //header("location: index.php");
        session_destroy();
        die();
    }
    require_once 'conexion.php';
    include 'php/conexionBackend.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a la Sesion</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main>
        <div class="container__card">
            <div class="card__principal">
                <div class="card">
                    <div class="card__front">
                        <div class="body__card__front">
                            <h1>Registrar Trabajos</h1>
                        </div>
                    </div>
                    <div class="card__back">
                        <div class="body__card__back">
                            <p>Formulario para el registro de Trabajos y carga en Google Drive del documento</p>
                            <a href="admin/trabajos/formulario.php"><input type="button" value="Ingresar"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__principal">
                <div class="card">
                    <div class="card__front">
                        <div class="body__card__front">
                            <h1>Registrar Docentes</h1>
                        </div>
                    </div>
                    <div class="card__back">
                        <div class="body__card__back">
                            <p>Formulario para el registro de ingreso para Docentes nuevos</p>
                            <a href="admin/tutores/docentes.php"><input type="button" value="Ingresar"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__principal">
                <div class="card">
                    <div class="card__front">
                        <div class="body__card__front">
                            <h1>Registrar Carreras</h1>
                        </div>
                    </div>
                    <div class="card__back">
                        <div class="body__card__back">
                            <p>Formulario para el registro de ingreso para Carreras nuevas en en ITPM</p>
                            <a href="admin/carreras/carreras.php"><input type="button" value="Ingresar"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <a href="php/cerrar.php"><input type="button" value="Cerrar sesion"></a>
    <?php
        $usuario = $_SESSION['usuario'];
        $validar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");
        $row=$validar->fetch_array();
        if ($row['rol_admin'] == 'admin') {
            echo '<a href="php/admin_usuario.php"><input type="button" value="Administrar Usuarios"></a>';
        }
        
    ?><br>
    <a href="admin/trabajos/registrotrabajos.php"><input type="button" value="Registro de Trabajos"></a>
    <a href="admin/autores/registroautores.php"><input type="button" value="Registro de Autores"></a>
    <a href="admin/tutores/registrotutores.php"><input type="button" value="Registro de Docentes"></a>
    <a href="admin/carreras/registrocarreras.php"><input type="button" value="Registro de Carreras"></a>
</body>
</html>