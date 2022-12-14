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
require 'conexion.php';
include 'apidrive/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=subir-archivos-1-369413-028b5af1d15b.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
try {
    $mysqli->autocommit(FALSE);
    $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
    error_reporting(E_ERROR);
    $exchange = true;
    $f = '"\'`.,:;?!¡¿()';
    $patron_texto_f = '/[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ' . preg_quote($f, '/') . '\s]/';
    $tit = $_POST['titulo'];
    $res = $_POST['resumen'];
    $gestion = $_POST['gestion'];
    $modalidad = $_POST['modalidad'];
    $carrera = $_POST['carrera'];
    if (preg_match($patron_texto_f, $tit) && preg_match($patron_texto_f, $res)) {
        $titulo = $mysqli->real_escape_string(mb_strtoupper(trim($tit), 'UTF-8'));
        $resumen = $mysqli->real_escape_string(ucfirst(mb_strtolower(trim($res), 'UTF-8')));
        $sql = "SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'";
        $mysqli->query($sql);
        if ($mysqli->affected_rows <= 0) {
            $service = new Google_Service_Drive($client);
            $file_path = $_FILES['archivos']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file_path);
            $file = new Google_Service_Drive_DriveFile();
            $file->setName($titulo);
            $file->setParents(array("1nk5Gvgokxgg-sJy7tsFXo44aS75U3JHA"));
            $file->setMimeType($mime_type);
            $resultado = $service->files->create($file, array('data' => file_get_contents($file_path), 'mimeType' => $mime_type, 'uploadType' => 'media'));
            $ruta = 'https://drive.google.com/open?id=' . $resultado->id;
            $sql = "INSERT INTO trabajos_institucionales (titulo,resumen,gestion,link_pdf,id_mod,id_carrera) VALUES ('$titulo','$resumen','$gestion','$ruta','$modalidad','$carrera')";
            $mysqli->query($sql);
            $exchange = ($mysqli->affected_rows > 0) ? true : false;
            $id_trabajo = $mysqli->insert_id;
        }
    } else {
        $exchange = false;
    }
    if (isset($_POST['nombresa']) && isset($_POST['apellidosa'])) {
        foreach ($_POST['nombresa'] as $key => $n) {
            $a = $_POST['apellidosa'][$key];
            $nom = filter_var($n, FILTER_SANITIZE_STRING);
            $ape = filter_var($a, FILTER_SANITIZE_STRING);
            if (preg_match($patron_texto, $nom) && preg_match($patron_texto, $ape)) {
                $nombre = ucwords(mb_strtolower(trim($nom)));
                $apellido = ucwords(mb_strtolower(trim($ape)));
                $sql = "SELECT id_autor FROM autor WHERE nombre_autor='$nombre' AND apellido_autor='$apellido'";
                $mysqli->query($sql);
                if ($mysqli->affected_rows <= 0) {
                    $sql = "INSERT INTO autor (nombre_autor,apellido_autor) VALUES ('$nombre','$apellido')";
                    $mysqli->query($sql);
                    $exchange = ($mysqli->affected_rows > 0) ? true : false;
                    $id_autor=$mysqli->insert_id;
                }
                $sql = "SELECT id_trabajos_tutor FROM trabajos_autor WHERE id_trabajos=(SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo') AND id_autor=(SELECT id_autor FROM autor WHERE nombre_autor='$nombre' AND apellido_autor='$apellido')";
                $mysqli->query($sql);
                if ($mysqli->affected_rows <= 0) {
                    $sql = "INSERT INTO trabajos_autor (id_trabajos,id_autor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'),(SELECT id_autor FROM autor WHERE nombre_autor='$nombre' AND apellido_autor='$apellido'))";
                    $mysqli->query($sql);
                    $exchange = ($mysqli->affected_rows > 0) ? true : false;
                }
            } else {
                $exchange = false;
            }
        }
    } else {
        $exchange = false;
    }
    if (isset($_POST['tutores'])) {
        foreach ($_POST['tutores'] as $key => $tutor) {
            $sql = "SELECT id_trabajos_tutor FROM trabajos_tutor WHERE id_trabajos=(SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo') AND id_tutor=(SELECT id_tutor FROM tutor WHERE id_tutor='$tutor')";
            $mysqli->query($sql);
            if ($mysqli->affected_rows <= 0) {
                $sql = "INSERT INTO trabajos_tutor (id_trabajos,id_tutor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'),(SELECT id_tutor FROM tutor WHERE id_tutor='$tutor'))";
                $mysqli->query($sql);
                $exchange = ($mysqli->affected_rows > 0) ? true : false;
            }
        }
    }
        if (!$exchange) {
            if (!$mysqli->rollback()) {
                echo '<script>alert("Falló la reversión de la transacción");';
            } else {
                $mysqli->query("ALTER TABLE tutor AUTO_INCREMENT = '$id'");
                echo '<script>alert("No se ingresaron los datos");';
            }
        } else {
            if (!$mysqli->commit()) {
                echo '<script>alert("Falló la consignación de la transacción");';
            } else {
                echo '<script>alert("Datos registrados correctamente");';
            }
        }
        $mysqli->close();
        echo'window.location = "formulario.php";</script>';
} catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->exchange->message();
} catch (Exception $e) {
    echo $e->getMessage();
}