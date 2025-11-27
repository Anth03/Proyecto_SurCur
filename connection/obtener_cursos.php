<?php
session_start();
require_once 'conn.php';  // Incluir la conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: No estás autenticado.";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];  // Obtener el ID del usuario logueado

// Consultar los cursos creados por el usuario
$query = "SELECT * FROM cursos WHERE id_creador = ?";  // Obtener cursos del usuario
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$cursos = [];
while ($row = $result->fetch_assoc()) {
    $cursos[] = $row;  // Guardar los cursos en un array
}

$stmt->close();
$conn->close();

// Devolver los cursos en formato JSON
echo json_encode($cursos);
?>
