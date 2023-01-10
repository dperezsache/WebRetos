<!-- David Pérez Saché -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Borrar categorías</title>
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
                    $consulta = "DELETE FROM categorias WHERE idCategoria='$id'";
                    $conexion->query($consulta);
                    
                    if($conexion->affected_rows > 0)
                    {
                        echo '<p><span id="exito">Exito:</span> La categoría con ID ' . $id . ' ha sido eliminada.</p>';
                    }
                    else
                    {
                        echo '<p><span id="error">Error:</span> La categoría con ID ' . $id . ' no ha podido ser eliminada.</p>';
                    }

                    $conexion->close(); 
                }
            }
            catch(mysqli_sql_exception $e)
            {
                echo '<p><span id="error">Error:</span> (' . $e->getCode() . ') ' . $e->getMessage() . '</p>';
            }

            echo '<div class="divBotones"><a href="consultar.php"><span class="material-icons">arrow_back</span></a></div>';
        ?>
    </body>
</html>
