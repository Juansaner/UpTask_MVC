<div class="dashboard">
    <?php include_once __DIR__ .  "/../templates/sidebar.php"; ?>

    <div class="principal">
        <?php include_once __DIR__ . '/../templates/barra.php'; ?>

        <?php $enProyecto = isset($_GET['id']) ;?>
            
        <?php if($enProyecto) { ;?>
            <div class="contenedor-volver">
                <i class="fa-solid fa-arrow-left"></i>
                <a href="/dashboard" class="btn-volver"> Volver a proyectos</a>
            </div>
        <?php } ;?>

        <div class="contenido">
            <h2 class="nombre-pagina"> <?php echo $titulo;?></h2>