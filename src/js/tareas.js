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
        document.querySelector('body').appendChild(modal);
}

function submitFormularioNuevaTarea() {
    const tarea = document.querySelector('#tarea').value.trim();
    
    if(tarea === '') {
        //Muestra alerta de error
    }
}
})();