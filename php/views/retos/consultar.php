<?php
    require_once('../../controller/controladorcategorias.php');
    require_once('../../controller/controladorretos.php');

    $controladorCategorias = new ControladorCategorias();
    $controlador = new ControladorRetos();

    session_start();
    $datos = $controlador->obtenerReto($_GET);
    
    // Si no se puede obtener los datos del reto, redireccionar al listado.
    if(!$datos) 
    {
        header('Location: listado.php');
    }
    else
    {
        include('../includes/header.php');
        include('../includes/navretos.php');
    }
?>
<div id="divTitulo">
    <h1>Consulta de reto</h1>
</div>

<div id="divContenido">
    <div id="divConsulta">
        <ul>
            <li><b>ID del reto:</b> <?php echo $_GET['id'] ?></li>
            <li><b>Nombre del reto:</b> <?php echo isset($datos['nombreReto']) ? $datos['nombreReto'] : '' ?></li>
            <li><b>Dirigido a:</b> <?php echo isset($datos['dirigido']) ? $datos['dirigido'] : '' ?></li>
            <li><b>Categoría:</b> <?php echo $controladorCategorias->obtenerCategoria($datos['idCategoria']) ?></li>
            <li><b>Fecha inicio de inscripción:</b> <?php echo isset($datos['fechaInicioInscripcion']) ? $datos['fechaInicioInscripcion'] : '' ?></li>
            <li><b>Fecha fin de inscripción:</b> <?php echo isset($datos['fechaFinInscripcion']) ? $datos['fechaFinInscripcion'] : '' ?></li>
            <li><b>Fecha inicio del reto:</b> <?php echo isset($datos['fechaInicioReto']) ? $datos['fechaInicioReto'] : '' ?></li>
            <li><b>Fecha fin del reto:</b> <?php echo isset($datos['fechaFinReto']) ? $datos['fechaFinReto'] : '' ?></li>
            <li><b>Descripción:</b> <?php echo isset($datos['descripcion']) && !empty($datos['descripcion']) ? $datos['descripcion'] : '*En blanco*' ?></li>
            <li><b>Publicado:</b> <?php echo isset($datos['publicado']) && $datos['publicado'] == 1 ? 'Sí' : 'No' ?></li>
            <li><b>Fecha de publicación:</b> <?php echo isset($datos['fechaPublicacion']) && isset($datos['publicado']) && $datos['publicado'] == 1 ? $datos['fechaPublicacion'] : 'No publicado' ?></li>
            <li><b>Profesor:</b> <?php echo $controlador->obtenerNombreProfesor() ?></li>
        </ul>
    </div>
    <div class="divBoton">
        <a href="listado.php">
            <span class="material-icons">arrow_back</span>
        </a>
    </div>
</div>
<?php
    include('../includes/footer.php');
?>