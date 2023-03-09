<?php
    require_once('../../controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    include('../includes/header.php');
    include('../includes/navcategorias.php');
?>
<div id="divTitulo">
    <h1>Modificación de categoría</h1>
</div>

<div id="divContenido">
    <form id="formModificar" action="" method="POST">
        <div class="formItem">
            <label for="categoria">
                Categoría
                <select name="categoria">
                    <option selected disabled>-- Selecciona categoría --</option>
                    <?php
                        if($controlador->cargarListado() == 1)
                        {
                            $categorias = $controlador->obtenerListado();
                            
                            for($i=0; $i<count($categorias); $i++)
                            {
                                if($categorias[$i]['idCategoria'] == $_GET['id'])
                                    echo '<option selected value="' . $categorias[$i]['idCategoria'] . '">' . $categorias[$i]['nombreCategoria'] . '</option>';

                                else
                                    echo '<option value="' . $categorias[$i]['idCategoria'] . '">' . $categorias[$i]['nombreCategoria'] . '</option>';
                            }   
                        }
                    ?>
                </select>
            </label>
        </div>
        <div class="formItem">
            <label for="nombre">
                Nuevo nombre de categoría <input type="text" name="nombre" value="<?php echo $controlador->obtenerNombreCategoria($_GET) ?>"/>
            </label>
        </div>
        <div class="formItem">
            <button type="reset" class="botonRojo">Cancelar</button>
            <button type="submit" class="botonVerde">Modificar</button>
        </div>
    </form>

    <?php
        $resultado = $controlador->modificarCategoria($_GET, $_POST);
        
        switch($resultado)
        {
            case -2:
                echo '<div class="error" style="width: 350px;">Error: Introduciste nombre de categoría en blanco.</div>';
                break;

            case -1:
                echo '<div class="error">Error: No hay conexión con la base de datos.</div>';
                break;

            case 0:
                break;

            case 1: // Caso OK
                echo '<div class="exito">Exito: La categoría ha sido modificada.</div>';
                break;

            case 1062:
                echo '<div class="error">Error: Ya existe una categoría con ese nombre.</div>';
                break;
            
            case 1146:
                echo '<div class="error">Error: No existe la tabla categorías.</div>';
                break;

            default:
                echo '<div class="error">Se ha producido un error con código: ' . $resultado . '.</div>';
                break;
        }
    ?>
</div>
<?php
    include('../includes/footer.php');
?>