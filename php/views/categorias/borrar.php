<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    include('../includes/header.php');
    include('../includes/navcategorias.php');
?>
<div id="divTitulo">
    <h1>Borrado de categoría</h1>
</div>

<div id="divContenido">
    <?php
        $resultado = $controlador->borrarCategoria($_GET);
        
        switch($resultado)
        {
            case -1:
                echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                break;

            case 0:
                echo '<div class="error">Error: La categoría a borrar ya no existe.</div>';
                break;

            case 1: // Caso OK
                echo '<div class="exito">Exito: La categoría ha sido eliminada.</div>';
                break;

            case 1146:
                echo '<div class="error">Error: No existe la tabla categorías.</div>';
                break;
                
            default:
                echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                break;
        }
    ?>
    <div class="divBoton">
        <a href="listado.php">
            <span class="material-icons">arrow_back</span>
        </a>
    </div>
</div>
<?php
    include('../includes/footer.php');
?>