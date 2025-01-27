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

// Procesar el registro de nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "El usuario ya está registrado.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES ('$usuario', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['usuario'] = $usuario;
            header("Location: dashboard.php"); // Redirigir a una página de usuario autenticado
            exit();
        } else {
            $error = "Hubo un error al registrar al usuario.";
        }
    }
}

$conn->close();
?>

<!-- HTML de la página de registro -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="login_styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrarse</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
        <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a></p>
    </div>
</body>
</html>
