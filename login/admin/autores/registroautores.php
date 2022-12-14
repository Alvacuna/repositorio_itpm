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
            <h2>Registro de Autores</h2>
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Nombres Autor</th>
                    <th>Apellidos Autor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <?php
                $i=1;
                $query = 'SELECT * FROM autor ORDER BY nombre_autor';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_array()) {
                ?>
                    <tr>
                        <th><?=$i++;?></th>
                        <td><?=$r['nombre_autor'];?></td>
                        <td><?=$r['apellido_autor'];?></td>
                        <td><button onclick="location.href='updateautor.php?id=<?=$r['id_autor']?>'">Modificar</button></td>
                    </tr>
                <?php } $result->free(); ?>
        </table>
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </div>
</body>
</html>