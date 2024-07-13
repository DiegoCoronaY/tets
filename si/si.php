<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $sql = "INSERT INTO plato (nombre, contrasena, fecha) VALUES ('$username', '$password', NOW())";

    if (mysqli_query($conexion, $sql)) {
        header("Location: hola.php");
        exit();
    } else {
        header("Location: index.php?error=" . urlencode("Error en el registro: " . mysqli_error($conexion)));
        exit();
    }

    mysqli_close($conexion);
}
?>