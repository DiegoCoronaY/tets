<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hacker Style</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <div class="container">
            <div class="form-container">
                <!-- Formulario de Login -->
                <form action="login.php" method="POST" class="login-form">
                <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Usuario" name="username" autocomplete="username">
                    <input type="password" placeholder="Contraseña" name="password" autocomplete="current-password">
                    <button>Entrar</button>
                    <?php if (isset($_GET['error'])): ?>
                        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
                    <?php endif; ?>
                </form>

                <!-- Formulario de Registro -->
                <form action="si.php" method="POST" class="register-form">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Usuario" name="username" required>
                    <input type="password" placeholder="Contraseña" name="password" autocomplete="new-password" required>
                    <button type="submit">Regístrarse</button>
                    <?php if (isset($_GET['success'])): ?>
                        <p class="success"><?= htmlspecialchars($_GET['success']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
                    <?php endif; ?>
                </form>
                  
            </div>
        </div>
    </main>
</body>
</html>
