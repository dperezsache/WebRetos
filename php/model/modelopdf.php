<?php
    require_once('modelodb.php');
    require_once('modeloretos.php');
    require_once(dirname(__DIR__) . '/fpdf/fpdf.php');

    /**
     * Clase ModeloLogin.
     * Clase que ejecuta los procesos requeridos para hacer el inicio de sesión.
     */
    class ModeloPDF
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


        public function generarPDF($seleccion)
        {
            
        }
    }
?>