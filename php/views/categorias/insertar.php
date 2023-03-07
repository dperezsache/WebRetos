<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    include('../includes/header.php');
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
            <a href="../../script/generarpdf.php?op=1">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../../script/generarpdf.php?op=2">Listado de retos</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Alta de categoría</h1>
    </div>

    <div id="divContenido">
        <form id="formAlta" action="" method="POST">
            <div class="formItem">
                <label for="nombre">
                    Nombre de la categoría <input type="text" name="nombre" maxlength="100"/>
                </label>
            </div>
            <div class="formItem">
                <button type="reset" class="botonRojo">Borrar</button>
                <button type="submit" class="botonVerde">Añadir</button> 
            </div>
        </form>

        <?php
            $resultado = $controlador->altaCategoria($_POST);
            
            switch($resultado)
            {
                case -2:
                    echo '<div class="error">Error: No has introducido nada.</div>';
                    break;

                case -1:
                    echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<div class="exito">Exito: La categoría ha sido añadida.</div>';
                    break;

                case 1062:
                    echo '<div class="error">Error: La categoría que has introducido ya existe.</div>';
                    break;

                case 1146:
                    echo '<div class="error">Error: No existe la tabla categorías.</div>';
                    break;

                default:
                    echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                    break;
            }
        ?>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>