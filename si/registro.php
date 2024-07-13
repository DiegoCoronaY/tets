<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $hashed_password = hash('sha256', $password);

    $sql = "SELECT * FROM plato WHERE nombre = '$username' AND contrasena = '$hashed_password'";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) == 1) {
        session_start();
        $_SESSION['username'] = $username;
        header("Location: hola.php");
        exit();
    } else {
        header("Location: index.php?error=" . urlencode("Nombre de usuario o contraseña incorrectos"));
        exit();
    }

    mysqli_close($conexion);
}
?>
