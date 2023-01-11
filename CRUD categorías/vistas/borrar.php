<?php
    require_once('../controlador/controlador.php');
    $controlador = new ControladorCategorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="../estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Borrar categorías</title>
    </head>
    <body>
        <?php
            if(isset($_GET['id']))
            {
                if($controlador->borrarCategoria($_GET['id']))
                {
                    echo '<p><span id="exito">Exito:</span> La categoría con ID ' . $id . ' ha sido eliminada.</p>';
                }
                else
                {
                    echo '<p><span id="error">Error:</span> La categoría con ID ' . $id . ' no ha podido ser eliminada.</p>';
                }
            }
        ?>
        <div class="divBotones">
            <a href="listado.php"><span class="material-icons">arrow_back</span></a>
        </div>
    </body>
</html>
