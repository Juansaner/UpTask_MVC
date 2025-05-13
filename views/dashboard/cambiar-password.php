<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href="/perfil" class="enlace">Volver al perfil</a>
    <form class="formulario" action="/perfil" method="POST">
        <div class="campo">
            <label for="nombre">Contraseña actual</label>
            <input type="password" name="password_actual" placeholder="Ingresa la contraseña actual">
        </div>
        <div class="campo">
            <label for="nombre">Contraseña nueva</label>
            <input type="password" name="password_nuevo" placeholder="Ingresa la contraseña nueva">
        </div>
        <input type="submit" value="Guardar cambios">
    </form>
</div>
<?php include_once __DIR__ . '/footer_dashboard.php'; ?>