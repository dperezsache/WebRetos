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
		<title>Añadir categorías</title>
    </head>
    <body>
        <form action="" method="post">
            <div id="divForm">
                <label for="nombre">Nombre categoría</label><br/>
                <input type="text" name="nombre"/>

                <button type="submit">Añadir</button> 
                <button><a href="listado.php">Consultar</a></button>
            </div>
        </form>
        <?php
            if(isset($_POST['nombre']) && !empty($_POST['nombre']))
            {
                if($controlador->altaCategoria($_POST['nombre']))
                {
                    echo '<p><span id="exito">Exito:</span> La categoría ha sido añadida.</p>';
                }
                else
                {
                    echo '<p><span id="error">Error:</span> La categoría no ha sido añadida.</p>';
                }
            }
        ?>
    </body>
</html>