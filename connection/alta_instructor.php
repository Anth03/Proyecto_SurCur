<?php
session_start();
include 'conn.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: No estás autenticado.";
    exit;
}

// Obtener el ID del usuario logueado
$id_usuario = $_SESSION['usuario_id'];

// Verificar que el código recibido sea correcto
if ($_POST['codigo'] === 'S21120170') {
    // Actualizar el rol del usuario a Instructor
    $sql = "UPDATE usuarios SET rol = 'Instructor' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);

    if ($stmt->execute()) {
        $_SESSION['success'] = "¡Ahora eres Instructor!";
        header("Location: ../cursos.php"); // Redirige a la página de cursos
        exit();
    } else {
        $_SESSION['error'] = "Hubo un error al cambiar tu rol.";
        header("Location: instructor_alta.php"); // Redirige de vuelta con error
        exit();
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Código incorrecto.";
    header("Location: instructor_alta.php"); // Redirige de vuelta con error
    exit();
}
?>
