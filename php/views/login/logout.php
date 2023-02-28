<?php
    require_once('../../controller/controladorlogin.php');
    $controlador = new ControladorLogin();

    session_start();
    if(isset($_SESSION['idProfesor']))
    {
        $controlador->cerrarSesion();
        header('Location: login.php');
    }
    else
    {
        header('Location: ../../index.php');
    }
?>