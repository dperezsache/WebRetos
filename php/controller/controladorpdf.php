<?php
    require_once(dirname(__DIR__) . '/model/modelopdf.php');

    /**
     * Clase ControladorPDF.
     * Controlador de generar PDFs
     */
    class ControladorPDF
    { 
        private $modelo;

        public function __construct()
        {
            $this->modelo = new ModeloPDF();
        }

        /**
         * Generar el PDF de la opción seleccionada.
         * @param mixed $array Array de datos.
         * @return Number Nº de resultado.
         */
        public function generarPDF($array)
        {
            if (isset($_SESSION['idProfesor']) && isset($array['seleccion']))
            {
                $this->modelo->generarPDF($array['seleccion']);
            }
            else
            {
                return 0;
            }
        }
    }
?>