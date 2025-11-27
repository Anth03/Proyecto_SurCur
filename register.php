<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro - SurCur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #e3ecf1 !important; }
    .text-primary { color: #14405c !important; }
    .btn-primary { background-color: #14405c !important; border-color: #14405c !important; color:white!important; font-weight:bold; }
    .btn-primary:hover { background-color: #1b4965 !important; border-color:#1b4965!important; }
    .error-text { color: red; font-size: 0.9em; display: none; }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow">
        <div class="card-body">
          <h3 class="text-center text-primary mb-4 fw-bold">R E G I S T R A R S E</h3>

          <?php
          if (!empty($_SESSION['mensaje'])) {
              echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
              unset($_SESSION['mensaje']);
          }
          ?>

          <form id="registroForm" method="POST" action="connection/procesar_register.php" onsubmit="return validarFormulario(event)">
            
            <!-- Número de control -->
            <div class="mb-3">
              <label class="form-label">Número de control</label>
              <input type="text" name="no_control" id="no_control" class="form-control" placeholder="Ej. S21120184"
                    required pattern="S21120[0-9]{3}">
              <div class="error-text" id="errorControl">Debe iniciar con <b>S21120</b> y terminar con tres dígitos.</div>
            </div>

            <!-- Nombre y apellidos -->
            <div class="mb-3">
              <label class="form-label">Nombre(s)</label>
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Sebastián" required maxlength="80">
            </div>
            <div class="mb-3">
              <label class="form-label">Apellidos</label>
              <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ej. Pérez Gómez" required maxlength="100">
            </div>

            <!-- Rol -->
            <div class="mb-3">
              <label class="form-label">Rol</label>
              <select name="rol" id="rol" class="form-select" required>
                <option value="" selected disabled>Selecciona tu rol</option>
                <option value="Estudiante">Estudiante</option>
              </select>
            </div>

            <!-- Correo institucional -->
            <div class="mb-3">
              <label class="form-label">Correo institucional</label>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="s21120184@alumnos.itsur.edu.mx" required maxlength="100">
              <div class="error-text" id="errorCorreo">Debe coincidir con el formato institucional: <b>s21120XXX@alumnos.itsur.edu.mx</b></div>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Escribe tu contraseña" required>
              <div class="error-text" id="errorPassword">La contraseña no puede estar vacía.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmar contraseña</label>
              <input type="password" name="contrasena2" id="contrasena2" class="form-control" placeholder="Repite la contraseña" required>
              <div class="error-text" id="errorConfirm">Las contraseñas no coinciden.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
          </form>

          <p class="text-center mt-3 mb-0">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function validarFormulario(e) {
  const noControl = document.getElementById("no_control").value.trim();
  const correo = document.getElementById("correo").value.trim();
  const pass = document.getElementById("contrasena").value;
  const pass2 = document.getElementById("contrasena2").value;

  const regexControl = /^S21120[0-9]{3}$/;
  const regexCorreo = /^s21120[0-9]{3}@alumnos\.itsur\.edu\.mx$/;

  let valido = true;

  // Número de control
  document.getElementById("errorControl").style.display = regexControl.test(noControl) ? "none" : "block";
  if (!regexControl.test(noControl)) valido = false;

  // Correo institucional
  document.getElementById("errorCorreo").style.display = regexCorreo.test(correo) ? "none" : "block";
  if (!regexCorreo.test(correo)) valido = false;

  // Contraseña (solo verificar que no esté vacía)
  document.getElementById("errorPassword").style.display = pass.length > 0 ? "none" : "block";
  if (pass.length === 0) valido = false;

  // Confirmar contraseña
  document.getElementById("errorConfirm").style.display = pass === pass2 ? "none" : "block";
  if (pass !== pass2) valido = false;

  return valido;
}
</script>

</body>
</html>
