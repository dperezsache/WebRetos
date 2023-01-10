<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Consultar categorías</title>
    </head>
    <body>
        <?php
            require_once('conexion.php');

            echo '<div class="divBotones"><a href="alta.php"><span class="material-icons">add</span></a></div>';

            try
            {
                $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                $consulta = 'SELECT * FROM categorias ORDER BY idCategoria ASC';
                $datos = $conexion->query($consulta);

                if($datos->num_rows > 0)
                {
                    echo '<table><thead><tr>';
                    echo '<th>ID</th>';
                    echo '<th>Categoría</th>';
                    echo '<th colspan="2">Operaciones</th>';
                    echo '</tr></thead><tbody>';
                    
                    while($fila = $datos->fetch_array(MYSQLI_ASSOC))  // MYSQLI_ASSOC: Solo poder acceder al array de filas mediante el índice asociativo.
                    {
                        echo '<tr>';

                        foreach($fila as $valor)
                        {
                            echo '<td>' . $valor . '</td>';
                        }

                        echo '<td><p><a href="borrado.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">delete</span></a></p></td>';
                        echo '<td><p><a href="modificar.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">edit</span></a></p></td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody></table>';
                }
                else
                {
                    echo '<p>No hay datos que mostrar.</p>';
                }
                
                $conexion->close(); 
            }
            catch(mysqli_sql_exception $e)
            {
                echo '<p><span id="error">Error:</span> (' . $e->getCode() . ') ' . $e->getMessage() . '</p>';
            }
            
            echo '<div class="divBotones"><a href="alta.php"><span class="material-icons">add</span></a></div>';
        ?>
    </body>
</html>
