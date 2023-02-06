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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Consultar retos</title>
    </head>
    <body>
        <h2>Web de Retos - CRUD de retos</h2>
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
                    echo '<p><span id="error">Error:</span> No existe la tabla retos.</p>';
                    break;

                default:
                    echo '<p>Se ha producido un error con código: <b>' . $resultado . '</b>.</p>';
                    break;
            }

            /**
             * Carga el listado con los retos.
             * @param ControladorRetos $controlador Controlador de retos.
             */
            function cargar($controlador)
            {
                $datos = $controlador->obtenerListado();

                echo '<div id="divTabla">';
                echo '<table><thead><tr>';
                echo '<th>ID</th>';
                echo '<th>Reto</th>';
                echo '<th>Dirigido a</th>';
                echo '<th>Descripción</th>';
                echo '<th>Inicio inscripción</th>';
                echo '<th>Fin inscripción</th>';
                echo '<th>Inicio reto</th>';
                echo '<th>Fin reto</th>';
                echo '<th>Publicación</th>';
                echo '<th>¿Publicado?</th>';
                echo '<th>ID profesor</th>';
                echo '<th>Categoría</th>';
                echo '<th colspan="2">Operaciones</th>';
                echo '</tr></thead><tbody>';
               
                while($fila = $datos->fetch_array(MYSQLI_ASSOC))
                {
                    echo '<tr>';

                    foreach($fila as $indice => $valor)
                    {
                        switch($indice)
                        {
                            case 'publicado':
                                if (isset($fila['fechaPublicacion'])) echo '<td>Sí</td>';
                                else echo '<td>No</td>';
                                break;

                            case 'idCategoria':
                                echo '<td>' . $controlador->obtenerCategoria($valor) . '</td>';
                                break;

                            default:
                                echo '<td>' . $valor . '</td>';
                                break;
                        }
                    }

                    echo '<td><p><a href="confirmarborrado.php?id=' . $fila['idReto'] . '"><span class="material-icons">delete</span></a></p></td>';
                    echo '<td><p><a href="modificar.php?id=' . $fila['idReto'] . '"><span class="material-icons">edit</span></a></p></td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table></div>';
            }
        ?>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
    </body>
</html>
