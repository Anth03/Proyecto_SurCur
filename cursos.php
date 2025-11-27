<?php
// Incluir la conexión a la base de datos
include 'connection/conn.php';

// Iniciar sesión para acceder al ID del usuario logueado
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: No estás autenticado.";
    exit;
}

// Obtener el ID del usuario logueado
$id_usuario = $_SESSION['usuario_id']; // Suponiendo que el ID del usuario está guardado en $_SESSION['usuario_id']

// Verificar el rol del usuario en la base de datos
$sql = "SELECT rol FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Si no se encuentra el usuario o no tiene rol de instructor
if ($row && $row['rol'] == 'Instructor') {
    $mostrarAgregarCurso = true; // El usuario es Instructor
} else {
    $mostrarAgregarCurso = false; // El usuario no es Instructor
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cursos - SurCur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/cursos.css">
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <span class="surcur-text me-3">S U R C U R</span>

      <!-- Verifica si el usuario es Instructor para mostrar el botón correspondiente -->
      <?php if ($mostrarAgregarCurso): ?>
        <button id="btnCrearCurso" class="btn crear-curso">AGREGAR CURSO</button>
      <?php else: ?>
        <button id="btnSerInstructor" class="btn crear-curso" onclick="window.location.href='instructor_alta.php'">SER INSTRUCTOR</button>
      <?php endif; ?>

      <form class="d-flex mx-auto" role="search">
        <div class="input-group search-group">
          <input class="form-control search-input" type="search" placeholder="Buscar curso" aria-label="Buscar">
          <button class="btn search-btn" type="submit">
            <img src="img/icon/lupa.png" alt="Buscar" style="width: 20px; height: 20px;">
          </button>
        </div>
      </form>

      <div class="d-flex gap-2">
        <button class="btn cerrar-sesion-btn">
          <img src="img/icon/usuario.png" alt="Perfil" width="35" height="35">
        </button>
        <button class="btn cerrar-sesion-btn">
          <a href="connection/logout.php">
            <img src="img/icon/cerrar-sesion.png" alt="Cerrar sesión" width="28" height="28">
          </a>
        </button>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <div class="row g-4">
      <h3>C R E A D O S</h3>
      <!-- Aquí se generarán las tarjetas de los cursos creados por el usuario -->
      <div id="cursosCreados" class="row g-4"></div>
    </div>
  </div>

  <!-- Tarjetas de los cursos en los que el usuario está inscrito (Estáticas) -->
  <div class="container my-5">
    <div class="row g-4">
      <h3>I N S C R I T O</h3>
      <!-- Tarjetas estáticas de ejemplo -->
      <div class="col-md-3">
        <div class="card shadow-sm position-relative" style="min-height: 400px;">
          <img src="https://picsum.photos/400/250?6" class="card-img-top" alt="Curso 1" style="height:200px; object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title">INTRODUCCIÓN A LA PROGRAMACIÓN</h5>
            <p class="card-text">Aprende los fundamentos de la lógica y la programación desde cero.</p>
          </div>
          <button class="btn btn-primary" style="position:absolute; bottom:0; left:0; width:100%; border-radius:0 0 10px 10px;">Ver curso</button>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm position-relative" style="min-height: 400px;">
          <img src="https://picsum.photos/400/250?7" class="card-img-top" alt="Curso 2" style="height:200px; object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title">DESARROLLO WEB CON HTML, CSS Y JS</h5>
            <p class="card-text">Crea tus primeras páginas web modernas y responsivas utilizando HTML, CSS y JavaScript.</p>
          </div>
          <button class="btn btn-primary" style="position:absolute; bottom:0; left:0; width:100%; border-radius:0 0 10px 10px;">Ver curso</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("btnCrearCurso").addEventListener("click", function() {
      window.location.href = "crearCurso.php"; 
    });

    // Fetch para obtener los cursos creados por el usuario
    fetch('connection/obtener_cursos.php')
      .then(response => response.json())
      .then(cursos => {
        const cursosCreadosContainer = document.getElementById('cursosCreados');
        
        cursos.forEach(curso => {
          const colDiv = document.createElement('div');
          colDiv.classList.add('col-md-3');

          const cardDiv = document.createElement('div');
          cardDiv.classList.add('card', 'shadow-sm', 'position-relative');
          cardDiv.style.minHeight = '400px';

          cardDiv.innerHTML = `
            <img src="https://picsum.photos/400/250?random=${curso.id}" class="card-img-top" alt="${curso.nombre}" style="height:200px; object-fit:cover;">
            <div class="card-body">
              <h5 class="card-title">${curso.nombre}</h5>
              <p class="card-text">${curso.descripcion}</p>
            </div>
            <button class="btn btn-primary" style="position:absolute; bottom:0; left:0; width:100%; border-radius:0 0 10px 10px;">Editar curso</button>
          `;

          colDiv.appendChild(cardDiv);
          cursosCreadosContainer.appendChild(colDiv);
        });
      })
      .catch(error => console.error('Error al obtener los cursos:', error));
  </script>

</body>
</html>
