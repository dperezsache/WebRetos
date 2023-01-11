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
		<title>Modificar categorías</title>
    </head>
    <body>
        <?php
            echo '<form action="" method="post">';
            echo '<div id="divForm">';
            echo '<label for="nombre">Introduce nuevo nombre</label><br/>';
            echo '<input type="text" name="nombre" value="' . $controlador->obtenerNombreCategoria($_GET['id']) . '"/>';
            echo '<button type="submit">Actualizar</button> ';
            echo '<button type="submit"><a href="listado.php">Volver atrás</a></button>';
            echo '</div>';
            echo '</form>';

            if(isset($_POST['nombre']) && !empty($_POST['nombre']))
            {
                if($controlador->modificarCategoria($_GET['id'], $_POST['nombre']))
                {
                    echo '<p><span id="exito">Exito:</span> La categoría con ID ' . $_GET['id'] . ' ha sido actualizada.</p>';
                }
                else
                {
                    echo '<p><span id="error">Error:</span> La categoría con ID ' . $_GET['id'] . ' no ha podido ser actualizada.</p>';
                }
            }
        ?>
    </body>
</html>