const mobileMenuBtn = document.querySelector('#mobile-menu');
const cerrarMenuBtn = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');
const contenedorMenu = document.querySelector('.menu');

if(mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function() {
        sidebar.classList.add('mostrar');
        contenedorMenu.style.display = 'none';
    });
}

if(cerrarMenuBtn) {
    cerrarMenuBtn.addEventListener('click', function() {
        sidebar.classList.add('ocultar');
        setTimeout(() => {
            contenedorMenu.style.display = 'block';
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');
        }, 200);
    });
}

//Elimina la clase de mostrar en un tamaño de pantalla mayor
const anchoPantalla = document.body.clientWidth;
window.addEventListener('resize', function() {
    const anchoPantalla = document.body.clientWidth;
    if(anchoPantalla >= 768) {
        sidebar.classList.remove('mostrar');
    }
});