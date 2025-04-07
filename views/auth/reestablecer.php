<div class="contenedor-login">
        <!-- Imagen a la izquierda -->
        <div class="imagen"></div>

        <!-- Formulario a la derecha -->
        <div class="formulario-contenedor reestablecer">
            <?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>
            <div class="contenedor-sm">
                <p class="descripcion-pagina">Coloca tu nueva contraseña</p>
                <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
                <form method="POST" action="/reestablecer" class="formulario">
                    <div class="campo">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" placeholder="Ingrese su contraseña" name="password">
                    </div>
                    <div class="boton-centrado">
                        <input type="submit" class="boton" value="Guardar contraseña">
                    </div>
                </form>
                <div class="acciones">
                    <a href="/crear">¿Aún no tienes una cuenta? <span>Crear una</span></a>
                    <a href="/olvide">¿Olvidaste tu contraseña?</a>
                </div>
            </div><!-- .contenedor-sm -->
        </div><!-- .formulario-contenedor -->
</div><!-- .contenedor-login -->

