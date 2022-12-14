<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require_once '../conexion.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM tutor WHERE id_tutor = $id";
    $result = $mysqli->query($query);
    ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario</title>
        <link rel="stylesheet" href="../../css/css.css">
    </head>
    <body>
        <form action="upregtutores.php" name="formu" method="POST" class="form">
            <h2>Modificación de Tutor</h2>
            <?php while ($r = $result->fetch_array()) {?>
            <input type="hidden" name="id" value="<?=$r['id_tutor'];?>" class="form__input">
            <div class="form__container -form">
                <div class="form__group grupo">
                    <input id="nombre" class="form__input" type="text" name="nombre" placeholder=" " required value="<?=$r['nombre_tutor'];?>">
                    <label for="nombre" class="form__label">Nombre Tutor</label>
                </div>
                <div class="form__group grupo">
                    <input id="apellido" class="form__input" type="text" name="apellido" placeholder=" " required value="<?=$r['apellido_tutor'];?>">
                    <label for="apellido" class="form__label">Apellido Tutor</label>
                </div>
            </div>
            <?php } $result->free();?>
            <input type="submit" value="Enviar" class="boton">
            <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
        </form>
    </body>
</html>