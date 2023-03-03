<?php
    // Inserción masiva de profesores con contraseñas hasheadas.
    try {
        $nombres = array('David', 'Pedro', 'Javier', 'Ana');
        $correos = array('david@gmail.com', 'pedro@gmail.com', 'javier@gmail.com', 'ana@gmail.com');
        $passwords = array('1234', '4321', '1212', '2121');

        $sql = 'INSERT INTO profesores(nombre, correo, contrasenia) VALUES(?, ?, ?)';
        $conexion = new mysqli('2daw.esvirgua.com', 'user2daw_12', 'yGOd_ltp@CP1', 'user2daw_BD2-12');
        $consulta = $conexion->prepare($sql);

        $nombre = '';
        $correo = '';
        $password = '';

        $consulta->bind_param('sss', $nombre, $correo, $password);

        for($i=0; $i<count($nombres); $i++) {
            $nombre = $nombres[$i];
            $correo = $correos[$i];
            $password = password_hash($passwords[$i], PASSWORD_DEFAULT, ['cost' => 15]);

            $consulta->execute();
        }

        $consulta->close();
        $conexion->close();

        echo '<h3>Inserción OK.</h3>';
    }
    catch(mysqli_sql_exception $e) {
        echo '<h3>Error ' . $e->getCode() . ': ' . $e->getMessage() . '</h3>';
    }
?>