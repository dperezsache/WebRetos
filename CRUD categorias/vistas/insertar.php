<?php
    require_once('../controlador/controlador.php');
    $controlador = new ControladorCategorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
		<title>Añadir categorías</title>
    </head>
    <body>
        <form action="" method="post">
            <div id="divForm">
                <label for="nombre">
                    Nombre categoría <input type="text" name="nombre"/>
                </label>
                <br/>
                <button type="submit">Añadir</button> 
            </div>
        </form>
        <?php
            $resultado = $controlador->altaCategoria($_POST);
            
            switch($resultado)
            {
                case -2:
                    echo '<p><span id="error">Error:</span> No has introducido nada.</p>';
                    break;

                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<p><span id="exito">Exito:</span> La categoría ha sido añadida.</p>';
                    break;

                case 1062:
                    echo '<p><span id="error">Error:</span> La categoría que has introducido ya existe.</p>';
                    break;

                default:
                    echo '<p>Se ha producido un error con código: <b>' . $resultado . '</b>.</p>';
                    break;
            }
        ?>
        <button id="botonListado" type="button">
            <a href="listado.php">Volver al listado</a>
        </button>
    </body>
</html>