<?php
include 'conect.php';
// echo conexion();



// echo conexion();
$conexion = conexion();

if (isset($_GET['id'])) {
    $sql = "SELECT  ti.*,a.*,t.*, c.*
    FROM trabajos_institucionales AS ti,autor AS a, tutor AS t, 
        trabajos_autor AS ta,trabajos_tutor AS tt, carreras AS c
        WHERE  ta.id_trabajos = ti.id_trabajos
            AND ta.id_autor = a.id_autor
            AND tt.id_trabajos = ti.id_trabajos
            AND tt.id_tutor = t.id_tutor
            AND ti.id_carrera = c.id_carrera
            AND tt.id_trabajos =" . $_GET['id'];
    $resultado = mysqli_query($conexion, $sql);
    $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    if (!empty($datos)) {
        echo json_encode($datos);
    } else {
        echo json_encode([]);
    }
} else {
    $sql = "SELECT  ti.*,a.*,t.*, c.*
    FROM trabajos_institucionales AS ti,autor AS a, tutor AS t, 
        trabajos_autor AS ta,trabajos_tutor AS tt, carreras AS c
        WHERE  ta.id_trabajos = ti.id_trabajos
            AND ta.id_autor = a.id_autor
            AND tt.id_trabajos = ti.id_trabajos
            AND tt.id_tutor = t.id_tutor
            AND ti.id_carrera = c.id_carrera
        ORDER BY ti.id_trabajos DESC LIMIT 5";
    $resultado = mysqli_query($conexion, $sql);
    $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    if (!empty($datos)) {
        echo json_encode($datos);
    } else {
        echo json_encode([]);
    }
}
