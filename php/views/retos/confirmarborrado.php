<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();
    $nombre = $controlador->obtenerNombreReto($_GET);

    // Si no se puede obtener el nombre del reto es porque no existe, redireccionar al listado.
    if (!$nombre)
    {
        header('Location: listado.php');
    }
    else
    {
        include('../includes/header.php');
    }
?>
<main>
    <nav>
        <div class="navElementoTitulo">Gestión de retos</div>
        <div class="navElemento">
            <a href="listado.php">Listado de retos</a>
        </div>
        <div class="navElemento">
            <a href="insertar.php">Alta de retos</a>
        </div>
        <div class="navElemento">
            <a href="modificar.php">Modificar retos</a>
        </div>
        <div class="navElementoTitulo">Gestión de categorías</div>
        <div class="navElemento">
            <a href="../categorias/listado.php">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../categorias/insertar.php">Alta de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../categorias/modificar.php">Modificar categorías</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Borrado de reto</h1>
    </div>

    <div id="divContenido">
        <div class="aviso">
            <p class="my-3">
                ¿Eliminar el reto <b>"<?php echo $nombre ?>"</b>?
            </p>
            <button type="button" class="botonRojo">
                <a href="listado.php">Cancelar</a>
            </button>
            <button type="button" class="botonVerde">
                <?php echo '<a href="borrar.php?id=' . $_GET['id'] .'"> Eliminar</a>' ?>
            </button>
        </div>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>