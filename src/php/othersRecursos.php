<?php 
include 'conect.php';
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
            AND ti.id_mod =".$_GET['id'] ;
  $resultado = mysqli_query($conexion, $sql);
  $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

  if (!empty($datos)) {
      echo json_encode($datos);
  } else {
      echo json_encode([]);
  }
} else {
  $sql = "SELECT count(id_mod) AS cantidad 
FROM trabajos_institucionales 
  WHERE  id_mod = 5";
  $resultado = mysqli_query($conexion, $sql);
  $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

  if (!empty($datos)) {
      echo json_encode($datos);
  } else {
      echo json_encode([]);
  }
}
