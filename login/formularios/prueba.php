<?php
require 'conexion.php';
include 'apidrive/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=subir-archivos-1-73e866de05c4.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
try {
    $mysqli->autocommit(FALSE);
    $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ\s]+$/";
    error_reporting(E_ERROR);
    $error = true;
    $f = '"\'`.,:;?!¡¿()';
    $patron_texto_f = '/[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ' . preg_quote($f, '/') . '\s]/';
    $t = $_POST['titulo'];
    $tit = filter_var($t, FILTER_SANITIZE_STRING);
    $r = $_POST['resumen'];
    $res = filter_var($r, FILTER_SANITIZE_STRING);
    $gestion = $_POST['gestion'];
    $modalidad = $_POST['modalidad'];
    $carrera = $_POST['carrera'];
    if (preg_match($patron_texto_f, $tit) && preg_match($patron_texto_f, $res)) {
        $titulo = ucfirst(ltrim(rtrim($tit)));
        $resumen = ucfirst(ltrim(rtrim($res)));
        $sql = "SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'";
        $mysqli->query($sql);
        if ($mysqli->affected_rows <= 0) {
            $service = new Google_Service_Drive($client);
            $file_path = $_FILES['archivos']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file_path);
            $file = new Google_Service_Drive_DriveFile();
            $file->setName($titulo);
            $file->setParents(array("18WrywNyRQ3AAQU1xJMf-jZgTashyy45Y"));
            $file->setMimeType($mime_type);
            $resultado = $service->files->create($file, array('data' => file_get_contents($file_path), 'mimeType' => $mime_type, 'uploadType' => 'media'));
            $ruta = 'https://drive.google.com/open?id=' . $resultado->id;
            $sql = "INSERT INTO trabajos_institucionales (titulo,resumen,gestion,link_pdf,id_mod,id_carrera) VALUES ('$titulo','$resumen','$gestion','$ruta','$modalidad','$carrera')";
            $mysqli->query($sql);
            $error = ($mysqli->affected_rows > 0) ? true : false;
            $id_trabajo = $mysqli->insert_id;
        }
    } else {
        $error = false;
    }
    if (isset($_POST['nombresa']) && isset($_POST['apellidosa'])) {
        foreach ($_POST['nombresa'] as $key => $n) {
            $a = $_POST['apellidosa'][$key];
            $nom = filter_var($n, FILTER_SANITIZE_STRING);
            $ape = filter_var($a, FILTER_SANITIZE_STRING);
            if (preg_match($patron_texto, $nom) && preg_match($patron_texto, $ape)) {
                $nombre = ucwords(ltrim(rtrim($nom)));
                $apellido = ucwords(ltrim(rtrim($ape)));
                $sql = "SELECT id_autor FROM autor WHERE nombre_autor='$nombre' AND apellido_autor='$apellido'";
                $mysqli->query($sql);
                if ($mysqli->affected_rows <= 0) {
                    $sql = "INSERT INTO autor (nombre_autor,apellido_autor) VALUES ('$nombre','$apellido')";
                    $mysqli->query($sql);
                    $error = ($mysqli->affected_rows > 0) ? true : false;
                    $id_autor=$mysqli->insert_id;
                }
                $sql = "INSERT INTO trabajos_autor (id_trabajos,id_autor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'),(SELECT id_autor FROM autor WHERE nombre_autor='$nombre' AND apellido_autor='$apellido'))";
                $mysqli->query($sql);
                $error = ($mysqli->affected_rows > 0) ? true : false;
            } else {
                $error = false;
            }
        }
    } else {
        $error = false;
    }
    if (isset($_POST['tutores'])) {
        foreach ($_POST['tutores'] as $key => $tutor) {
            $sql = "INSERT INTO trabajos_tutor (id_trabajos,id_tutor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE titulo='$titulo'),(SELECT id_tutor FROM tutor WHERE id_tutor='$tutor'))";
            $mysqli->query($sql);
            $error = ($mysqli->affected_rows > 0) ? true : false;
        }
    }
        if (!$error) {
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
        echo'window.history.back();</script>';
} catch (Google_Service_Exception $gs) {
    $mensaje = json_decode($gs->getMessage());
    echo $mensaje->error->message();
} catch (Exception $e) {
    echo $e->getMessage();
}