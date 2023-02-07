<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
    $datos = $controlador->obtenerReto($_GET);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Modificar retos</title>
    </head>
    <body>
        <h2>Modificar reto</h2>
        <form action="" method="post">
            <div id="divForm">
                <label for="nombre">
                    Nombre reto <input type="text" name="nombre" maxlength="100" value="<?php echo $datos!=null ? $datos['nombreReto'] : '' ?>"/>
                </label>

                <label for="dirigido">
                    Dirigido a <input type="text" name="dirigido" maxlength="100" value="<?php echo $datos!=null ? $datos['dirigido'] : '' ?>"/>
                </label>
                
                <label for="categoria">
                    Categoría
                    <select name="categoria">
                        <?php
                            $categorias = $controlador->obtenerCategorias();
                            while($fila = $categorias->fetch_array(MYSQLI_ASSOC))
                            {
                                if($fila['idCategoria'] == $datos['idCategoria'])
                                {
                                    echo '<option selected value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>

                <label for="fechaInicioIns">
                    Fecha inicio de inscripción <input type="datetime-local" name="fechaInicioIns" value="<?php echo $datos!=null ? $datos['fechaInicioInscripcion'] : '' ?>"/>
                </label>

                <label for="fechaFinIns">
                    Fecha fin de inscripción <input type="datetime-local" name="fechaFinIns" value="<?php echo $datos!=null ? $datos['fechaFinInscripcion'] : '' ?>"/>
                </label>

                <label for="fechaInicioReto">
                    Fecha inicio del reto <input type="datetime-local" name="fechaInicioReto" value="<?php echo $datos!=null ? $datos['fechaInicioReto'] : '' ?>"/>
                </label>

                <label for="fechaFinReto">
                    Fecha fin del reto <input type="datetime-local" name="fechaFinReto" value="<?php echo $datos!=null ? $datos['fechaFinReto'] : '' ?>"/>
                </label>
                
                <label for="descReto">
                    Descripción <textarea rows="8" name="descReto"><?php echo $datos!=null ? $datos['descripcion'] : '' ?></textarea>
                </label>
                
                <div id="divBotones">
                    <button type="reset">Cancelar</button>
                    <button type="submit">Modificar</button>
                </div>
            </div>
        </form>
        <?php
            $resultado = $controlador->modificarReto($_GET, $_POST);
            
            switch($resultado)
            {
                case -14:
                    echo '<p><span id="error">Error:</span> Fecha de fin de reto incorrecta.</p>';
                    break;

                case -13:
                    echo '<p><span id="error">Error:</span> Fecha de inicio de reto incorrecta.</p>';
                    break;
    
                case -12:
                    echo '<p><span id="error">Error:</span> Fecha de fin de inscripción incorrecta.</p>';
                    break;

                case -11:
                    echo '<p><span id="error">Error:</span> Fecha de inicio de inscripción incorrecta.</p>';
                    break;

                case -10:
                    echo '<p><span id="error">Error:</span> No has introducido descripción.</p>';
                    break;

                case -9:
                    echo '<p><span id="error">Error:</span> No has selecionado un reto.</p>';
                    break;

                case -8:
                    echo '<p><span id="error">Error:</span> No has introducido fecha de fin de reto.</p>';
                    break;

                case -7:
                    echo '<p><span id="error">Error:</span> No has introducido fecha de inicio de reto.</p>';
                    break;
    
                case -6:
                    echo '<p><span id="error">Error:</span> No has introducido fecha de fin de inscripción.</p>';
                    break;

                case -5:
                    echo '<p><span id="error">Error:</span> No has introducido fecha de inicio de inscripción.</p>';
                    break;

                case -4:
                    echo '<p><span id="error">Error:</span> No has introducido descripción.</p>';
                    break;

                case -3:
                    echo '<p><span id="error">Error:</span> No has introducido a quien va dirigido el reto.</p>';
                    break;

                case -2:
                    echo '<p><span id="error">Error:</span> Nombre de reto en blanco.</p>';
                    break;

                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<p><span id="exito">Exito:</span> La categoría ha sido modificada.</p>';
                    break;

                case 1062:
                    echo '<p><span id="error">Error:</span> Ya existe una categoría con ese nombre.</p>';
                    break;
                
                case 1146:
                    echo '<p><span id="error">Error:</span> No existe la tabla categorías.</p>';
                    break;

                default:
                    echo '<p>Se ha producido un error con código: ' . $resultado . '.</p>';
                    break;
            }
        ?>
        <div class="divBotones">
            <a href="listado.php"><span class="material-icons">arrow_back</span></a>
        </div>
    </body>
</html>