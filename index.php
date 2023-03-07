<?php
    // Comprobar que haya sesión
    session_start();
    if (!isset($_SESSION['idProfesor']))
        header('Location: ./php/views/login/login.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
		<meta author="David Pérez Saché"/>
		<title>Web de retos</title>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
        <link rel="icon" type="image/png" href="assets/imgs/icono.png"/>
		<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
    </head>
    <body>
        <header>
            <img src="assets/imgs/logo.png" alt="Logo"/>
        </header>
        <main>
            <nav>
                <div class="navElementoTitulo">Gestión de retos</div>
                <div class="navElemento">
                    <a href="./php/views/retos/listado.php">Listado de retos</a>
                </div>
                <div class="navElemento">
                    <a href="./php/views/retos/insertar.php">Alta de retos</a>
                </div>
                <div class="navElemento">
                    <a href="./php/views/retos/modificar.php">Modificar retos</a>
                </div>
                <div class="navElementoTitulo">Gestión de categorías</div>
                <div class="navElemento">
                    <a href="./php/views/categorias/listado.php">Listado de categorías</a>
                </div>
                <div class="navElemento">
                    <a href="./php/views/categorias/insertar.php">Alta de categorías</a>
                </div>
                <div class="navElemento">
                    <a href="./php/views/categorias/modificar.php">Modificar categorías</a>
                </div>
                <div class="navElementoTitulo">Generación de PDFs</div>
                <div class="navElemento">
                    <a href="./php/script/generarpdf.php?op=1">Listado de categorías</a>
                </div>
                <div class="navElemento">
                    <a href="./php/script/generarpdf.php?op=2">Listado de retos</a>
                </div>
                <div class="navElementoTitulo">Sesión</div>
                <div class="navElemento">
                    <a href="./php/views/login/logout.php">Cerrar sesión</a>
                </div>
            </nav>
            <div id="divTitulo">
                <h1>Inicio</h1>
            </div>
            <div id="divContenido">
                <div class="exito">
                    <h3>Bienvenido, elige una de las opciones del menú.</h3>
                </div>
            </div>
        </main>
        <footer>
            <div id="divFooter">
                <a href="https://www.youtube.com" target="_blank">
                    <img src="assets/imgs/youtube.png" alt="YouTube"/>
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="assets/imgs/instagram.png" alt="Instagram"/>
                </a>
                <a href="https://www.facebook.com" target="_blank">
                    <img src="assets/imgs/facebook.png" alt="Facebook"/>
                </a>
                <a href="https://web.telegram.org" target="_blank">
                    <img src="assets/imgs/telegram.png" alt="Telegram"/>
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="assets/imgs/twitter.png" alt="Twitter"/>
                </a>
            </div>
        </footer>
    </body>
</html>