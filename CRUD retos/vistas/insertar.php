<?php
    require_once('../controlador/controladorretos.php');
    $controlador = new ControladorRetos();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8"/>
		<meta name="author" content="David Pérez Saché"/>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<title>Añadir categorías</title>
    </head>
    <body>
        <h2>Insertar reto</h2>
        <form action="" method="post"/>
            <div id="divForm">
                <label for="nombre">
                    Nombre reto <input type="text" name="nombre" maxlength="100"/>
                </label>

                <label for="dirigido">
                    Dirigido a <input type="text" name="dirigido" maxlength="100"/>
                </label>
                
                <label for="categoria">
                    Categoría
                    <select name="categoria">
                        <?php
                            $datos = $controlador->obtenerCategorias();
                            while($fila = $datos->fetch_array(MYSQLI_ASSOC)) echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                        ?>
                    </select>
                </label>

                <label for="fechaInicioIns">
                    Fecha inicio de inscripción <input type="datetime-local" name="fechaInicioIns"/>
                </label>

                <label for="fechaFinIns">
                    Fecha fin de inscripción <input type="datetime-local" name="fechaFinIns"/>
                </label>

                <label for="fechaInicioReto">
                    Fecha inicio del reto <input type="datetime-local" name="fechaInicioReto"/>
                </label>

                <label for="fechaFinReto">
                    Fecha fin del reto <input type="datetime-local" name="fechaFinReto"/>
                </label>
                
                <label for="descReto">
                    Descripción <textarea rows="8" name="descReto"></textarea>
                </label>
                
                <div id="divBotones">
                    <button type="reset">Cancelar</button>
                    <button type="submit">Añadir reto</button>
                </div>
            </div>
        </form>
        <?php
            print_r($_POST);
            $resultado = $controlador->altaReto($_POST);
            
            switch($resultado)
            {
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
                    echo '<p><span id="error">Error:</span> No has introducido nada.</p>';
                    break;

                case -1:
                    echo '<p><span id="error">Error:</span> No hay conexión con la base de datos.</p>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<p><span id="exito">Exito:</span> El reto ha sido añadido.</p>';
                    break;

                case 1062:
                    echo '<p><span id="error">Error:</span> El reto que has introducido ya existe.</p>';
                    break;

                case 1136:
                    echo '<p><span id="error">Error:</span> El nº de columnas a insertar no coincide con el nº de columnas de la tabla.</p>';
                    break;

                case 1146:
                    echo '<p><span id="error">Error:</span> No existe la tabla de retos.</p>';
                    break;

                default:
                    echo '<p>Se ha producido un error con código: <b>' . $resultado . '</b>.</p>';
                    break;
            }
        ?>
        <div class="divBotones">
            <a href="listado.php"><span class="material-icons">arrow_back</span></a>
        </div>
    </body>
</html>