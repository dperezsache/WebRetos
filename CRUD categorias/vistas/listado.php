<?php
    require_once('../controlador/controladorcategorias.php');
    $controlador = new ControladorCategorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<title>Consultar categorías</title>
    </head>
    <body>
        <h2 class="text-center my-3">Web de Retos - CRUD de categorías</h2>

        <div class="text-center my-3">
            <a href="insertar.php">
                <button class="text-center mx-auto btn btn-success">
                    <i class="bi bi-plus-lg text-light"></i>
                </button>
            </a>
        </div>

        <table class="table text-center table-bordered table-hover mx-auto my-2 w-50">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th colspan="2">Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $resultado = $controlador->hayListado();
                    
                    switch($resultado)
                    {
                        case -1:
                            echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No hay conexión con la base de datos.</div>';
                            break;

                        case 0:
                            echo '<div class="alert alert-warning my-3 mx-auto" style="width: 350px;">No hay datos que mostrar.</div>';
                            break;

                        case 1: // Caso OK
                            break;

                        case 1146:
                            echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No existe la tabla categorías.</div>';
                            break;

                        default:
                            echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                            break;
                    }

                    if($resultado == 1)
                    {
                        $datos = $controlador->obtenerListado();
                        
                        while($fila = $datos->fetch_array(MYSQLI_ASSOC))
                        {
                            echo '<tr>';

                            foreach($fila as $valor)
                            {
                                echo '<td>' . $valor . '</td>';
                            }

                            echo '<td><p class="d-inline"><a href="confirmarborrado.php?id=' . $fila['idCategoria'] . '"><i class="bi bi-trash3-fill" style="font-size: 1.5em;"></i></a></p>';
                            echo '<p class="d-inline"><a href="modificar.php?id=' . $fila['idCategoria'] . '"><i class="bi bi-pencil-fill" style="font-size: 1.5em;"></i></a></p></td>';
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
        <div class="text-center my-3">
            <a href="insertar.php">
                <button class="text-center mx-auto btn btn-success">
                    <i class="bi bi-plus-lg text-light"></i>
                </button>
            </a>
        </div>
    </body>
</html>
