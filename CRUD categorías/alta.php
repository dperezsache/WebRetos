<!-- David Pérez Saché -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="estilos.css"/>
		<title>Añadir categorías</title>
    </head>
    <body>
        <?php
            require_once('conexion.php');

            echo '<form action="" method="post"/>';
            echo '<div id="divForm">';
            echo '<label for="nombre">Nombre categoría</label><br/>';
            echo '<input type="text" name="nombre"/>';
            echo '<button type="submit">Añadir</button> ';
            echo '<button><a href="consultar.php">Consultar</a></button>';
            echo '</div></form>';

            try
            {
                if(isset($_POST['nombre']) && $_POST['nombre'] != '')
                {
                    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                    $consulta = "INSERT INTO categorias(nombreCategoria) VALUES('" . $_POST['nombre'] . "');";
                    $conexion->query($consulta);
                    
                    if($conexion->affected_rows > 0)
                    {
                        echo '<p><span id="exito">Exito:</span> La categoría ha sido añadida.</p>';
                    }
                    else 
                    {
                        echo '<p><span id="error">Error:</span> La categoría no ha sido añadida.</p>';
                    }
                    
                    $conexion->close();
                }
            }
            catch(mysqli_sql_exception $e)
            {
                echo '<p><span id="error">Error:</span> (' . $e->getCode() . ') ' . $e->getMessage() . '</p>';
            }
        ?>
    </body>
</html>