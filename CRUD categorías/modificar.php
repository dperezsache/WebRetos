<!-- David Pérez Saché -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="estilos.css"/>
		<title>Modificar categorías</title>
    </head>
    <body>
        <?php
            require_once('conexion.php');

            try
            {
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                    
                    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                    $consulta = "SELECT nombreCategoria FROM categorias WHERE idCategoria='$id'";
                    $datos = $conexion->query($consulta);
                    
                    $fila = $datos->fetch_array(MYSQLI_ASSOC);
                    
                    echo '<form action="" method="post"/>';
                    echo '<div id="divForm">';
                    echo '<label for="nombre">Introduce nuevo nombre</label><br/>';
                    echo '<input type="text" name="nombre" value="' . $fila['nombreCategoria'] . '"/>';
                    echo '<button type="submit">Actualizar</button> ';
                    echo '<button type="submit"><a href="consultar.php">Volver atrás</a></button>';
                    echo '</div>';
                    echo '</form>';
                    
                    if(isset($_POST['nombre']) && $_POST['nombre'] != '')
                    {
                        $nombre = $_POST['nombre'];
                        $consulta = "UPDATE categorias SET idCategoria='$id', nombreCategoria='$nombre' WHERE idCategoria='$id'";
                        $conexion->query($consulta);
                        
                        if($conexion->affected_rows > 0)
                        {
                            echo '<p><span id="exito">Exito:</span> La categoría con ID ' . $id . ' ha sido actualizada.</p>';
                        }
                        else 
                        {
                            echo '<p><span id="error">Error:</span> La categoría con ID ' . $id . ' no ha podido ser actualizada.</p>';
                        }
                        
                        $conexion->close();
                    }
                }
                else
                {
                    echo '<p><span id="error">Error:</span> El proceso no se puede realizar.</p>';
                }
            }
            catch(mysqli_sql_exception $e)
            {
                echo '<p><span id="error">Error:</span> (' . $e->getCode() . ') ' . $e->getMessage() . '</p>';
            }
        ?>
    </body>
</html>