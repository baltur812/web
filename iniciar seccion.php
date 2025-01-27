<?php
session_start();

// Configuración de la base de datos (deberías personalizarlo con tus credenciales)
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "mi_base_de_datos";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario existe, iniciar sesión
        $_SESSION['usuario'] = $usuario;
        header("Location: dashboard.php"); // Redirigir a una página de usuario autenticado
        exit();
    } else {
        // El usuario no existe o la contraseña es incorrecta
        $error = "Usuario o contraseña incorrectos.";
    }
}

$conn->close();
?>

<!-- HTML de la página de inicio de sesión -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
        <p><a href="register.php">¿No tienes cuenta? Regístrate aquí</a></p>
    </div>
</body>
</html>
