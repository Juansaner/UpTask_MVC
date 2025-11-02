(function() {

    obtenerTareas();
    let tareas = [];
    let filtradas = [];
const nuevaTareaBtn = document.querySelector('#nueva-tarea');
nuevaTareaBtn.addEventListener('click', function() {
    mostrarFormulario();
});

//Filtros de busqueda
const filtros = document.querySelectorAll('#filtros input[type="radio"]');
filtros.forEach(filtro => {
    filtro.addEventListener('input', filtrarTareas)
});

function filtrarTareas(e) {
    const filtro = e.target.value;
    if(filtro !== '') {
        filtradas = tareas.filter( tarea => tarea.estado === filtro);
    } else {
        filtradas = [];
    }
    mostrarTareas();
}


async function obtenerTareas() {
    try {
        id = obtenerProyecto();
        url = `/api/tareas?id=${id}`;
        respuesta = await fetch(url);
        resultado = await respuesta.json();
        tareas = resultado.tareas;
        mostrarTareas();
    } catch (error) {
        console.log(error);
    }
}

function mostrarTareas() {
    limpiarTareas();
    totalPendientes();
    totalCompletadas();
    const arrayTareas = filtradas.length ? filtradas : tareas;
    if(arrayTareas.length === 0 ) {
        const contenedorTareas = document.querySelector('#listado-tareas');

        const textoNoTarea = document.createElement('LI');
        textoNoTarea.textContent = 'No hay tareas para mostrar';
        textoNoTarea.classList.add('no-tareas');

        contenedorTareas.appendChild(textoNoTarea);
        return;
    }

    const estados = {
        0: 'Pendiente',
        1: 'Completada'
    }

    arrayTareas.forEach(tarea => {
        const { id, nombre, estado} = tarea;
        const contenedorTarea = document.createElement('LI');
        contenedorTarea.dataset.tareaId = id;
        contenedorTarea.classList.add('tarea');

        const nombreTarea = document.createElement('P');
        nombreTarea.textContent = nombre;
        nombreTarea.ondblclick = function() {
            mostrarFormulario(true, {...tarea});
        }

        const opcionesDiv = document.createElement('DIV');
        opcionesDiv.classList.add('opciones');

        const btnEstadoTarea = document.createElement('BUTTON');
        btnEstadoTarea.classList.add('btn-estado-tarea');
        btnEstadoTarea.classList.add(`${estados[estado].toLowerCase()}`);
        btnEstadoTarea.textContent = estados[estado];
        btnEstadoTarea.dataset.estadoTarea = estado;
        btnEstadoTarea.ondblclick = function() {
            cambiarEstadoTarea({...tarea});
        }

        const btnEliminarTarea = document.createElement('BUTTON');
        btnEliminarTarea.classList.add('btn-eliminar-tarea');
        btnEliminarTarea.dataset.idTarea =id;
        btnEliminarTarea.textContent = 'Eliminar';
        btnEliminarTarea.ondblclick = function() {
            confirmarEliminarTarea({...tarea});
        }

        opcionesDiv.appendChild(btnEstadoTarea);
        opcionesDiv.appendChild(btnEliminarTarea);

        contenedorTarea.appendChild(nombreTarea);
        contenedorTarea.appendChild(opcionesDiv);
        
        const listadoTareas = document.querySelector('#listado-tareas');
        listadoTareas.appendChild(contenedorTarea);
    });
}

function totalPendientes() {
    const totalPendientes = tareas.filter(tarea => tarea.estado === '0');
    const pendientesRadio = document.querySelector('#pendientes');
    if(totalPendientes.length === 0) {
        pendientesRadio.disabled = true;
    } else {
        pendientesRadio.diabled = false;
    }
}

function totalCompletadas() {
    const totalCompletadas = tareas.filter(tarea => tarea.estado === '1');
    const completadasRadio = document.querySelector('#completadas');
    if(totalCompletadas.length === 0) {
        completadasRadio.disabled = true;
    } else {
        completadasRadio.disabled = false;
    }
}

function mostrarFormulario(editar = false, tarea = {}) {
    console.log(tarea);
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
        <form class='formulario'>
            <legend>${editar ? 'Editar tarea' : 'Añadir nueva tarea'}</legend>
            <div class='campo'>
                <label>Tarea</label>
                <input 
                    type='text' 
                    id='tarea' 
                    name='tarea' 
                    placeholder='${editar ? 'Renombrar tarea' : 'Añadir tarea al proyecto actual'}' 
                    value='${editar ? tarea.nombre : ''}'
                />
            </div>
            <div class='opciones'>
                <input type='submit' class='submit-nueva-tarea' value='${editar ? 'Guardar cambios' : 'Añadir tarea'}' />
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
                const nombreTarea = document.querySelector('#tarea').value.trim();
                if(nombreTarea === '') {
                    //Muestra alerta de error
                    mostrarAlerta('El titulo es obligatorio', 'error', document.querySelector('.formulario legend'));
                    return;
                }

                if(editar) {
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                } else {
                    agregarTarea(nombreTarea);
                }
            }
        })
        document.querySelector('.dashboard').appendChild(modal);
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
    referencia.parentElement.insertBefore(alerta, referencia.nextSibling);

    //Eliminar alerta despues de 5 segundos
    setTimeout(() => { 
        alerta.remove();
    }, 5000)
}

