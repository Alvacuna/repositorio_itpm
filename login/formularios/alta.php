<?php
    require 'conexion.php';
    include 'apidrive/vendor/autoload.php';
    putenv('GOOGLE_APPLICATION_CREDENTIALS=subir-archivos-1-73e866de05c4.json');
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
    try {
        $resumen = $_POST['resumen'];
        $titulo = $_POST['titulo'];
        $apellido = $_POST['apellido'];
        $autor = $_POST['autor'];
        $tutor = $_POST['tutor'];
        $id_mod = $_POST['modalidad'];
        $carrera = $_POST['carrera'];
        $gestion = $_POST['gestion'];
        $service = new Google_Service_Drive($client);
        $file_path = $_FILES['archivos']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);
        $file = new Google_Service_Drive_DriveFile();
        $file->setName($titulo);
        $file->setParents(array("18WrywNyRQ3AAQU1xJMf-jZgTashyy45Y"));
        $file->setMimeType($mime_type);
        $resultado = $service->files->create($file,array('data'=>file_get_contents($file_path),'mimeType'=>$mime_type,'uploadType'=>'media'));
        $ruta = 'https://drive.google.com/open?id='.$resultado->id;
        $sql = "INSERT INTO trabajos_institucionales (titulo,resumen,gestion,link_pdf,id_mod,id_carrera) VALUES ('$titulo','$resumen','$gestion','$ruta','$id_mod','$carrera')";
        $mysqli->query($sql);
        $sql = "SELECT id_trabajos FROM trabajos_institucionales WHERE link_pdf='$ruta'";
        $id_trabajos = $mysqli->query($sql);
        echo '<a href="'.$ruta.'" target="blank">'.$resultado->name.'</a>';
        $sql = "INSERT INTO autor (apellido_autor,nombre_autor) VALUES ('$apellido','$autor')";
        $mysqli->query($sql);
        $sql = "SELECT id_autor FROM autor WHERE apellido_autor='$apellido' AND nombre_autor='$autor'";
        $id_autor = ($mysqli->query($sql));
        $sql = "INSERT INTO trabajos_autor (id_trabajos,id_autor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE link_pdf='$ruta'),(SELECT id_autor FROM autor WHERE apellido_autor='$apellido' AND nombre_autor='$autor'))";
        $mysqli->query($sql);
        $sql = "INSERT INTO trabajos_tutor (id_trabajos,id_tutor) VALUES ((SELECT id_trabajos FROM trabajos_institucionales WHERE link_pdf='$ruta'),(SELECT id_tutor FROM tutor WHERE id_tutor='$tutor'))";
        $mysqli->query($sql);
    } catch (Google_Service_Exception $gs) {
        $mensaje = json_decode($gs->getMessage());
        echo $mensaje->error->message();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>