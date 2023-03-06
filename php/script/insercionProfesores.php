<?php
    require_once('../config/configdb.php');
    require_once('../config/config.php');

    $servidor = constant('SERVIDOR');
    $usuario = constant('USUARIO');
    $contrasenia = constant('CONTRASENIA');
    $bd = constant('BD');
    $codificacion = constant('CODIFICACION');

    // Inserción masiva de profesores con contraseñas hasheadas.
    try 
    {
        $nombres = array('David', 'Pedro', 'Javier', 'Ana');
        $correos = array('david@gmail.com', 'pedro@gmail.com', 'javier@gmail.com', 'ana@gmail.com');
        $passwords = array('1234', '4321', '1212', '2121');

        $sql = "INSERT INTO profesores(nombre, correo, contrasenia) VALUES(?, ?, ?)";
        $conexion = new mysqli($servidor, $usuario, $contrasenia, $bd);
        $conexion->set_charset($codificacion);

        $consulta = $conexion->prepare($sql);

        $nombre = '';
        $correo = '';
        $password = '';

        $consulta->bind_param('sss', $nombre, $correo, $password);

        for($i=0; $i<count($nombres); $i++) 
        {
            $nombre = $nombres[$i];
            $correo = $correos[$i];
            $password = password_hash($passwords[$i], PASSWORD_DEFAULT, ['cost' => 15]);

            $consulta->execute();
        }

        $consulta->close();
        $conexion->close();

        echo '<h3>Éxito</h3> Inserción OK.';
    }
    catch(mysqli_sql_exception $e) 
    {
        switch($e->getCode())
        {
            case 1062:
                echo '<h3>Error</h3> Intentando añadir un profesor ya existente.';
                break;

            default:
                echo '<h3>Error</h3> ' . $e->getCode() . ': ' . $e->getMessage();
                break;
        }
    }
?>