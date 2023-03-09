<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();
    
    session_start();
    $nombre = $controlador->obtenerNombreReto($_GET);
    
    // Si no se puede obtener el nombre del reto es porque no existe, redireccionar al listado.
    if(!$nombre)
    {
        header('Location: listado.php');
    }
    else
    {
        include('../includes/header.php');
        include('../includes/navretos.php');
    }
?>
<div id="divTitulo">
    <h1>Publicación de reto</h1>
</div>

<div id="divContenido">
    <div class="aviso">
        <p class="my-3">
            ¿Publicar el reto <b>"<?php echo $nombre ?>"</b>?
        </p>
        <button type="button" class="botonRojo">
            <a href="listado.php">Cancelar</a>
        </button>
        <button type="button" class="botonVerde">
            <?php echo '<a href="publicar.php?id=' . $_GET['id'] .'"> Publicar</a>' ?>
        </button>
    </div>
</div>
<?php
    include('../includes/footer.php');
?>