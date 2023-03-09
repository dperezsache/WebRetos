<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();

    include('../includes/header.php');
    include('../includes/navretos.php');
?>
<div id="divTitulo">
    <h1>Borrado de reto</h1>
</div>

<div id="divContenido">
    <?php
        $resultado = $controlador->borrarReto($_GET);
        
        switch($resultado)
        {
            case -1:
                echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                break;

            case 0:
                echo '<div class="error">Error: El reto a borrar ya no existe.</div>';
                break;

            case 1: // Caso OK
                echo '<div class="exito">Exito: El reto ha sido eliminado.</div>';
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
<?php
    include('../includes/footer.php');
?>