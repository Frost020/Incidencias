const form = document.getElementById('form-incidencia');
const mensaje = document.getElementById('mensaje');
const boton = form.querySelector('button[type="submit"]');

form.addEventListener('submit', async (evento) => {
    evento.preventDefault();

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const datos = Object.fromEntries(new FormData(form));

    if (datos.fecha_fin < datos.fecha_inicio) {
        mostrarMensaje('La fecha de fin no puede ser anterior a la fecha de inicio.', 'error');
        return;
    }

    // Evita registros duplicados si el usuario presiona el botón varias veces
    boton.disabled = true;
    boton.textContent = 'Guardando...';

    try {
        const respuesta = await fetch('incidents/create.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos),
        });
        const resultado = await respuesta.json();

        mostrarMensaje(resultado.mensaje, resultado.ok ? 'exito' : 'error');
        if (resultado.ok) {
            form.reset();
        }
    } catch {
        mostrarMensaje('No fue posible comunicarse con el servidor.', 'error');
    } finally {
        boton.disabled = false;
        boton.textContent = 'Guardar incidencia';
    }
});

function mostrarMensaje(texto, tipo) {
    mensaje.textContent = texto;
    mensaje.className = `mensaje ${tipo}`;
}
