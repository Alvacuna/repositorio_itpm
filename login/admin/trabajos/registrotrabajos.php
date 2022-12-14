<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '
        <script>
        alert ("Debes iniciar sesion");
        window.location = "../index.php";
        </script>
        ';
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
            <h2>Registro de Trabajos</h2>
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Título</th>
                    <th>Resumen</th>
                    <th>Gestión</th>
                    <th>Link</th>
                    <th>Mod.</th>
                    <th>Carrera</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <?php
                $i=1;
                $query = 'SELECT * FROM trabajos_institucionales T INNER JOIN modalidad M ON T.id_mod = M.id_mod INNER JOIN carreras C ON T.id_carrera = C.id_carrera ORDER BY T.titulo';
                $result = $mysqli->query($query);
                while ($r = $result->fetch_array()) {
                ?>
                    <tr>
                        <th><?=$i++;?></th>
                        <td class="titulo"><?=$r['titulo'];?></td>
                        <td><?=$r['resumen'];?></td>
                        <td><?=$r['gestion'];?></td>
                        <td><a href="<?=$r['link_pdf'];?>">Documento PDF</a></td>
                        <td>
                            <?=$r['tipo_documento'];?>
                        </td>
                        <td><?=$r['nombre_carrera'];?></td>
                        <td><button onclick="location.href='update.php?id=<?=$r['id_trabajos']?>'">Modificar</button></td>
                    </tr>
                <?php } $result->free(); ?>
        </table>
        <a href="javascript: history.go(-1)"><input type="button" value="Regresar" class="boton"></a>
    </div>
</body>
</html>