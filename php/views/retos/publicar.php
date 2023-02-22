<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();

    include('../includes/header.php');
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
        <h1>Publicación de reto</h1>
    </div>

    <div id="divContenido">
        <?php
            $resultado = $controlador->publicarReto($_GET);
            
            switch($resultado)
            {
                case -1:
                    echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    echo '<div class="error">Error: No se puede publicar el reto.</div>';
                    break;

                case 1: // Caso OK
                    echo '<div class="exito">Exito: El reto ha sido publicado.</div>';
                    break;

                case 2:
                    echo '<div class="error">Error: El reto ya es público.</div>';
                    break;

                case 1146:
                    echo '<div class="error">Error: No existe la tabla de retos.</div>';
                    break;
                    
                default:
                    echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b></div>';
                    break;
            }
        ?>
        <div class="divBoton">
            <a href="listado.php">
                <span class="material-icons">arrow_back</span>
            </a>
        </div>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>