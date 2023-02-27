<?php
    require_once(dirname(__DIR__) . '/model/modelologin.php');

    /**
     * Clase ControladorLogin.
     * Controlador del inicio de sesión
     */
    class ControladorLogin
    {
        private $modelo;

        public function __construct()
        {
            $this->modelo = new ModeloLogin();
        }

        /**
         * Función de inicio de sesión.
         * @param mixed $array Array de datos.
         * @return void
         */
        public function iniciarSesion($array)
        {
            if (isset($array['correo']) && !empty($array['correo']))
            {
                if (isset($array['password']) && !empty($array['password']))
                {
                    return $this->modelo->inicioSesion($array['correo'], $array['password']);
                }
                else
                {
                    return -2;
                }
            }
            else
            {
                return 0;
            }
        }
    }
?>