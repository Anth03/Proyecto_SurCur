<?php
// connection/procesar_capitulo.php
include 'conn.php'; // conexión a la DB

// Verificamos que se reciban todos los datos necesarios
if(isset($_POST['curso_id'], $_POST['nombre'], $_POST['descripcion'], $_POST['orden'])) {
    $curso_id = $_POST['curso_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $orden = $_POST['orden'];
    $link = $_POST['link'] ?? ''; // Link opcional

    // Debug: Verifica que el curso_id no sea 0
    if ($curso_id == 0) {
        echo "Error: curso_id es 0 o no se recibió correctamente";
        exit;
    }

    // Preparar y ejecutar inserción en la base de datos
    $stmt = $conn->prepare("INSERT INTO capitulos (curso_id, nombre, descripcion, orden, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $curso_id, $nombre, $descripcion, $orden, $link);

    if($stmt->execute()){
        echo "Capítulo guardado correctamente";
    } else {
        echo "Error al guardar el capítulo: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Faltan datos del capítulo";
}

$conn->close();
?>
