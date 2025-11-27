<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Curso - SurCur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/cursos.css">
  <link rel="stylesheet" href="css/crearCurso.css">
  <style>
    .error-text { color: red; font-size: 0.9em; display: none; }
    #messageBar {
      position: fixed;
      top: 15px;
      right: 15px;
      background-color: #1b4965;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0px 2px 10px rgba(0,0,0,0.2);
      display: none;
      z-index: 9999;
    }
  </style>
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <span class="surcur-text me-3">S U R C U R</span>
      <form class="d-flex mx-auto" role="search"></form>
      <div class="d-flex gap-2">
        <button type="button" class="btn cerrar-sesion-btn">
          <img src="img/icon/usuario.png" alt="Perfil" width="35" height="35">
        </button>
      </div>
    </div>
  </nav>

  <!-- Formulario Crear Curso -->
  <div id="formCrearCurso" class="container my-4" style="max-width: 1200px;">
    <h3>CREAR CURSO</h3>
    <form id="cursoForm" method="POST" action="connection/procesar_curso.php" onsubmit="return validarCurso()">

      <!-- Nombre del curso -->
      <div class="mb-3">
        <label for="nombreCurso" class="form-label">NOMBRE:</label>
        <input type="text" class="form-control" id="nombreCurso" name="nombreCurso" required>
        <div class="error-text" id="errorNombre">Debes ingresar un nombre válido (mínimo 3 caracteres).</div>
      </div>

      <!-- Descripción -->
      <div class="mb-3">
        <label for="descripcionCurso" class="form-label">DESCRIPCIÓN:</label>
        <textarea class="form-control" id="descripcionCurso" name="descripcionCurso" rows="3" required></textarea>
        <div class="error-text" id="errorDescripcion">La descripción debe tener al menos 10 caracteres.</div>
      </div>

      <!-- Carrera y Semestre -->
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="carreraCurso" class="form-label">CARRERA:</label>
          <select class="form-select" id="carreraCurso" name="carreraCurso" required>
            <option value="">Seleccione una carrera</option>
            <option value="Ingeniería en Sistemas Computacionales">Ingeniería en Sistemas Computacionales</option>
            <option value="Ingeniería en Gestión Empresarial">Ingeniería en Gestión Empresarial</option>
            <option value="Ingeniería Industrial">Ingeniería Industrial</option>
            <option value="Ingeniería Electrónica">Ingeniería Electrónica</option>
            <option value="Ingeniería en Semiconductores">Ingeniería en Semiconductores</option>
            <option value="Ingeniería en Sistemas Automotrices">Ingeniería en Sistemas Automotrices</option>
            <option value="Gastronomía">Gastronomía</option>
          </select>
          <div class="error-text" id="errorCarrera">Selecciona una carrera.</div>
        </div>
        <div class="col-md-6">
          <label for="semestreCurso" class="form-label">SEMESTRE:</label>
          <select class="form-select" id="semestreCurso" name="semestreCurso" required>
            <option value="">Seleccione semestre</option>
            <option value="1">1</option><option value="2">2</option><option value="3">3</option>
            <option value="4">4</option><option value="5">5</option><option value="6">6</option>
            <option value="7">7</option><option value="8">8</option><option value="9">9</option>
            <option value="10">10</option><option value="11">11</option><option value="12">12</option>
            <option value="13">13</option>
          </select>
          <div class="error-text" id="errorSemestre">Selecciona un semestre.</div>
        </div>
      </div>

      <!-- Materia y Tema -->
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="materiaCurso" class="form-label">MATERIA:</label>
          <input type="text" class="form-control" id="materiaCurso" name="materiaCurso" required>
          <div class="error-text" id="errorMateria">Ingresa una materia válida.</div>
        </div>
        <div class="col-md-6">
          <label for="temaCurso" class="form-label">TEMA:</label>
          <input type="text" class="form-control" id="temaCurso" name="temaCurso" required>
          <div class="error-text" id="errorTema">Ingresa un tema válido.</div>
        </div>
      </div>

      <!-- Sección de Capítulos -->
      <div id="capitulosSection" style="display:none; margin-top:20px;">
        <h3>AGREGAR CAPÍTULOS</h3>
        <div id="capitulosContainer" class="row g-3"></div>
        <button type="button" class="btn btn-secondary mt-3" id="btnAgregarCapitulo">Añadir Capítulo</button>
      </div>

      <!-- Botones -->
      <div class="d-flex justify-content-end mt-3" id="botonesCurso">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
        <a href="cursos.php" class="btn btn-danger ms-2">CANCELAR</a>
      </div>

    </form>
  </div>

  <!-- Barra de notificación -->
  <div id="messageBar"></div>

<script>
function mostrarMensaje(texto, tipo = "info") {
  const bar = document.getElementById("messageBar");
  bar.style.backgroundColor = tipo === "error" ? "#dc3545" : "#1b4965";
  bar.innerText = texto;
  bar.style.display = "block";
  setTimeout(() => bar.style.display = "none", 2500);
}

function validarCurso() {
  let valido = true;

  const nombre = document.getElementById("nombreCurso");
  const descripcion = document.getElementById("descripcionCurso");
  const carrera = document.getElementById("carreraCurso");
  const semestre = document.getElementById("semestreCurso");
  const materia = document.getElementById("materiaCurso");
  const tema = document.getElementById("temaCurso");

  // Validaciones básicas
  document.getElementById("errorNombre").style.display = nombre.value.trim().length >= 3 ? "none" : "block";
  if (nombre.value.trim().length < 3) valido = false;

  document.getElementById("errorDescripcion").style.display = descripcion.value.trim().length >= 10 ? "none" : "block";
  if (descripcion.value.trim().length < 10) valido = false;

  document.getElementById("errorCarrera").style.display = carrera.value !== "" ? "none" : "block";
  if (carrera.value === "") valido = false;

  document.getElementById("errorSemestre").style.display = semestre.value !== "" ? "none" : "block";
  if (semestre.value === "") valido = false;

  document.getElementById("errorMateria").style.display = materia.value.trim().length >= 2 ? "none" : "block";
  if (materia.value.trim().length < 2) valido = false;

  document.getElementById("errorTema").style.display = tema.value.trim().length >= 2 ? "none" : "block";
  if (tema.value.trim().length < 2) valido = false;

  // Mostrar sección de capítulos si todo el curso es válido
  if (valido) {
    document.getElementById("capitulosSection").style.display = "block";
    mostrarMensaje("Datos del curso válidos. Ahora puedes agregar capítulos.", "info");
  } else {
    mostrarMensaje("Corrige los campos marcados antes de continuar.", "error");
  }

  return valido;
}

// Función para añadir capítulos dinámicamente
document.getElementById("btnAgregarCapitulo")?.addEventListener("click", () => {
  const container = document.getElementById("capitulosContainer");
  const capituloId = Date.now();

  const div = document.createElement("div");
  div.classList.add("col-12");
  div.innerHTML = `
    <div class="card p-3 mb-2">
      <label class="form-label">Título del capítulo:</label>
      <input type="text" class="form-control mb-2" name="capitulos[]" required placeholder="Ej. Introducción">
      <label class="form-label">Descripción:</label>
      <textarea class="form-control" name="descripcionCapitulo[]" rows="2" required placeholder="Describe brevemente este capítulo."></textarea>
    </div>
  `;
  container.appendChild(div);
});
</script>

</body>
</html>
