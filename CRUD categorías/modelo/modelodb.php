<?php
    require_once('../conexion.php');

    class ModeloDB
    {
        public $conexion;
        private $usuario;
        private $contrasenia;
        private $servidor;
        private $bd;

        function __construct()
        {
            $this->servidor = constant('SERVIDOR');
            $this->usuario = constant('USUARIO');
            $this->contrasenia = constant('CONTRASENIA');
            $this->bd = constant('BD');

            try
            {
                $this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasenia, $this->bd);
            }
            catch(mysqli_sql_exception $e)
            {
                $this->conexion = null;
                echo '<p><span id="error">Error:</span> ' . $e->getMessage() . '</p>';
            }
        }
    }
?>