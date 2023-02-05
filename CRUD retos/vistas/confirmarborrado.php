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
		<title>Confirmar borrado</title>
    </head>
    <body>
        <p>
            ¿Eliminar la categoría "<?php echo $controlador->obtenerNombreReto($_GET) ?>"?
            <br/>
            <button type="button">
                <a href="listado.php">Cancelar</a>
            </button>
            <button type="button">
                <?php echo '<a href="borrar.php?id=' . $_GET['id'] .'"> Eliminar</a>' ?>
            </button>
        </p>
    </body>
</html>