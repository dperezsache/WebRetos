<?php
    require_once(dirname(__DIR__) . '/model/modelopdf.php');
    require_once('controladorcategorias.php');
    require_once('controladorretos.php');

    /**
     * Clase ControladorPDF.
     * Controlador de generar PDFs
     */
    class ControladorPDF
    { 
        private $modeloPdf;
        private $controladorCategorias;
        private $controladorRetos;

        public function __construct()
        {
            $this->modeloPdf = new ModeloPDF();
            $this->controladorCategorias = new ControladorCategorias();
            $this->controladorRetos = new ControladorRetos(); 
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
                switch($array['seleccion'])
                {
                    case 1: 
                        return $this->modeloPdf->generarPdfCategorias();

                    case 2:
                        return $this->modeloPdf->generarPdfRetos();

                    default:
                        return 0;
                }
            }
            else
            {
                return 0;
            }
        }
    }
?>