<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();

    $nombre = $controlador->obtenerNombreReto($_GET);

    if(!$nombre) 
        header('Location: listado.php');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<title>Confirmar borrado</title>
    </head>
    <body>
        <div class="text-center alert alert-info my-3 mx-auto" style="width: 350px;">
            <p class="my-3">
                ¿Eliminar el reto <b>"<?php echo $nombre ?>"</b>?
            </p>
            <button type="button" class="btn btn-danger">
                <a href="listado.php" class="link-light">Cancelar</a>
            </button>
            <button type="button" class="btn btn-success">
                <?php echo '<a href="borrar.php?id=' . $_GET['id'] .'" class="link-light"> Eliminar</a>' ?>
            </button>
        </div>
    </body>
</html>