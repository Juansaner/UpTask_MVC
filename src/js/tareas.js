(function() {
const nuevaTareaBtn = document.querySelector('#nueva-tarea');
nuevaTareaBtn.addEventListener('click', mostrarFormulario);

function mostrarFormulario() {
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class='formulario'>
            <legend>Añadir nueva tarea</legend>
            <div class='campo'>
                <label>Tarea</label>
                <input type='text' id='tarea' name='tarea' placeholder='Añadir tarea al proyecto actual'  />
            </div>
            <div class='opciones'>
                <input type='submit' class='submit-nueva-tarea' value='Añadir tarea' />
                <button type='button' class='cerrar-modal'>Cancelar</button>
            </div>
        </form>
        `;    

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if(e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
        })
        document.querySelector('.dashboard').appendChild(modal);
}

function submitFormularioNuevaTarea() {
    const tarea = document.querySelector('#tarea').value.trim();
    if(tarea === '') {
        //Muestra alerta de error
        mostrarAlerta('El titulo es obligatorio', 'error', document.querySelector('.formulario'));
        return;
    }
    agregarTarea(tarea);
}

function mostrarAlerta(mensaje, tipo, referencia) {
    //Previene la creacion de multiples alertas
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.classList.add('alerta', tipo);
    alerta.textContent = mensaje;
    //Inserta la alerta antes del legend
    referencia.insertBefore(alerta, document.querySelector('legend').nextSibling);

    //Eliminar alerta despues de 5 segundos
    setTimeout(() => { 
        alerta.remove();
    }, 5000)
}

//Consultar el servidor para agregar tarea al proyectoactual
async function agregarTarea(tarea) {
    //Construir la peticion
    const datos = new FormData();
    datos.append('nombre', tarea);
    datos.append('proyectoId', obtenerProyecto());

    try {
        const url = 'http://localhost:3000/api/tarea';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
        const resultado = await respuesta.json();
        //Muestra alerta de error
        mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario'));
        //Elimina el modal despues de agregar la tarea
        if(resultado.tipo === 'exito') {
            const modal = document.querySelector('.modal');
            setTimeout(() => {
                modal.remove();
            }, 3000)
        }
    } catch(error) {
        console.log(error);
    }
}

function obtenerProyecto() {
    const proyectoParams = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParams.entries());
    return proyecto.id;
}
})();