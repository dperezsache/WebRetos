<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Borrar categorías</title>
    </head>
    <body>
        <?php
            $resultado = $controlador->borrarReto($_GET);
            
            switch($resultado)
            {
                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    echo '<p><span id="error">Error:</span> El reto a borrar ya no existe.</p>';
                    break;

                case 1: // Caso OK
                    echo '<p><span id="exito">Exito:</span> El reto ha sido eliminado.</p>';
                    break;

                case 1146:
                    echo '<p><span id="error">Error:</span> No existe la tabla de retos.</p>';
                    break;
                    
                default:
                    echo '<p>Se ha producido un error con código: ' . $resultado . '.</p>';
                    break;
            }
        ?>
        <div class="divBotones">
            <a href="listado.php"><span class="material-icons">arrow_back</span></a>
        </div>
    </body>
</html>
