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

$id = $_POST['id_mod'];
$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = '$id' ");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificando</title>
    <link rel="stylesheet" href="../controles/css/stylesForm.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="nav">
        <a href="../sesion.php"><img title="Bienvenido" class="nav__logo" src="../controles/imagenes/svg/quit-reg.svg"></a>
        <h1 class="nav__title">Administrador</h1>
    </nav>
    <div class="container">
        <form action="update.php" method="POST" class="form">
            <h2 class="form__title">Actualizar</h2>
            <?php
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <input type="hidden" name="id_a" value="<?php echo $row['id_usuario'] ?>" class="form__input">
                <label for="">Nombre</label><input type="text" placeholder="Nombre completo" name="nombre" value="<?php echo $row['nombre_usuario']  ?>" class="form__input"> 
                <label for="">Email</label><input type="email" placeholder="Correo Electronico" name="correo" value="<?php echo $row['email']  ?>" class="form__input">
                <label for="">Usuario</label><input type="text" placeholder="Usuario" name="usuario" value="<?php echo $row['usuario']  ?>" class="form__input">
                <label for="">Contraseña</label><input type="password" placeholder="Contraseña" name="contrasena" class="form__input">
            <?php
            }
            ?>
            <input type="submit" value="Actualizar" class="input btn">
        </form>

    </div>
</body>

</html>