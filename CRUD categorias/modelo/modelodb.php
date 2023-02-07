<?php
    require_once('../../config/configuraciondb.php');
    require_once('../../config/configuracion.php');

    /**
     * Clase ModeloDB.
     * Se encarga de crear conexión con la base de datos.
     */
    class ModeloDB
    {
        public $conexion;
        private $usuario;
        private $contrasenia;
        private $servidor;
        private $bd;
        private $codificacion;

        function __construct()
        {
            $this->servidor = constant('SERVIDOR');
            $this->usuario = constant('USUARIO');
            $this->contrasenia = constant('CONTRASENIA');
            $this->bd = constant('BD');
            $this->codificacion = constant('CODIFICACION');

            error_reporting(E_ERROR | E_PARSE); // Desactivar warnings, ya que afectan a comprobaciones que hago
            
            try
            {
                $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasenia, $this->bd);
                $this->conexion->set_charset($this->codificacion);
            }
            catch(mysqli_sql_exception $e)
            {
                $this->conexion = null;
            }
        }
    }
?>