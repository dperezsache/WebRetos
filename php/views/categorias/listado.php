<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    include('../includes/header.php');
?>
<main>
    <nav>
        <div class="navElementoTitulo">Gestión de retos</div>
        <div class="navElemento">
            <a href="../retos/listado.php">Listado de retos</a>
        </div>
        <div class="navElemento">
            <a href="../retos/insertar.php">Alta de retos</a>
        </div>
        <div class="navElemento">
            <a href="../retos/modificar.php">Modificar retos</a>
        </div>
        <div class="navElementoTitulo">Gestión de categorías</div>
        <div class="navElemento">
            <a href="listado.php">Listado de categorías</a>
        </div>
        <div class="navElemento">
            <a href="insertar.php">Alta de categorías</a>
        </div>
        <div class="navElemento">
            <a href="modificar.php">Modificar categorías</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Listado de categorías</h1>
    </div>

    <div id="divContenido">
        <form action="../../generarpdf.php" method="POST">
            <div class="formItem">
                <button type="submit" class="botonVerde">Generar PDF</button>
            </div>
        </form>
        
        <div id="divTabla">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $resultado = $controlador->cargarListado();
                        
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
                                echo '<div class="error">Error: No existe la tabla categorías.</div>';
                                break;

                            default:
                                echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                                break;
                        }

                        if($resultado == 1)
                        {
                            $datos = $controlador->obtenerListado();
                            
                            while($fila = $datos->fetch_array(MYSQLI_ASSOC))
                            {
                                echo '<tr>';

                                foreach($fila as $valor)
                                {
                                    echo '<td>' . $valor . '</td>';
                                }

                                echo '<td><p class="inline"><a href="confirmarborrado.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">delete</span></a></p>';
                                echo '<p class="inline"><a href="modificar.php?id=' . $fila['idCategoria'] . '"><span class="material-icons">edit</span></a></p></td>';
                                echo '</tr>';
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
