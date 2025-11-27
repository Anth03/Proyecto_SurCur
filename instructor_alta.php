<?php 
session_start();
include 'connection/conn.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Error: No estás autenticado.";
    exit;
}

// Obtener el ID del usuario logueado
$id_usuario = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alta Instructor - SurCur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/cursos.css">
    <style>
        body { background-color: #e3ecf1 !important; }
            .text-primary { color: #14405c !important; }
            .btn-primary { background-color: #14405c !important; border-color: #14405c !important; color:white!important; font-weight:bold; }
            .btn-primary:hover { background-color: #1b4965 !important; border-color:#1b4965!important; }
        #regresar{
            text-decoration: none;
            color: #4f75b6ff;
            margin-top: 100px !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <span class="surcur-text me-3">S U R C U R</span>

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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4 text-primary fw-bold">DAR ALTA COMO INSTRUCTOR</h3>
                        <?php
                            if (!empty($_SESSION['error'])) {
                                echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                                unset($_SESSION['error']);
                            }
                        ?>
                        <form id="formInstructor" method="POST" action="connection/alta_instructor.php">
                            <div class="mb-3">
                                <label class="form-label">CÓDIGO</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Ingresa el código de instructor" required>
                            </div>
                            <button type="submit" id="btnRegistrar" class="btn btn-primary w-100" disabled>REGISTRARSE</button>
                            <button id="btnRegresar">REGRESAR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("btnRegresar").addEventListener("click", function() {
            window.location.href = "cursos.php"; 
        });

        document.getElementById('codigo').addEventListener('input', function() {
            var codigo = document.getElementById('codigo').value;
            var btnRegistrar = document.getElementById('btnRegistrar');

            // Si el código es correcto, habilitar el botón
            if (codigo === 'S21120170') {
                btnRegistrar.disabled = false;
            } else {
                btnRegistrar.disabled = true;
            }
        });
    </script>

</body>
</html>
