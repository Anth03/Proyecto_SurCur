<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - SurCur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #e3ecf1 !important; }
    .text-primary { color: #14405c !important; }
    .btn-primary { background-color: #14405c !important; border-color: #14405c !important; color:white!important; font-weight:bold; }
    .btn-primary:hover { background-color: #1b4965 !important; border-color:#1b4965!important; }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow">
        <div class="card-body">
          <h3 class="text-center mb-4 text-primary fw-bold">I N I C I A R <br> S E S I Ó N</h3>

          <?php
          if (!empty($_SESSION['error'])) {
              echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
              unset($_SESSION['error']);
          }
          ?>

          <form method="POST" action="connection/procesar_login.php">
            <div class="mb-3">
              <label class="form-label">Correo electrónico</label>
              <input type="email" name="correo" class="form-control" placeholder="usuario@alumnos.itsur.edu.mx" required maxlength="100">
            </div>

            <div class="mb-3">
              <label class="form-label">Contraseña</label>
              <input type="password" name="contrasena" class="form-control" placeholder="********" required minlength="8" maxlength="60">
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
          </form>

          <p class="text-center mt-3 mb-0">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
