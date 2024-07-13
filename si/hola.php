<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios Registrados</title>
<style>
    body {
        background-color: #000;
        color: #0f0;
        font-family: 'Courier New', Courier, monospace;
        padding: 20px;
    }

    h2 {
        text-align: center;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #111;
        box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
    }

    th, td {
        border: 1px solid #0f0;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #090;
    }

    tr:nth-child(even) {
        background-color: #222;
    }

    tr:hover {
        background-color: #333;
    }

    .editar-input {
        width: 80%;
        padding: 8px;
        background-color: #444;
        color: #0f0;
        border: 1px solid #0f0;
    }

    .btn-guardar, .btn-cancelar {
        padding: 6px 10px;
        margin-right: 5px;
        cursor: pointer;
        border: 1px solid #0f0;
        background-color: #090;
        color: #000;
        font-family: 'Courier New', Courier, monospace;
    }

    .btn-cancelar {
        background-color: #f00;
        color: #fff;
    }

    .btn-guardar:hover, .btn-cancelar:hover {
        background-color: #0c0;
    }

    .btn-salir {
        padding: 10px 20px;
        margin: 20px;
        border: 2px solid #f00;
        background-color: #f00;
        color: #fff;
        font-size: 16px;
        font-family: 'Courier New', Courier, monospace;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none; /* Quitamos el subrayado del enlace */
    }

    .btn-salir:hover {
        background-color: #c00;
    }
</style>
</head>
<body>
    <h2>Usuarios Registrados</h2>

    <?php
    include 'conexion.php';

    // Función para actualizar un usuario
    function actualizarUsuario($id, $nombre, $contrasena) {
        global $conexion;
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $contrasena = mysqli_real_escape_string($conexion, $contrasena);

        $sql = "UPDATE plato SET nombre='$nombre', contrasena='$contrasena' WHERE id=$id";

        if (mysqli_query($conexion, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    // Consulta inicial para obtener los usuarios
    $sql = "SELECT id, nombre, contrasena, fecha FROM plato";
    $result = mysqli_query($conexion, $sql);

    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nombre de Usuario</th>";
    echo "<th>Contraseña</th>";
    echo "<th>Fecha de Registro</th>";
    echo "<th>Acciones</th>";
    echo "</tr>";

    // Mostrar cada usuario en una fila de la tabla
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr id='fila-" . $row['id'] . "'>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><span id='nombre-" . $row['id'] . "'>" . $row['nombre'] . "</span><input type='text' class='editar-input' id='input-nombre-" . $row['id'] . "' value='" . $row['nombre'] . "' style='display:none;'></td>";
        echo "<td><span id='contrasena-" . $row['id'] . "'>" . $row['contrasena'] . "</span><input type='text' class='editar-input' id='input-contrasena-" . $row['id'] . "' value='" . $row['contrasena'] . "' style='display:none;'></td>";
        echo "<td>" . $row['fecha'] . "</td>";
        echo "<td>";
        echo "<button class='btn-guardar' id='btn-guardar-" . $row['id'] . "' onclick='guardarUsuario(" . $row['id'] . ")' style='display:none;'>Guardar</button>";
        echo "<button class='btn-cancelar' id='btn-cancelar-" . $row['id'] . "' onclick='cancelarEdicion(" . $row['id'] . ")' style='display:none;'>Cancelar</button>";
        echo "<button class='btn-editar' onclick='editarUsuario(" . $row['id'] . ")'>Editar</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    mysqli_close($conexion);
    ?>

    <a href="index.php" class="btn-salir">Salir</a>

    <script>
    // Función para editar un usuario
    function editarUsuario(id) {
        // Mostrar campos de edición y ocultar campos de texto normales
        document.getElementById('nombre-' + id).style.display = 'none';
        document.getElementById('contrasena-' + id).style.display = 'none';
        document.getElementById('input-nombre-' + id).style.display = 'inline-block';
        document.getElementById('input-contrasena-' + id).style.display = 'inline-block';
        // Mostrar botones de guardar y cancelar, ocultar botón de editar
        document.getElementById('btn-guardar-' + id).style.display = 'inline-block';
        document.getElementById('btn-cancelar-' + id).style.display = 'inline-block';
        document.querySelector('.btn-editar').style.display = 'none';
    }

    // Función para guardar los cambios de un usuario
    function guardarUsuario(id) {
        // Obtener los valores editados
        var nuevoNombre = document.getElementById('input-nombre-' + id).value;
        var nuevaContrasena = document.getElementById('input-contrasena-' + id).value;

        // Enviar los datos al servidor mediante AJAX para actualizar la base de datos
        fetch('actualizar_usuario.php', {
            method: 'POST',
            body: JSON.stringify({ id: id, nombre: nuevoNombre, contrasena: nuevaContrasena }),
            headers: { 'Content-Type': 'application/json' }
        }).then(response => {
            if (response.ok) {
                // Actualizar la interfaz si la respuesta del servidor fue exitosa
                document.getElementById('nombre-' + id).textContent = nuevoNombre;
                document.getElementById('contrasena-' + id).textContent = nuevaContrasena;
                cancelarEdicion(id); // Cancelar modo de edición
            } else {
                // Manejar errores si la respuesta no fue exitosa
                alert('Error al guardar los cambios');
            }
        });
    }

    // Función para cancelar la edición y volver al modo de visualización normal
    function cancelarEdicion(id) {
        // Ocultar campos de edición y mostrar campos de texto normales
        document.getElementById('input-nombre-' + id).style.display = 'none';
        document.getElementById('input-contrasena-' + id).style.display = 'none';
        document.getElementById('nombre-' + id).style.display = 'inline-block';
        document.getElementById('contrasena-' + id).style.display = 'inline-block';
        // Ocultar botones de guardar y cancelar, mostrar botón de editar
        document.getElementById('btn-guardar-' + id).style.display = 'none';
        document.getElementById('btn-cancelar-' + id).style.display = 'none';
        document.querySelector('.btn-editar').style.display = 'inline-block';
    }
    </script>
</body>
</html>
