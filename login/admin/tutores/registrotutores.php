<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require_once '../conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../../css/css.css">
    <link rel="stylesheet" href="../../css/reg.css">
</head>
<body>
    <div class="table">
        <table>
            <h2>Registro de Tutores</h2>
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Nombres Tutor</th>
                    <th>Apellidos Tutor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <?php
                $i=1;
                $query = 'SELECT * FROM tutor ORDER BY nombre_tutor';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_array()) {
                ?>
                    <tr>
                        <th><?=$i++;?></th>
                        <th><?=$r['nombre_tutor'];?></th>
                        <td><?=$r['apellido_tutor'];?></td>
                        <td><button onclick="location.href='updatetutor.php?id=<?=$r['id_tutor']?>'">Modificar</button></td>
                    </tr>
                <?php } $result->free(); ?>
        </table>
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </div>
</body>
</html>