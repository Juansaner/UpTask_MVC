<div class="contenedor-login">
        <!-- Imagen a la izquierda -->
        <div class="imagen"></div>

        <!-- Formulario a la derecha -->
        <div class="formulario-contenedor olvide">
            <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>
            <div class="contenedor-sm">
            <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
                <p class="descripcion-pagina">Recupera tu acceso TaskFlow</p>
                <form method="POST" action="/olvide" class="formulario" novalidate>
                    <div class="campo">
                        <label for="email">Correo</label>
                        <input type="email" id="email" placeholder="Ingrese su correo electrónico" name="email">
                    </div>
                    <div class="boton-centrado">
                        <input type="submit" class="boton" value="Enviar instrucciones">
                    </div>
                </form>
                <div class="acciones">
                    <a href="/">¿Ya tienes cuenta? <span>Iniciar sesión</span></a>
                    <a href="/crear">¿Aún no tienes una cuenta? <span>Crear una</span></a>
                </div>
            </div><!-- .contenedor-sm -->
        </div><!-- .formulario-contenedor -->
</div><!-- .contenedor-login -->