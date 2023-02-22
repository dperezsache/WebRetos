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
                            $categorias = $controlador->obtenerCategorias();
                            while($fila = $categorias->fetch_array(MYSQLI_ASSOC))
                                echo '<option value="' . $fila['idCategoria'] . '">' . $fila['nombreCategoria'] . '</option>';
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
                        <th>Publicado</th>
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

                    if($resultado == 1)
                    {
                        $datos = $controlador->obtenerListado();

                        if($datos != null)
                        {
                            while($fila = $datos->fetch_array(MYSQLI_ASSOC))
                            {
                                $publicado = false;
                                echo '<tr>';

                                foreach($fila as $indice => $valor)
                                {
                                    switch($indice)
                                    {
                                        case 'idReto':
                                            echo '<td>' . $fila['idReto'] . '</td>';
                                            break;

                                        case 'nombreReto':
                                            echo '<td>' . $fila['nombreReto'] . '</td>';
                                            break;

                                        case 'publicado':
                                            if ($fila['publicado'] == 1) {
                                                echo '<td>Sí</td>';
                                                $publicado = true;
                                            }
                                            else {
                                                echo '<td>No</td>';
                                                $publicado = false;
                                            }
                                            break;

                                        case 'idCategoria':
                                            echo '<td>' . $controlador->obtenerCategoria($valor) . '</td>';
                                            break;
                                    }
                                }

                                echo '<td><p class="inline"><a href="confirmarborrado.php?id=' . $fila['idReto'] . '"><span class="material-icons">delete</span></a></p>';
                                echo '<p class="inline"><a href="modificar.php?id=' . $fila['idReto'] . '"><span class="material-icons">edit</span></a></p>';
                                echo '<p class="inline"><a href="consultar.php?id=' . $fila['idReto'] . '"><span class="material-icons">search</span></a></p>';
                                if (!$publicado) echo '<p class="inline"><a href="confirmarpublicacion.php?id=' . $fila['idReto'] .'"><span class="material-icons">add</span></a></p>';
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