<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_control = trim($_POST['no_control']);
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];
    $rol = $_POST['rol'];

    // Validar campos vacíos
    if ($no_control === '' || $nombre === '' || $correo === '' || $contrasena === '' || $rol === '') {
        $_SESSION['mensaje'] = 'Rellena todos los campos.';
        header('Location: ../register.php');
        exit();
    }

    // Validar contraseñas iguales
    if ($contrasena !== $contrasena2) {
        $_SESSION['mensaje'] = 'Las contraseñas no coinciden.';
        header('Location: ../register.php');
        exit();
    }

    // Verificar que el correo no exista
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['mensaje'] = 'El correo ya está registrado.';
        header('Location: ../register.php');
        exit();
    }
    $stmt->close();

    // 🔐 Encriptar la contraseña antes de guardar
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar usuario con la contraseña hasheada
    $stmt = $conn->prepare("INSERT INTO usuarios (no_control, nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $no_control, $nombre, $correo, $hash, $rol);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'Registro exitoso. Ya puedes iniciar sesión.';
        header('Location: ../login.php');
    } else {
        $_SESSION['mensaje'] = 'Error al registrar usuario.';
        header('Location: ../register.php');
    }

    $stmt->close();
    exit();
} else {
    header('Location: ../register.php');
    exit();
}
?>
