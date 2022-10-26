<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <form action="altad.php" name="formu" method="POST" class="form">
        <h2>Registro de Docentes</h2>
        <div class="form__container -form">
            <div class="form__group grupo">
                <input id="nombre" class="form__input" type="text" name="nombre" placeholder=" " required>
                <label for="nombre" class="form__label">Nombre Tutor</label>
            </div>
            <div class="form__group grupo">
                <input id="apellido" class="form__input" type="text" name="apellido" placeholder=" " required>
                <label for="apellido" class="form__label">Apellido Tutor</label>
            </div>
        </div>
        <input type="submit" value="Enviar" class="boton">
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </form>
</body>
</html>