<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<title>Borrar reto</title>
    </head>
    <body>
        <?php
            $resultado = $controlador->borrarReto($_GET);
            
            switch($resultado)
            {
                case -1:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: El reto a borrar ya no existe.</div>';
                    break;

                case 1: // Caso OK
                    echo '<div class="alert alert-success my-3 mx-auto" style="width: 350px;">Exito: El reto ha sido eliminado.</div>';
                    break;

                case 1146:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Error: No existe la tabla de retos.</div>';
                    break;
                    
                default:
                    echo '<div class="alert alert-danger my-3 mx-auto" style="width: 350px;">Se ha producido un error con código: <b>' . $resultado . '</b></div>';
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
