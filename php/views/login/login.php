<?php
    require_once('../../controller/controladorlogin.php');
    $controlador = new ControladorLogin();

    session_start();
    if (isset($_SESSION['idProfesor']) && isset($_SESSION['nombreProfesor'])) 
        header('Location: ../../../index.php');
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
    <body id="bodyLogin">
        <h1>Inicio de sesión</h1>
        <form action="" method="POST" id="formLogin">
            <div class="formItem">
                <label for="correo">Correo electrónico</label>
                <input type="text" name="correo" maxlength="100"/>
            </div>
            <div class="formItem">
                <label for="password">Contraseña</label>
                <input type="password" name="password" maxlength="255"/>
            </div>
            <div class="formItem">
                <button type="submit">Aceptar</button>
            </div>
        </form>
    </body>
    <?php
        $resultado = $controlador->iniciarSesion($_POST);

        switch($resultado)
        {
            case -3:
                echo '<div class="error">Error: Datos incorrectos, intentelo de nuevo.</div>';
                break;
    
            case -2:
                echo '<div class="error">Error: La contraseña es incorrecta o está sin rellenar.</div>';
                break;
    
            case -1:
                echo '<div class="error">Error: El usuario es incorrecto o está sin rellenar.</div>';
                break;
    
            case 0: case 1:
                break;
    
            default:
                echo '<div class="error">Se ha producido un error con código: <b>' . $resultado . '</b>.</div>';
                break;
        }
    ?>
</html>