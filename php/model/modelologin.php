<?php
    require_once('modelodb.php');

    /**
     * Clase ModeloLogin.
     * Clase que ejecuta los procesos requeridos para hacer el inicio de sesión.
     */
    class ModeloLogin
    {
        private $conexion;

        /** 
         * Obtiene la conexión a la BBDD.
         */
        public function obtenerConexion()
        {
            $objConectar = new ModeloDB();
            $this->conexion = $objConectar->conexion;
        }

        /**
         * Iniciar sesión.
         * @param String $correo Correo del usuario.
         * @param String $password Contraseña.
         * @return void
         */
        public function inicioSesion($correo, $password)
        {
            try
            {
                $this->obtenerConexion();

                if ($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("SELECT * FROM profesores WHERE correo=? AND contrasenia=?");
                    $consulta->bind_param('ss', $correo, $password);
                    $consulta->execute();

                    $resultado = $consulta->get_result();

                    $this->conexion->close();
                    $consulta->close();

                    if ($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_array(MYSQLI_ASSOC);
                        $this->generarSesion($fila['idProfesor']);
                        return 1;
                    }
                    else
                    {
                        return -2;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }

        /**
         * Genera la sesión del usuario.
         * @param Number $id ID del profesor.
         * @return void
         */
        public function generarSesion($id)
        {
            ini_set('session.use_strict_mode', true);   // Activar modo estricto.
            ini_set('session.use_only_cookies', 1);     // Forzar las sesiones a usar solo cookies. 
            session_set_cookie_params(0);               // La sesión del cliente caducará cúando se cierre el navegador.
            session_start();                            // Iniciar la sesión.

            $_SESSION['idProfesor'] = $id;
        }

        /**
         * Realizar el cierre de sesión del usuario actual.
         * @return void
         */
        public function cerrarSesion()
        {
            session_start();
            session_unset();    // Liberar la variable $_SESSION.
            session_destroy();  // Destruye los datos de sesión almacenados.
        }
    }
?>