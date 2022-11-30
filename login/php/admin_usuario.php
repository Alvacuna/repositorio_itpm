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
    require_once 'conexionBackend.php';

    $query = mysqli_query($conexion, "SELECT * FROM usuarios ");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../controles/css/styleadmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
</head>

<body>
        <div>
        <header class="header">
            <div class="header__container">
                <a href="../sesion.php"><img title="Bienvenido" class="logo" src="../controles/imagenes/svg/quit-reg.svg"></a>
                <h1 class="title">Usuarios</h1>
            </div>
        </header>
        </div>
        <div class="table__container">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                     while($row=mysqli_fetch_array($query)){
                ?>
                <tr class="tr">
                    <td class="tr__td"><?php  echo $row['id_usuario']?></td>
                    <td class="tr__td"><?php  echo $row['nombre_usuario']?></td>
                    <td class="tr__td"><?php  echo $row['email']?></td>
                    <td class="tr__td"><?php  echo $row['usuario']?></td>
                    <td class="tr__td"><?php  echo $row['estado']?></td>
                    <td class="tr__td tr__td--bot">
                    <form action="estados.php" method="POST" class="tr__form--buttons tr__form--buttons--separator">
                        <input type="hidden" name="id" value="<?php  echo $row['id_usuario']?>">
                        <input type="submit" name="Inactivo" id="" value="Inactivo" class="btn btn__in">
                        <input type="submit" name="Activo" id="" value="Activo" class="btn btn__act">
                    </form>
                    <form action="modificar.php" method="POST" class="tr__form--buttons">
                        <input type="hidden" name="id_mod" value="<?php  echo $row['id_usuario']?>">
                        <input type="submit" name="" id="" value="Modificar" class="btn btn__mod">
                    </form>
                    </td>
                </tr>
                <?php 
                    }
                ?>
                <!-- <tr>
                    <td>1</td>
                    <td>gabriel</td>
                    <td>gabriel@gmail.com</td>
                    <td>gabriel</td>
                    <td>123456</td>
                    <td>
                        <div class="swtich-container">
                            <input type="checkbox" id="switch">
                            <label for="switch" class="lbl"></label>
                            <input type="button" value="Modificar" id="mod">
                        </div>

                    </td>
                </tr> -->
                </tbody>
            </table>
        </div>

</body>

</html>