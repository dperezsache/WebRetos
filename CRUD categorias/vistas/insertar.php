<?php
    require_once('../controlador/controladorcategorias.php');
    $controlador = new ControladorCategorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<title>Añadir categorías</title>
    </head>
    <body>
        <h2 class="text-center my-3">Insertar categoría</h2>

        <form class="bg-light mx-auto text-center border border-secondary rounded" style="width: 350px;" action="" method="post">
            <div class="form-group my-2">
                <label for="nombre">
                    Nombre de la categoría <input type="text" name="nombre" maxlength="100"/>
                </label>
            </div>

            <button type="reset" class="btn btn-secondary my-2">Borrar</button>
            <button type="submit" class="btn btn-primary my-2">Añadir</button> 
        </form>

        <?php
            $resultado = $controlador->altaCategoria($_POST);
            
            switch($resultado)
            {
                case -2:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No has introducido nada.</div>';
                    break;

                case -1:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<div class="alert alert-success my-3 mx-auto" style="width: 350px;">Exito: La categoría ha sido añadida.</div>';
                    break;

                case 1062:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: La categoría que has introducido ya existe.</div>';
                    break;

                case 1146:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No existe la tabla categorías.</div>';
                    break;

                default:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
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