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

        <form method="POST" action="" id="formBusqueda">
            <label for="busqueda">
                Buscar por nombre de reto <input type="text" name="busqueda"/>
            </label>
            <div>
                <button type="reset">Cancelar</button>
                <button type="submit">Buscar</button>
            </div>
        </form>
        <div id="divTabla">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reto</th>
                        <th>Dirigido a</th>
                        <th>Descripción</th>
                        <th>Inicio inscripción</th>
                        <th>Fin inscripción</th>
                        <th>Inicio reto</th>
                        <th>Fin reto</th>
                        <th>Publicación</th>
                        <th>¿Publicado?</th>
                        <th>ID profesor</th>
                        <th>Categoría</th>
                        <th colspan="2">Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $resultado = $controlador->hayListado($_POST);
                    
                    switch($resultado)
                    {
                        case -1:
                            echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                            break;

                        case 0:
                            echo '<p>No hay datos que mostrar.</p>';
                            break;

                        case 1: // Caso OK
                            break;

                        case 1146:
                            echo '<p><span id="error">Error:</span> No existe la tabla retos.</p>';
                            break;

                        default:
                            echo '<p>Se ha producido un error con código: <b>' . $resultado . '</b>.</p>';
                            break;
                    }

                    if($resultado == 1)
                    {
                        $datos = $controlador->obtenerListado();

                        if($datos != null)
                        {
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
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
    </body>
</html>
