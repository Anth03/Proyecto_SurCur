<?php
// Incluir la conexión a la base de datos
include 'conn.php';

// Iniciar sesión para acceder al ID del usuario logueado
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: No estás autenticado.";
    exit;
}

// Obtener el ID del usuario logueado
$id_creador = $_SESSION['usuario_id']; // Suponiendo que el ID del usuario está guardado en $_SESSION['usuario_id']

// Recibir los datos del curso desde el formulario
$nombre = $_POST['nombreCurso'];
$descripcion = $_POST['descripcionCurso'];
$carrera = $_POST['carreraCurso'];
$semestre = $_POST['semestreCurso'];
$materia = $_POST['materiaCurso'];
$tema = $_POST['temaCurso'];

// Insertar el curso en la base de datos, incluyendo el ID del creador
$stmt = $conn->prepare("INSERT INTO cursos (nombre, descripcion, carrera, semestre, materia, tema, fecha_creacion, id_creador) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("sssissi", $nombre, $descripcion, $carrera, $semestre, $materia, $tema, $id_creador);
$stmt->execute();

// Obtener el ID del curso recién creado
$curso_id = $conn->insert_id;

// Verificación del curso_id
if ($curso_id == 0) {
    echo "Error: curso_id no se generó correctamente";
    exit;
}

// Devolver el ID del curso creado
echo $curso_id;

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
