<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require_once '../conexion.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM trabajos_institucionales T INNER JOIN modalidad M ON T.id_mod = M.id_mod INNER JOIN carreras C ON T.id_carrera = C.id_carrera WHERE id_trabajos = $id";
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
    <form action="upregtrabajos.php" name="formu" method="POST" class="form" enctype="multipart/form-data" id="form">
        <h2>Modificación de Trabajo</h2>
            <?php while ($r = $result->fetch_array()) {?>
        <input type="hidden" name="id" value="<?=$r['id_trabajos'];?>" class="form__input">
        <div class="form__container">
            <div class="form__group grupo">
                <input id="titulo" class="form__input" type="text" name="titulo" placeholder=" " required value="<?=$r['titulo'];?>">
                <label for="titulo" class="form__label">Título</label>
            </div>
            <div class="form__group grupo">
                <input id="resumen" class="form__input" type="text" name="resumen" placeholder=" " required value="<?=$r['resumen'];?>">
                <label for="resumen" class="form__label">Resumen</label>
            </div>
            <div class="relacional">
                <div class="carrera">
                    <label for="carrera">Carrera</label>
                    <select name="carrera" id="" required>
                        <option value="<?=$r['id_carrera'];?>" selected><?=$r['nombre_carrera'];?></option>
                        <?php
                        $query = "SELECT * FROM carreras WHERE id_carrera != ".$r['id_carrera']." ORDER BY nombre_carrera";
                        $result = $mysqli->query($query);
                        while ($c = $result->fetch_assoc()) {
                        ?>
                            <option value="<?= $c['id_carrera']; ?>"><?= $c['nombre_carrera']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modalidad">
                    <label for="modalidad">Modalidad</label>
                    <select name="modalidad" id="" required>
                        <option value="<?=$r['id_mod'];?>" selected><?=$r['tipo_documento'];?></option>
                        <?php
                            $query = "SELECT * FROM modalidad WHERE id_mod != ".$r['id_mod']." ORDER BY tipo_documento";
                            $result = $mysqli->query($query);
                            while ($m = $result->fetch_assoc()) {
                        ?>
                                <option value="<?= $m['id_mod']; ?>"><?= $m['tipo_documento']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div>
                <label for="gestion">Gestión</label>
                <select name="gestion" id="gestion" required>
                    <option value="<?=$r['gestion'];?>" selected><?=$r['gestion'];?></option>
                </select>
            </div>
            <div>
                <a href="<?=$r['link_pdf'];?>">Documento PDF</a><br>
                <input type="file" name="archivos" accept=".pdf" id="archivos">
                <progress value="0" max="100" id="progress" class="progress"></progress>
            </div>
        </div>
        <?php } $result->free();?>
        <input type="submit" value="Enviar" class="boton">
        <a href='javascript: history.go(-1)'><input type="button" value="Regresar" class="boton"></a>
    </form>
    <script src="../js/main.js"></script>
</body>
</html>