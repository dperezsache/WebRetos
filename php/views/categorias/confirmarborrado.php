<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();
    $nombre = $controlador->obtenerNombreCategoria($_GET);

    if(!$nombre)
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
            <a href="../retos/listado.php">Listado de retos</a>
        </div>
        <div class="navElemento">
            <a href="../retos/insertar.php">Alta de retos</a>
        </div>
        <div class="navElemento">
            <a href="../retos/modificar.php">Modificar retos</a>
        </div>
        <div class="navElementoTitulo">Gestión de categorías</div>
        <div class="navElemento">
            <a href="listado.php">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="insertar.php">Alta de categorías</a>
        </div>
        <div class="navElemento">
            <a href="modificar.php">Modificar categorías</a>
        </div>
    </nav>

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
</main>
<?php
    include('../includes/footer.php');
?>