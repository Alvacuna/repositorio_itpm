<?php
    session_start();
    if (!isset ($_SESSION['usuario'])){
        echo '<script>alert ("Debes iniciar sesion");window.location = "../index.php";</script>';
        session_destroy();
        die();
    }
    require '../conexion.php';
    $mysqli->autocommit(FALSE);
    error_reporting(E_ERROR);
    $exchange = true;
    $f = '"\'`.,:;?!¡¿()';
    $patron_texto_f = '/[0-9a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ' . preg_quote($f, '/') . '\s]/';
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $gestion = $_POST['gestion'];
    $modalidad = $_POST['modalidad'];
    $carrera = $_POST['carrera'];
    if (preg_match($patron_texto_f, $titulo) && preg_match($patron_texto_f, $resumen)) {
        $titulo = mb_strtoupper(trim($titulo));
        $resumen = ucfirst(mb_strtolower(trim($resumen)));
        if ($_FILES['archivos']['tmp_name']!=="") {
            include 'apidrive/vendor/autoload.php';
            putenv('GOOGLE_APPLICATION_CREDENTIALS=subir-archivos-1-369413-028b5af1d15b.json');
            $client = new Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
            try {
                $service = new Google_Service_Drive($client);
                $file_path = $_FILES['archivos']['tmp_name'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_path);
                $file = new Google_Service_Drive_DriveFile();
                $file->setName($titulo);
                $file->setParents(array("1nk5Gvgokxgg-sJy7tsFXo44aS75U3JHA"));
                $file->setMimeType($mime_type);
                $resultado = $service->files->create($file, array('data' => file_get_contents($file_path), 'mimeType' => $mime_type, 'uploadType' => 'media'));
                $ruta = 'https://drive.google.com/file/d/' . $resultado->id . '/view';
                if ($stmt = $mysqli->prepare("UPDATE trabajos_institucionales SET titulo = ?, resumen = ?, gestion = ?, id_mod = ?, id_carrera = ?, link_pdf = ? WHERE id_trabajos = $id")) {
                    $stmt->bind_param("sssiis", $titulo, $resumen, $gestion, $modalidad, $carrera, $ruta);
                    $stmt->execute();
                    $exchange = ($stmt->affected_rows > 0) ? true : false;
                    $stmt->close();
                }
            } catch (Google_Service_Exception $gs) {
                $mensaje = json_decode($gs->getMessage());
                echo $mensaje->exchange->message();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            if ($stmt = $mysqli->prepare("UPDATE trabajos_institucionales SET titulo = ?, resumen = ?, gestion = ?, id_mod = ?, id_carrera = ? WHERE id_trabajos = $id")) {
                $stmt->bind_param("sssii", $titulo, $resumen, $gestion, $modalidad, $carrera);
                $stmt->execute();
                $exchange = ($stmt->affected_rows > 0) ? true : false;
                $stmt->close();
            }
        }
    } else {
        $exchange = false;
    }
    if (!$exchange) {
        if (!$mysqli->rollback()) {
            echo '<script>alert("Falló la reversión de la transacción");';
        } else {
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
    echo'window.history.replaceState(null,\'modificacion\',\'./updatetrabajos.php\');window.history.go(-2);</script>';
?>