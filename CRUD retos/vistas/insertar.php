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
		<title>Añadir reto</title>
    </head>
    <body>
        <h2 class="text-center my-3">Insertar reto</h2>

        <form class="bg-light mx-auto text-center border border-secondary rounded" style="width: 350px;" action="" method="post">
            <div class="form-group my-2">
                <label for="nombre">
                    Nombre reto <input type="text" class="form-control" name="nombre" maxlength="100"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="dirigido">
                    Dirigido a <input type="text" class="form-control" name="dirigido" maxlength="100"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="categoria">
                    Categoría
                    <select name="categoria" class="form-select">
                        <?php
                            $datos = $controlador->obtenerCategorias();
                            while($fila = $datos->fetch_array(MYSQLI_ASSOC)) 
                                echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                        ?>
                    </select>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="fechaInicioIns">
                    Fecha inicio de inscripción <input type="datetime-local" class="form-control" name="fechaInicioIns"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="fechaFinIns">
                    Fecha fin de inscripción <input type="datetime-local" class="form-control" name="fechaFinIns"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="fechaInicioReto">
                    Fecha inicio del reto <input type="datetime-local" class="form-control" name="fechaInicioReto"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="fechaFinReto">
                    Fecha fin del reto <input type="datetime-local" class="form-control" name="fechaFinReto"/>
                </label>
            </div>
            <div class="form-group my-2">
                <label for="descReto">
                    Descripción <textarea rows="8" class="form-control" name="descReto"></textarea>
                </label>
            </div>
            <div class="my-2">
                <button type="reset" class="btn btn-secondary">Cancelar</button>
                <button type="submit" class="btn btn-primary">Añadir reto</button>
            </div>
        </form>
        <?php
            $resultado = $controlador->altaReto($_POST);
            
            switch($resultado)
            {
                case -13:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: Fecha de fin de reto incorrecta.</div>';
                    break;

                case -12:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: Fecha de inicio de reto incorrecta.</div>';
                    break;
    
                case -11:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: Fecha de fin de inscripción incorrecta.</div>';
                    break;

                case -10:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: Fecha de inicio de inscripción incorrecta.</div>';
                    break;

                case -9:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido descripción.</div>';
                    break;

                case -8:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido fecha de fin de reto.</div>';
                    break;

                case -7:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido fecha de inicio de reto.</div>';
                    break;
    
                case -6:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido fecha de fin de inscripción.</div>';
                    break;

                case -5:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido fecha de inicio de inscripción.</div>';
                    break;

                case -4:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido descripción.</div>';
                    break;

                case -3:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido a quien va dirigido el reto.</div>';
                    break;

                case -2:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido nada.</div>';
                    break;

                case -1:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<div class="alert alert-success my-3 mx-auto" style="width: 350px;">Exito: El reto ha sido añadido.</div>';
                    break;

                case 1062:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: El reto que has introducido ya existe.</div>';
                    break;

                case 1136:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: El nº de columnas a insertar no coincide con el nº de columnas de la tabla.</div>';
                    break;

                case 1146:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No existe la tabla de retos.</div>';
                    break;

                default:
                    echo '<div class="alert alert-warning my-3 mx-auto" style="width: 350px;">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                    break;
            }
        ?>
        <div class="text-center my-3">
            <a href="listado.php">
                <button class="text-center mx-auto btn btn-success">
                    <i class="bi bi-arrow-left text-light"></i>
                </button>
            </a>
        </div>
    </body>
</html>