<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();
    $nombre = $controlador->obtenerNombreCategoria($_GET);

    // Si no se puede obtener el nombre de la categoría es porque no existe, redireccionar al listado.
    if(!$nombre)
    {
        header('Location: listado.php');
    }
    else
    {
        include('../includes/header.php');
        include('../includes/navcategorias.php');
    }
?>
<div id="divTitulo">
    <h1>Borrado de categoría</h1>
</div>

<div id="divContenido">
    <div class="aviso">
        <p>¿Eliminar la categoría "<b><?php echo $nombre ?></b>"?</p>

        <button type="button" class="botonRojo">
            <a href="listado.php">Cancelar</a>
        </button>

        <button type="button" class="botonVerde">
            <?php echo '<a href="borrar.php?id=' . $_GET['id'] .'"> Eliminar</a>' ?>
        </button>
    </div>
</div>
<?php
    include('../includes/footer.php');
?>