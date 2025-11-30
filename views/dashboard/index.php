<?php include_once __DIR__ . '/header_dashboard.php'; ?>
<?php if(count($proyectos) === 0) { ?>
    <p class="no-proyecto">No hay proyectos para mostrar <a href="/crear-proyecto">Comienza creando uno</a></p>
<?php } else {  ?>
    
    <ul class='listado-proyectos'>
        <?php foreach($proyectos as $proyecto) { ?>
            <li class="proyecto">
                <div class="btn-acciones">
                    <button type="button" class="btn eliminar-proyecto" id="eliminar-proyecto" data-proyecto-id="<?php echo $proyecto->url; ?>"><i class="fa-regular fa-trash-can"></i> Eliminar</button>
                    <button type="button" class="btn editar-proyecto" data-proyecto-id="<?php echo $proyecto->url; ?>" data-proyecto-nombre="<?php echo $proyecto->proyecto; ?>"><i class="fa-regular fa-pen-to-square"></i> Editar</button>
                </div>
                <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                    <?php echo $proyecto->proyecto; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php include_once __DIR__ . '/footer_dashboard.php'; ?>
<?php $script .= ' 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/proyectos.js"></script>
'; ?>