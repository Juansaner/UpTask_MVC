<?php include_once __DIR__ . '/header_dashboard.php'; ?>
<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea">
        <button type="button" class="nueva-tarea" id="nueva-tarea">Nueva tarea</button>
    </div>

    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>
<?php include_once __DIR__ . '/footer_dashboard.php'; ?>

<?php $script = '<script src="build/js/tareas.js"></script>'; ?>