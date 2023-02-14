<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
    $datos = $controlador->obtenerReto($_GET);

    if(!$datos) header('Location: listado.php');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <title>Consulta de reto</title>
    </head>
    <body>
        <h2 class="text-center my-3">Consulta de reto</h2>

        <div class="bg-light mx-auto border border-secondary rounded w-75">
            <ul>
                <li class="my-2"><b>ID del reto:</b> <?php echo $_GET['id'] ?></li>
                <li class="my-2"><b>Nombre del reto:</b> <?php echo isset($datos['nombreReto']) ? $datos['nombreReto'] : '' ?></li>
                <li class="my-2"><b>Dirigido a:</b> <?php echo isset($datos['dirigido']) ? $datos['dirigido'] : '' ?></li>
                <li class="my-2"><b>Categoría:</b> <?php echo $controlador->obtenerCategoria($_GET['id']) ?></li>
                <li class="my-2"><b>Fecha inicio de inscripción:</b> <?php echo isset($datos['fechaInicioInscripcion']) ? $datos['fechaInicioInscripcion'] : '' ?></li>
                <li class="my-2"><b>Fecha fin de inscripción:</b> <?php echo isset($datos['fechaFinInscripcion']) ? $datos['fechaFinInscripcion'] : '' ?></li>
                <li class="my-2"><b>Fecha inicio del reto:</b> <?php echo isset($datos['fechaInicioReto']) ? $datos['fechaInicioReto'] : '' ?></li>
                <li class="my-2"><b>Fecha fin del reto:</b> <?php echo isset($datos['fechaFinReto']) ? $datos['fechaFinReto'] : '' ?></li>
                <li class="my-2"><b>Descripción:</b> <?php echo isset($datos['descripcion']) ? $datos['descripcion'] : '' ?></li>
                <li class="my-2"><b>Publicado:</b> <?php echo isset($datos['publicado']) ? 'Sí' : 'No' ?></li>
                <li class="my-2"><b>Fecha de publicación:</b> <?php echo isset($datos['fechaPublicacion']) ? $datos['fechaPublicacion'] : '' ?></li>
                <li class="my-2"><b>ID del profesor:</b> <?php echo isset($datos['idProfesor']) ? $datos['idProfesor'] : '' ?></li>
            </ul>
        </div>

        <div class="text-center my-3">
            <a href="listado.php">
                <button class="text-center mx-auto btn btn-success">
                    <i class="bi bi-arrow-left text-light"></i>
                </button>
            </a>
        </div>
    </body>
</html>