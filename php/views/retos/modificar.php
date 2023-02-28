<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();

    $datos = $controlador->obtenerReto($_GET);
    if ($datos == null) $datos = $controlador->obtenerReto($_POST);

    include('../includes/header.php');
?>
<main>
    <nav>
        <div class="navElementoTitulo">Gestión de retos</div>
        <div class="navElemento">
            <a href="listado.php">Listado de retos</a>
        </div>
        <div class="navElemento">
            <a href="insertar.php">Alta de retos</a>
        </div>
        <div class="navElemento">
            <a href="modificar.php">Modificar retos</a>
        </div>
        <div class="navElementoTitulo">Gestión de categorías</div>
        <div class="navElemento">
            <a href="../categorias/listado.php">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../categorias/insertar.php">Alta de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../categorias/modificar.php">Modificar categorías</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Modificación de reto</h1>
    </div>

    <div id="divContenido">
        <form action="" method="post" id="formModificar">
            <div class="formItem">
                <label for="reto">
                    Retos 
                    <select name="reto">
                        <option disabled selected>-- Elige un reto --</option>
                        <?php
                            $controlador->cargarRetos();
                            $retos = $controlador->obtenerRetos();
                            
                            if ($retos != null)
                            {
                                while($fila = $retos->fetch_array(MYSQLI_ASSOC))
                                {
                                    if ($fila['idReto'] == $datos['idReto'])
                                        echo '<option selected value="' . $fila['idReto'] . '">' . $fila['nombreReto'] . '</option>';

                                    else
                                        echo '<option value="' . $fila['idReto'] . '">' . $fila['nombreReto'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="formItem">
                <label for="nombre">
                    Nombre reto <input type="text" name="nombre" maxlength="100" value="<?php echo $datos!=null ? $datos['nombreReto'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="dirigido">
                    Dirigido a <input type="text" name="dirigido" maxlength="100" value="<?php echo $datos!=null ? $datos['dirigido'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="categoria">
                    Categoría
                    <select name="categoria">
                        <?php
                            $categorias = $controlador->obtenerCategorias();

                            if ($categorias != null)
                            {
                                while($fila = $categorias->fetch_array(MYSQLI_ASSOC))
                                {
                                    if ($fila['idCategoria'] == $datos['idCategoria'])
                                        echo '<option selected value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
    
                                    else
                                        echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaInicioIns">
                    Fecha inicio de inscripción <input type="datetime-local" name="fechaInicioIns" value="<?php echo $datos!=null ? $datos['fechaInicioInscripcion'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaFinIns">
                    Fecha fin de inscripción <input type="datetime-local" name="fechaFinIns" value="<?php echo $datos!=null ? $datos['fechaFinInscripcion'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaInicioReto">
                    Fecha inicio del reto <input type="datetime-local" name="fechaInicioReto" value="<?php echo $datos!=null ? $datos['fechaInicioReto'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaFinReto">
                    Fecha fin del reto <input type="datetime-local" name="fechaFinReto" value="<?php echo $datos!=null ? $datos['fechaFinReto'] : '' ?>"/>
                </label>
            </div>
            <div class="formItem">
                <label for="descReto">
                    Descripción <textarea rows="8" name="descReto" style="resize: none;"><?php echo $datos!=null ? $datos['descripcion'] : '' ?></textarea>
                </label>
            </div>
            <div class="formItem">
                <button type="reset" class="botonRojo">Cancelar</button>
                <button type="submit" class="botonVerde">Modificar</button>
            </div>
        </form>
        <?php
            $resultado = $controlador->modificarReto($_GET, $_POST);
            
            switch($resultado)
            {
                case -12:
                    echo '<div class="error">Error: No has selecionado un reto.</div>';
                    break;

                case -11:
                    echo '<div class="error">Error: Fecha de fin de reto incorrecta.</div>';
                    break;

                case -10:
                    echo '<div class="error">Error: Fecha de inicio de reto incorrecta.</div>';
                    break;
    
                case -9:
                    echo '<div class="error">Error: Fecha de fin de inscripción incorrecta.</div>';
                    break;

                case -8:
                    echo '<div class="error">Error: Fecha de inicio de inscripción incorrecta.</div>';
                    break;

                case -7:
                    echo '<div class="error">Error: No has introducido fecha de fin de reto.</div>';
                    break;

                case -6:
                    echo '<div class="error">Error: No has introducido fecha de inicio de reto.</div>';
                    break;
    
                case -5:
                    echo '<div class="error">Error: No has introducido fecha de fin de inscripción.</div>';
                    break;

                case -4:
                    echo '<div class="error">Error: No has introducido fecha de inicio de inscripción.</div>';
                    break;

                case -3:
                    echo '<div class="error">Error: No has introducido a quien va dirigido el reto.</div>';
                    break;

                case -2:
                    echo '<div class="error">Error: Nombre de reto en blanco.</div>';
                    break;

                case -1:
                    echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<div class="exito">Exito: El reto ha sido modificado.</div>';
                    break;

                case 1062:
                    echo '<div class="error">Error: Ya existe un reto igual.</div>';
                    break;
                
                case 1146:
                    echo '<div class="error">Error: No existe la tabla de retos.</div>';
                    break;

                default:
                    echo '<div class="aviso">Se ha producido un error con código: ' . $resultado . '.</div>';
                    break;
            }
        ?>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>