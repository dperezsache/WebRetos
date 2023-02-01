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
		<title>Consultar categorías</title>
    </head>
    <body>
        <h2>Web de Retos - CRUD de categorías</h2>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
        <?php
            $resultado = $controlador->hayListado();
            
            switch($resultado)
            {
                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    echo '<p>No hay datos que mostrar.</p>';
                    break;

                case 1: // Caso OK
                    cargar($controlador);
                    break;

                case 1146:
                    echo '<p><span id="error">Error:</span> No existe la tabla categorías.</p>';
                    break;

                default:
                    echo '<p>Se ha producido un error con código: <b>' . $resultado . '</b>.</p>';
                    break;
            }

            /**
             * Carga el listado con las categorías.
             * @param ControladorCategorias $controlador Controlador de categorías.
             */
            function cargar($controlador)
            {
                $datos = $controlador->obtenerListado();

                echo '<table><thead><tr>';
                echo '<th>ID</th>';
                echo '<th>Categoría</th>';
                echo '<th colspan="2">Operaciones</th>';
                echo '</tr></thead><tbody>';
                
                while($fila = $datos->fetch_array(MYSQLI_ASSOC))
                {
                    echo '<tr>';

                    foreach($fila as $valor)
                    {
                        echo '<td>' . $valor . '</td>';
                    }

                    echo '<td><p><a href="confirmarborrado.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">delete</span></a></p></td>';
                    echo '<td><p><a href="modificar.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">edit</span></a></p></td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            }
        ?>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
    </body>
</html>
