<div class="contenedor">
    <h1>TaskFlow</h1>
    <p>Transforma tus pendientes en acciones</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar sesión</p>
        <form method="POST" action="/" class="formulario">
            <div class="campo">
                <label for="email">Correo</label>
                <input type="email" id="email" placeholder="Ingrese su correo electrónico" name="email">
            </div>

            <div class="campo">
                <label for="password">Correo</label>
                <input type="password" id="password" placeholder="Ingrese su contraseña" name="password">
            </div>
            <div class="boton-centrado">
                <input type="submit" class="boton" value="Iniciar sesión">
            </div>
        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? <span>Crear una</span></a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>