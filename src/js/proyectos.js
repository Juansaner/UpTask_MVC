(function() {

    const btnEditarNombre = document.querySelector('.editar-proyecto');
    btnEditarNombre.addEventListener('click', function () {
        mostrarFormulario();
    });

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class='formulario formulario-cambiar-nombre'>
            <legend>Editar nombre</legend>
            <div class='campo'>
                <label>Nombre del proyecto</label>
                <input 
                    type='text' 
                    id='nombre' 
                    name='nombre' 
                    placeholder= 'Renombrar proyecto'
                />
            </div>
            <div class='opciones'>
                <input type='submit' class='submit-nuevo-nombre' value='Guardar cambios'/>
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
                const formulario = document.querySelector('.formulario-cambiar-nombre');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }

            if(e.target.classList.contains('submit-nuevo-nombre')) {
                const nombreProyecto = document.querySelector('#nombre').value.trim();
                if(nombreProyecto === '') {
                    //Mostrar alerta
                    mostrarAlerta('El titulo es obligatorio', 'error', document.querySelector('.formulario-cambiar-nombre legend'));
                    return;
                }
            }
        });

        document.querySelector('body').appendChild(modal);
    };

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

    const listadoProyectos = document.querySelector(".listado-proyectos");

    if(listadoProyectos) {
        listadoProyectos.addEventListener('click', (e) => {
            const btnEliminarProyecto = e.target.closest('.eliminar-proyecto');

            if(btnEliminarProyecto) {
                const proyectoId = btnEliminarProyecto.dataset.proyectoId;
                confirmarEliminarProyecto(proyectoId);
            }

        })
    }

    function confirmarEliminarProyecto(proyectoId) {
        Swal.fire({
            title: '¿Eliminar este proyecto?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                eliminarProyecto(proyectoId);
            }
        });
    }


async function eliminarProyecto(proyectoId) {
        const datos = new FormData();
        datos.append('id', proyectoId);

        console.log('ID que estamos enviando:', proyectoId);
    console.log('FormData:', datos.get('id'));

        try {
            const url = `${location.origin}/api/proyecto/eliminar_proyecto`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            
            const resultado = await respuesta.json();

            if(resultado.respuesta.tipo === 'exito') {
                Swal.fire('Eliminado!', resultado.respuesta.mensaje, 'success');
                setTimeout(() => {
                    window.location.replace(`${location.origin}/dashboard`);
                }, 1500);
            }
        } catch (error) {
            console.log(error);
        }
    }

})();