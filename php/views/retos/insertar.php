<?php
    require_once('../../controller/controladorretos.php');
    $controlador = new ControladorRetos();

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
        <div class="navElementoTitulo">Generación de PDFs</div>
        <div class="navElemento">
            <a href="../../generarpdf.php?op=1">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../../generarpdf.php?op=2">Listado de retos</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Alta de reto</h1>
    </div>

    <div id="divContenido">
        <form id="formAlta" action="" method="post">
            <div class="formItem">
                <label for="nombre">
                    Nombre reto <input type="text" class="form-control" name="nombre" maxlength="100"/>
                </label>
            </div>
            <div class="formItem">
                <label for="dirigido">
                    Dirigido a <input type="text" class="form-control" name="dirigido" maxlength="100"/>
                </label>
            </div>
            <div class="formItem">
                <label for="categoria">
                    Categoría
                    <select name="categoria" class="form-select">
                        <?php
                            $datos = $controlador->obtenerCategorias();

                            if($datos != null)
                            {
                                while($fila = $datos->fetch_array(MYSQLI_ASSOC)) 
                                    echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaInicioIns">
                    Fecha inicio de inscripción <input type="datetime-local" class="form-control" name="fechaInicioIns"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaFinIns">
                    Fecha fin de inscripción <input type="datetime-local" class="form-control" name="fechaFinIns"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaInicioReto">
                    Fecha inicio del reto <input type="datetime-local" class="form-control" name="fechaInicioReto"/>
                </label>
            </div>
            <div class="formItem">
                <label for="fechaFinReto">
                    Fecha fin del reto <input type="datetime-local" class="form-control" name="fechaFinReto"/>
                </label>
            </div>
            <div class="formItem">
                <label for="descReto">
                    Descripción <textarea rows="8" class="form-control" name="descReto" style="resize: none;"></textarea>
                </label>
            </div>
            <div class="formItem">
                <label for="publicacion">
                    Publicación del reto
                    <select name="publicacion" class="form-select">
                        <option value="0">No publicar</option>
                        <option value="1">Publicar</option>
                    </select>
                </label>
            </div>
            <div class="formItem">
                <button type="reset" class="botonRojo">Cancelar</button>
                <button type="submit" class="botonVerde">Añadir reto</button>
            </div>
        </form>
        <?php
            $resultado = $controlador->altaReto($_POST);
            
            switch($resultado)
            {
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
                    echo '<div class="error">Error: No has introducido nada.</div>';
                    break;

                case -1:
                    echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                    break;

                case 0:
                    break;

                case 1: // Caso OK
                    echo '<div class="exito">Exito: El reto ha sido añadido.</div>';
                    break;

                case 1062:
                    echo '<div class="error">Error: El reto que has introducido ya existe.</div>';
                    break;

                case 1136:
                    echo '<div class="error">Error: El nº de columnas a insertar no coincide con el nº de columnas de la tabla.</div>';
                    break;

                case 1146:
                    echo '<div class="error">Error: No existe la tabla de retos.</div>';
                    break;

                default:
                    echo '<div class="aviso">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                    break;
            }
        ?>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>