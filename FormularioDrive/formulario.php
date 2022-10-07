<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <style>
        div{
            margin: 1rem;
        }
    </style>
</head>
<body>
    <form name="formu" action="subir_archivos.php" method="post" enctype="multipart/form-data">
        <div>
            <input type="text" name="autor" placeholder="autor" required>
        </div>
        <div>
            <input type="text" name="apellido" placeholder="apellido">
        </div>
        <div>
            <input type="text" name="resumen" placeholder="resumen" required>
        </div>
        <div>
            <input type="text" name="gestion" placeholder="gestion" required>
        </div>
        <select name="tutor" id="">
            <?php
                $query = 'SELECT * FROM tutor';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_assoc()) {
                    ?>
            <option value="<?= $r['id_tutor']; ?>"><?= $r['nombre_tutor']; ?></option>
            <?php } ?>
        </select>
        <select name="modalidad" id="">
            <?php
                $query = 'SELECT * FROM modalidad';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_assoc()) {
                    ?>
            <option value="<?= $r['id_mod']; ?>"><?= $r['tipo_documento']; ?></option>
            <?php } ?>
        </select>
        <select name="carrera" id="">
            <?php
                $query = 'SELECT * FROM carreras';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_assoc()) {
                    ?>
            <option value="<?= $r['id_carrera']; ?>"><?= $r['nombre_carrera']; ?></option>
            <?php } ?>
        </select>
        <div>
            <input type="file" onchange="return val()" name="archivos" accept=".pdf">
        </div>
        <input type="submit" value="enviar">
    </form>
    <script src="main.js"></script>
</body>
</html>