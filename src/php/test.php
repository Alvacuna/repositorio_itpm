<?php
include 'conect.php';
$conexion = conexion();
$sql = "SELECT * 
FROM trabajos_institucionales
INNER JOIN carreras 
ON trabajos_institucionales.id_trabajos = carreras.id_carrera";
$resultado = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

if (!empty($datos)) {
  echo json_encode($datos);
} else {
  echo json_encode([]);
}
