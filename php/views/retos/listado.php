<?php
    require_once('../../controller/controladorcategorias.php');
    require_once('../../controller/controladorretos.php');

    $controladorCategorias = new ControladorCategorias();
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
            <a href="../../script/generarpdf.php?op=1">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="../../script/generarpdf.php?op=2">Listado de retos</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Listado de retos</h1>
    </div>

    <div id="divContenido">
        <form method="POST" action="" id="formBusqueda">
            <div class="formItem">
                <label for="busqueda">
                    Buscar por nombre de reto <input type="text" placeholder="" class="form-control" name="busqueda"/>
                </label>
            </div>
            <div class="formItem">
                <label for="filtrado">
                    Filtrar por categoría
                    <select name="filtrado" class="form-select">
                        <option value="-1">Sin filtro</option>
                        <?php
                            if ($controladorCategorias->cargarListado() == 1)
                            {
                                $categorias = $controladorCategorias->obtenerListado();

                                for($i=0; $i<count($categorias); $i++)
                                    echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
                            }
                        ?>
                    </select>
                </label>
            </div>
            <div class="formItem">
                <button type="reset" class="botonRojo">Borrar</button>
                <button type="submit" class="botonVerde">Buscar</button>
            </div>
        </form>

        <div id="divTabla">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reto</th>
                        <th class="colPublicado">Publicado</th>
                        <th>Categoría</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $resultado = $controlador->hayListado($_POST);
                    
                    switch($resultado)
                    {
                        case -1:
                            echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                            break;

                        case 0:
                            echo '<div class="aviso">No hay datos que mostrar.</div>';
                            break;

                        case 1: // Caso OK
                            break;

                        case 1146:
                            echo '<div class="error">Error: No existe la tabla retos.</div>';
                            break;

                        default:
                            echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                            break;
                    }

                    if ($resultado == 1)
                    {
                        $datos = $controlador->obtenerListado();

                        if ($datos != null)
                        {
                            for($i=0; $i<count($datos); $i++)
                            {
                                $publicado = false;
                                echo '<tr>';

                                foreach($datos[$i] as $indice => $valor)
                                {
                                    switch($indice)
                                    {
                                        case 'idReto':
                                            echo '<td>' . $datos[$i]['idReto'] . '</td>';
                                            break;

                                        case 'nombreReto':
                                            echo '<td>' . $datos[$i]['nombreReto'] . '</td>';
                                            break;

                                        case 'publicado':
                                            if ($datos[$i]['publicado'] == 1) {
                                                echo '<td class="colPublicado">Sí</td>';
                                                $publicado = true;
                                            }
                                            else {
                                                echo '<td class="colPublicado">No</td>';
                                                $publicado = false;
                                            }
                                            break;

                                        case 'idCategoria':
                                            echo '<td>' . $controladorCategorias->obtenerCategoria($valor) . '</td>';
                                            break;
                                    }
                                }

                                echo '<td><p class="inline"><a href="confirmarborrado.php?id=' . $datos[$i]['idReto'] . '"><span class="material-icons">delete</span></a></p>';
                                echo '<p class="inline"><a href="modificar.php?id=' . $datos[$i]['idReto'] . '"><span class="material-icons">edit</span></a></p>';
                                echo '<p class="inline"><a href="consultar.php?id=' . $datos[$i]['idReto'] . '"><span class="material-icons">search</span></a></p>';
                                if (!$publicado) echo '<p class="inline"><a href="confirmarpublicacion.php?id=' . $datos[$i]['idReto'] .'"><span class="material-icons">add</span></a></p>';
                                echo '</td></tr>';
                            }
                        }
                    }
                ?>
                </tbody>
            </table> 
        </div>
    </div>
</main>
<?php 
    include('../includes/footer.php'); 
?>