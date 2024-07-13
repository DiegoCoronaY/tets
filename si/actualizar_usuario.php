<?php
include 'conexion.php';

// Obtener los datos enviados por AJAX
$data = json_decode(file_get_contents("php://input"));

$id = mysqli_real_escape_string($conexion, $data->id);
$nombre = mysqli_real_escape_string($conexion, $data->nombre);
$contrasena = mysqli_real_escape_string($conexion, $data->contrasena);

// Actualizar el usuario en la base de datos
$sql = "UPDATE plato SET nombre='$nombre', contrasena='$contrasena' WHERE id=$id";

if (mysqli_query($conexion, $sql)) {
    http_response_code(200); // OK
    echo json_encode(array("message" => "Datos actualizados correctamente"));
} else {
    http_response_code(500); // Error del servidor
    echo json_encode(array("message" => "Error al actualizar los datos: " . mysqli_error($conexion)));
}

mysqli_close($conexion);
?>
