<div class="contenedor-login">
        <!-- Imagen a la izquierda -->
        <div class="imagen"></div>

        <!-- Formulario a la derecha -->
        <div class="formulario-contenedor crear">
            <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>
            <div class="contenedor-sm">
                <p class="descripcion-pagina">Crear cuenta</p>
                <form method="POST" action="/" class="formulario">
                <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" placeholder="Ingrese su nombre completo" name="nombre">
                    </div>
                    <div class="campo">
                        <label for="email">Correo</label>
                        <input type="email" id="email" placeholder="Ingrese su correo electrónico" name="email">
                    </div>
                    <div class="campo">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" placeholder="Ingrese su contraseña" name="password">
                    </div>
                    <div class="campo">
                        <label for="password2">Repetir contraseña</label>
                        <input type="password" id="password2" placeholder="Repita su contraseña" name="password2">
                    </div>
                    <div class="boton-centrado">
                        <input type="submit" class="boton" value="Iniciar sesión">
                    </div>
                </form>
                <div class="acciones">
                    <a href="/crear">¿Ya tienes cuenta? <span>Iniciar sesión</span></a>
                    <a href="/olvide">¿Olvidaste tu contraseña?</a>
                </div>
            </div><!-- .contenedor-sm -->
        </div><!-- .formulario-contenedor -->
</div><!-- .contenedor-login -->