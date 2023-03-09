<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    include('../includes/header.php');
    include('../includes/navcategorias.php');
?>
<div id="divTitulo">
    <h1>Listado de categorías</h1>
</div>

<div id="divContenido">        
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
                        
                        for($i=0; $i<count($datos); $i++)
                        {
                            echo '<tr>';

                            foreach($datos[$i] as $valor)
                            {
                                echo '<td>' . $valor . '</td>';
                            }

                            echo '<td><p class="inline"><a href="confirmarborrado.php?id=' . $datos[$i]['idCategoria'] . '"><span class="material-icons">delete</span></a></p>';
                            echo '<p class="inline"><a href="modificar.php?id=' . $datos[$i]['idCategoria'] . '"><span class="material-icons">edit</span></a></p></td>';
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    include('../includes/footer.php');
?>
