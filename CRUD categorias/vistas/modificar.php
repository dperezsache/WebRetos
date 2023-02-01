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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Modificar categorías</title>
    </head>
    <body>
        <form action="" method="post">
            <div id="divForm">
                <label for="nombre">
                    Nuevo nombre de categoría <input type="text" name="nombre" value="<?php echo $controlador->obtenerNombreCategoria($_GET) ?>"/>
                </label>
                <br/>
                <button type="reset">Borrar</button>
                <button type="submit">Modificar</button>
            </div>
        </form>
        <?php
            $resultado = $controlador->modificarCategoria($_GET, $_POST);
            
            switch($resultado)
            {
                case -2:
                    echo '<p><span id="error">Error:</span> Introduciste nombre de categoría en blanco.</p>';
                    break;

                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<p><span id="exito">Exito:</span> La categoría ha sido modificada.</p>';
                    break;

                case 1062:
                    echo '<p><span id="error">Error:</span> Ya existe una categoría con ese nombre.</p>';
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