function cambiarEstadoTarea(tarea) {
    const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    tarea.estado = nuevoEstado;
    actualizarTarea(tarea);
}

async function actualizarTarea(tarea) {
    const {estado, id, nombre, proyectoId} = tarea;

    const datos = new FormData();
    datos.append('id', id);
    datos.append('estado', estado);
    datos.append('nombre', nombre);
    datos.append('proyectoId', obtenerProyecto());

    try {
        const url = `/api/tarea/actualizar`;
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();
        if(resultado.respuesta.tipo === 'exito') {
            Swal.fire(
                resultado.respuesta.mensaje,
                "Tarea actualizada",
                "success"
            );
            const modal = document.querySelector('.modal');
            if(modal) {
                modal.remove();
            }

            tareas = tareas.map(tareaMemoria => {
                if(tareaMemoria.id === id) {
                    //Actualiza el estado de la tarea en la memoria
                    tareaMemoria.estado = estado;
                    tareaMemoria.nombre = nombre;
                }
                return tareaMemoria;
            });
            //Actualiza el html con el nuevo estado
            mostrarTareas();
        }
    } catch (error) {
        console.log(error);
    }
}

function confirmarEliminarTarea(tarea) {
    Swal.fire({
        title: "¿Eliminar tarea?",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: `No`
      }).then((result) => {
        if (result.isConfirmed) {
            eliminarTarea(tarea);
        }
      });
}

async function eliminarTarea(tarea) {
    const {id, nombre, estado} = tarea;
    const datos = new FormData();
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('estado', estado);
    datos.append('proyectoId', obtenerProyecto());
    try {
        const url = `/api/tarea/eliminar`;
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
        const resultado = await respuesta.json();
        if(resultado.resultado) {
            Swal.fire('¡Eliminada!', resultado.mensaje, 'success');
            //Trae todas las tareas diferentes a la que se va eliminar
            tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== id);
            mostrarTareas();
        }
    } catch (error) {
        console.log(error);
    }
}

//Consultar el servidor para agregar tarea al proyectoactual
async function agregarTarea(tarea) {
    //Construir la peticion
    const datos = new FormData();
    datos.append('nombre', tarea);
    datos.append('proyectoId', obtenerProyecto());

    try {
        const url = `/api/tarea`;
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
        const resultado = await respuesta.json();
        //Muestra alerta de error
        mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario lengend'));
        //Elimina el modal despues de agregar la tarea
        if(resultado.tipo === 'exito') {
            const modal = document.querySelector('.modal');
            setTimeout(() => {
                modal.remove();
            }, 3000)
            //Agregar el objeto de tarea a la variable global de tareas
            const tareaObj = {
                id: String(resultado.id),
                nombre: tarea,
                estado: "0",
                proyectoId: resultado.proyectoId
            }
            tareas = [...tareas, tareaObj];
            mostrarTareas();
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

function limpiarTareas() {
    const listadoTareas = document.querySelector('#listado-tareas');
    
    while(listadoTareas.firstChild) {
        listadoTareas.removeChild(listadoTareas.firstChild);
    }
}

})();