(function() {

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