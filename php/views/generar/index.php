<?php
    require_once('../../controller/controladorpdf.php');
    $controlador = new ControladorPDF();

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
            <a href=../retos/modificar.php">Modificar retos</a>
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
            <a href="index.php">Generar</a>
        </div>
        <div class="navElementoTitulo">Sesión</div>
        <div class="navElemento">
            <a href="../login/logout.php">Cerrar sesión</a>
        </div>
    </nav>

    <div id="divTitulo">
        <h1>Generar PDFs</h1>
    </div>

    <div id="divContenido">
        <form id="formAlta" action="" method="POST">
            <div class="formItem">
                <label for="seleccion">PDF a generar</label>
                <select name="seleccion">
                    <option value="1">Listado de categorías</option>
                    <option value="2">Listado de retos</option>
                </select>
            </div>
            <div class="formItem">
                <button type="submit" class="botonVerde">Generar</button>
            </div>
        </form>
        <?php
            $resultado = $controlador->generarPDF($_POST);

            switch($resultado)
            {
                case 0:
                    break;

                case 1:
                    echo '<div class="exito">Exito: PDF generado.</div>';
                    break;

                default:
                    echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                    break;
            }
        ?>
    </div>
</main>
<?php
    include('../includes/footer.php');
?>