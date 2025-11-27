// Función para mostrar el mensaje en la barra de notificación
function showMessage(message, type) {
    const messageBar = document.getElementById('messageBar');

    // Ajustamos el contenido y el color según el tipo
    messageBar.textContent = message;

    if (type === 'success') {
        messageBar.classList.add('success');
        messageBar.classList.remove('error');
    } else {
        messageBar.classList.add('error');
        messageBar.classList.remove('success');
    }

    // Mostramos la barra de notificación
    messageBar.style.display = 'block';

    // Ocultamos la barra después de 5 segundos
    setTimeout(() => {
        messageBar.style.display = 'none';
    }, 5000); // El mensaje desaparece después de 5 segundos
}

// Evento cuando se envíe el formulario del curso
cursoForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Evitamos que se recargue o cambie de página

    // Desactivar el botón de guardar al hacer clic
    const guardarBtn = cursoForm.querySelector("button[type='submit']");
    guardarBtn.style.display = "none"; // Ocultamos el botón de guardar

    // Preparamos los datos del curso
    const formData = new FormData(cursoForm);

    // Enviamos los datos al procesar_curso.php usando fetch
    fetch('connection/procesar_curso.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // La respuesta debe ser el ID del curso insertado
        cursoIdCreado = parseInt(data); // Guardamos el ID del curso creado

        // Si el ID es inválido, mostramos un error
        if (isNaN(cursoIdCreado) || cursoIdCreado <= 0) {
            showMessage('Error al guardar el curso.', 'error');
            return;
        }

        // Mostramos la sección de capítulos y ocultamos los botones del curso
        botonesCurso.style.display = "none";
        capitulosSection.style.display = "block";

        showMessage('Curso guardado correctamente. Ahora puedes añadir capítulos.', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error al conectar con el servidor.', 'error');
    });
});

// Función para agregar un capítulo
function agregarCapitulo() {
    if(cursoIdCreado === null){
        showMessage("Primero guarda el curso antes de agregar capítulos.", 'error');
        return;
    }

    const colDiv = document.createElement("div");
    colDiv.className = "col-12 col-md-6";

    const capDiv = document.createElement("div");
    capDiv.className = "capitulo";

    const orden = capitulosContainer.children.length + 1;

    capDiv.innerHTML = `
        <button type="button" class="cap-borrar">
            <img src="img/icon/borrar.png">
        </button>

        <div class="cap-content">
            <div class="mb-2">
                <label class="form-label">NOMBRE</label>
                <input type="text" class="form-control cap-nombre" required>
            </div>

            <div class="mb-2">
                <label class="form-label">DESCRIPCIÓN</label>
                <textarea class="form-control cap-descripcion" rows="2" required></textarea>
            </div>

            <div class="mb-2">
                <label class="form-label">LINK</label>
                <input type="url" class="form-control cap-link">
            </div>

            <input type="hidden" class="cap-orden" value="${orden}">
        </div>

        <div class="cap-buttons">
            <button type="button" class="btn cap-guardar">GUARDAR CAPÍTULO</button>
        </div>
    `;

    capDiv.querySelector(".cap-borrar").addEventListener("click", () => {
        colDiv.remove();
        // Reajustamos el orden de los capítulos
        Array.from(capitulosContainer.children).forEach((c, i) => {
            const inputOrden = c.querySelector('.cap-orden');
            inputOrden.value = i + 1;
        });
    });

    capDiv.querySelector(".cap-guardar").addEventListener("click", () => {
        const nombre = capDiv.querySelector(".cap-nombre").value;
        const descripcion = capDiv.querySelector(".cap-descripcion").value;
        const link = capDiv.querySelector(".cap-link").value;
        const orden = capDiv.querySelector(".cap-orden").value;

        // Desactivar el botón de guardar al hacer clic
        const guardarCapituloBtn = capDiv.querySelector(".cap-guardar");
        const borrarIcon = capDiv.querySelector(".cap-borrar");
        
        guardarCapituloBtn.style.display = "none"; // Ocultamos el botón de guardar
        borrarIcon.style.display = "none"; // Ocultamos el icono de borrar

        const formData = new FormData();
        formData.append("curso_id", cursoIdCreado); // Asociamos el curso_id
        formData.append("nombre", nombre);
        formData.append("descripcion", descripcion);
        formData.append("link", link);
        formData.append("orden", orden);

        // Enviamos los datos del capítulo a procesar_capitulo.php
        fetch('connection/procesar_capitulo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            showMessage("Capítulo guardado correctamente.", 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error al guardar el capítulo.', 'error');
        });
    });

    colDiv.appendChild(capDiv);
    capitulosContainer.appendChild(colDiv);
}

// Evento para agregar un capítulo
btnAgregarCapitulo.innerHTML = `<img src="img/icon/agregar.png"> AGREGAR`;
btnAgregarCapitulo.addEventListener("click", agregarCapitulo);
