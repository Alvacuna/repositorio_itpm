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
    <form action="alta.php" name="formu" method="POST" class="form" enctype="multipart/form-data">
        <h2>Registro de Trabajos</h2>
        <div class="form__container -form">
            <div class="form__group grupo">
                <input id="autor" class="form__input" type="text" name="autor" placeholder=" " required>
                <label for="autor" class="form__label">Autor</label>
            </div>
            <div class="form__group grupo">
                <input id="apellido" class="form__input" type="text" name="apellido" placeholder=" ">
                <label for="apellido" class="form__label">Apellido</label>
            </div>
            <div class="form__group grupo">
                <input id="titulo" class="form__input" type="text" name="titulo" placeholder=" ">
                <label for="titulo" class="form__label">Titulo</label>
            </div>
            <div class="form__group grupo">
                <input id="titulo" class="form__input" type="text" name="resumen" placeholder=" ">
                <label for="resumen" class="form__label">Resumen</label>
            </div>
        </div>
        <div>
            <label for="gestion">Gestión</label>
            <select name="gestion" id="gestion" required>
                <option value="" disabled selected>Seleccione Gestión</option>
            </select>
        </div>
        <div>
        <label for="gestion">Tutor</label>
        <select name="tutor" id="" required>
            <option value="" disabled selected>Seleccione Tutor</option>
            <?php
            $query = 'SELECT * FROM tutor';
            $result = $mysqli->query($query);
            while ($r = $result->fetch_assoc()) {
            ?>
                <option value="<?= $r['id_tutor']; ?>"><?= $r['nombre_tutor'] ?></option>
            <?php } ?>
        </select>
        </div>
        <div>
        <label for="gestion">Modalidad</label>
        <select name="modalidad" id="" required>
            <option value="" disabled selected>Seleccione Modalidad</option>
            <?php
            $query = 'SELECT * FROM modalidad';
            $result = $mysqli->query($query);
            while ($r = $result->fetch_assoc()) {
            ?>
                <option value="<?= $r['id_mod']; ?>"><?= $r['tipo_documento']; ?></option>
            <?php } ?>
        </select>
        </div>
        <div>
        <label for="gestion">Carrera</label>
        <select name="carrera" id="" required>
            <option value="" disabled selected>Seleccione Carrera</option>
            <?php
            $query = 'SELECT * FROM carreras';
            $result = $mysqli->query($query);
            while ($r = $result->fetch_assoc()) {
            ?>
                <option value="<?= $r['id_carrera']; ?>"><?= $r['nombre_carrera']; ?></option>
            <?php } ?>
        </select>
        </div>
        <div>
            <input type="file" onchange="return val()" name="archivos" accept=".pdf" id="arc">
        </div>
        <input type="submit" value="Enviar" class="boton">
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </form>
    <script src="../js/main.js"></script>
</body>
</html>