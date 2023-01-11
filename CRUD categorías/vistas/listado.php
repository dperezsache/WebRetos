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
		<title>Consultar categorías</title>
    </head>
    <body>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
        <?php
            $datos = $controlador->getListado();

            if($datos != null)
            {
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

                    echo '<td><p><a href="borrar.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">delete</span></a></p></td>';
                    echo '<td><p><a href="modificar.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">edit</span></a></p></td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table>';
            }
            else
            {
                echo '<p>No hay datos que mostrar.</p>';
            }
        ?>
        <div class="divBotones">
            <a href="insertar.php"><span class="material-icons">add</span></a>
        </div>
    </body>
</html>
