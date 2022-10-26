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
    <form action="prueba.php" name="formu" method="POST" class="form" enctype="multipart/form-data" id="form">
        <h2>Registro de Trabajos</h2>
        <div class="form__container">
            <div class="autores" id="autores">
                <h3>Información de Autor (es)</h3>
                <div class="autor" id="autor">
                    <div class="form__group grupo">
                        <input id="autor" class="form__input" type="text" name="nombresa[]" placeholder=" " required>
                        <label for="autor" class="form__label">Nombre</label>
                    </div>
                    <div class="form__group grupo">
                        <input id="apellido" class="form__input" type="text" name="apellidosa[]" placeholder=" " required>
                        <label for="apellido" class="form__label">Apellido</label>
                    </div>
                </div>
            </div>
            <button id="agregarautor" type="button" class="agregar">Agregar Autor (es)</button>
            <div class="form__group grupo">
                <input id="titulo" class="form__input" type="text" name="titulo" placeholder=" " required>
                <label for="titulo" class="form__label">Título</label>
            </div>
            <div class="form__group grupo">
                <input id="resumen" class="form__input" type="text" name="resumen" placeholder=" " required>
                <label for="resumen" class="form__label">Resumen</label>
            </div>
            <div class="relacional">
                <div>
                    <label for="carrera">Carrera</label>
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
                    <label for="modalidad">Modalidad</label>
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
            </div>
            <div id="tutores">
                <div id="tutor">
                    <label for="tutor">Tutor</label>
                    <select name="tutores[]" id="" required>
                        <option value="" disabled selected>Seleccione Tutor</option>
                        <?php
                            $query = 'SELECT * FROM tutor';
                            $result = $mysqli->query($query);
                            while ($r = $result->fetch_assoc()) {
                        ?>
                                <option value="<?= $r['id_tutor']; ?>"><?= $r['nombre_tutor'].' '.$r['apellido_tutor'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button id="agregartutor" type="button" class="agregar">Agregar Tutor (es)</button>
            <div>
                <label for="gestion">Gestión</label>
                <select name="gestion" id="gestion" required>
                    <option value="" disabled selected>Seleccione Gestión</option>
                </select>
            </div>
            <div>
                <input type="file" name="archivos" accept=".pdf" id="archivos" required multiple>
                <progress value="0" max="100" id="progress" class="progress"></progress>
            </div>
        </div>
        <input type="submit" value="Enviar" class="boton">
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </form>
    <script src="../js/main.js"></script>
</body>
</html>