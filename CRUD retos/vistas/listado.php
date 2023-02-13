<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <title>Consultar retos</title>
    </head>
    <body>
        <h2 class="text-center my-3">Web de Retos - CRUD de retos</h2>
        
        <div class="text-center my-3">
            <a href="insertar.php">
                <button class="text-center mx-auto btn btn-success">
                    <i class="bi bi-plus-lg text-light"></i>
                </button>
            </a>
        </div>

        <form class="text-center" method="POST" action="" id="formBusqueda">
            <div class="form-group mx-1 my-1">
                <label for="busqueda">
                    Buscar por nombre de reto <input type="text" placeholder="" class="form-control" name="busqueda"/>
                </label>

                <button type="reset" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <table class="table text-center table-bordered table-hover mx-auto my-2" style="width: 90%;">
            <thead class="table-dark">
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
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $resultado = $controlador->hayListado($_POST);
                
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
                        echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No existe la tabla retos.</div>';
                        break;

                    default:
                        echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
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

                            echo '<td><p class="d-inline"><a href="confirmarborrado.php?id=' . $fila['idReto'] . '"><i class="bi bi-trash3-fill" style="font-size: 1.5em;"></i></a></p>';
                            echo '<p class="d-inline"><a href="modificar.php?id=' . $fila['idReto'] . '"><i class="bi bi-pencil-fill" style="font-size: 1.5em;"></i></a></p></td></tr>';
                        }
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
