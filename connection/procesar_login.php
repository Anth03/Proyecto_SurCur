<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']); // importante

    // Validar campos vacíos
    if ($correo === '' || $contrasena === '') {
        $_SESSION['error'] = 'Rellena ambos campos.';
        header('Location: ../login.php');
        exit();
    }

    // Buscar usuario por correo
    $stmt = $conn->prepare("SELECT id, no_control, nombre, correo, contrasena, rol FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verificación segura con password_verify()
        if (password_verify($contrasena, $user['contrasena'])) {
            session_regenerate_id(true); // Previene secuestro de sesión

            // Guardar datos del usuario en la sesión
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['no_control'] = $user['no_control'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir a la página original (cursos.php)
            header('Location: ../cursos.php');
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = 'Contraseña incorrecta.';
            header('Location: ../login.php');
            exit();
        }
    } else {
        // Usuario no encontrado
        $_SESSION['error'] = 'Correo no registrado.';
        header('Location: ../login.php');
        exit();
    }

    $stmt->close();
    exit();

} else {
    header('Location: ../login.php');
    exit();
}
?>
