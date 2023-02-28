<?php
    // Comprobar que haya sesión
    session_start();
    if (!isset($_SESSION['idProfesor']))
        header('Location: ../login/login.php');
?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8"/>
    <meta author="David Pérez Saché"/>
    <title>Web de retos</title>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <link rel="icon" type="image/png" href="../../../assets/imgs/icono.png"/>
    <link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>
    <link rel="stylesheet" type="text/css" href="../../../css/Material_Icons.css"/>
</head>

<body>

<header>
    <img src="../../../assets/imgs/logo.png" alt="Logo"/>
</header>
