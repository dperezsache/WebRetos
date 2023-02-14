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
        <title>Listado de retos</title>
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
            <div class="form-group d-inline mx-1 my-1">
                <label for="busqueda">
                    Buscar por nombre de reto <input type="text" placeholder="" class="form-control" name="busqueda"/>
                </label>
            </div>
            <div class="form-group d-inline mx-1 my-1">
                <label for="filtrado">
                    Filtrar por categoría
                    <select name="filtrado" class="form-select">
                        <option value="-1">Sin filtro</option>
                        <?php
                            $categorias = $controlador->obtenerCategorias();
                            while($fila = $categorias->fetch_array(MYSQLI_ASSOC))
                                echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                        ?>
                    </select>
                </label>
            </div>
            <div class="d-block my-2">
                <button type="reset" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <table class="table text-center table-bordered table-hover mx-auto my-2 w-50">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Reto</th>
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
                                    case 'idReto':
                                        echo '<td>' . $fila['idReto'] . '</td>';
                                        break;

                                    case 'nombreReto':
                                        echo '<td>' . $fila['nombreReto'] . '</td>';
                                        break;

                                    case 'idCategoria':
                                        echo '<td>' . $controlador->obtenerCategoria($valor) . '</td>';
                                        break;
                                }
                            }

                            echo '<td><p class="d-inline"><a href="confirmarborrado.php?id=' . $fila['idReto'] . '"><i class="bi bi-trash3-fill mx-1" style="font-size: 1.25em;"></i></a></p>';
                            echo '<p class="d-inline"><a href="modificar.php?id=' . $fila['idReto'] . '"><i class="bi bi-pencil-fill mx-1" style="font-size: 1.25em;"></i></a></p>';
                            echo '<p class="d-inline"><a href="consultar.php?id=' . $fila['idReto'] . '"><i class="bi bi-search mx-1" style="font-size: 1.25em;"></i></a></p></td>';
                            
                            echo '</tr>';
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
