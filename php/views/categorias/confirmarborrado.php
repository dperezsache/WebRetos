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
        <div class="navElementoTitulo">Generación de PDFs</div>
        <div class="navElemento">
            <a href="../generar/index.php">Generar</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
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