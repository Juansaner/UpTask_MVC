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
        document.querySelector('body').appendChild(modal);
}
})();