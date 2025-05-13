<?php include_once __DIR__ . '/header_dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <a href="/cambiar-password" class="enlace">Cambiar contraseña</a>
    <form class="formulario" action="" method="POST">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" value="<?php echo $usuario->nombre; ?>" name="nombre" placeholder="Ingresa el nombre">
        </div>
        <div class="campo">
            <label for="email">Correo</label>
            <input type="email" value="<?php echo $usuario->email; ?>" name="email" placeholder="Ingresa el correo">
        </div>
        <input type="submit" value="Guardar cambios">
    </form>
</div>
<?php include_once __DIR__ . '/footer_dashboard.php'; ?>