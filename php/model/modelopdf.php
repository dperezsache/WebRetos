<?php
    require_once('modelodb.php');
    require_once('modeloretos.php');
    require_once(dirname(__DIR__) . '/fpdf/fpdf.php');

    /**
     * Clase ModeloLogin.
     * Clase que ejecuta los procesos requeridos para hacer el inicio de sesión.
     */
    class ModeloPDF extends FPDF
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


        public function generarPdfCategorias()
        {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'Categorías', 1, 1, 'C');
            $pdf->Output();
            return 1;
        }

        public function generarPdfRetos()
        {

        }

        // Cabecera de página
        public function Header()
        {
            // Logo
            //$this->Image('../../assets/imgs/logotipo.png', 10, 8, 33);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Movernos a la derecha
            $this->Cell(70);
            // Título
            $this->Cell(50, 10, 'WEB RETOS', 1, 0, 'C');
            // Salto de línea
            $this->Ln(30);
        }

        // Pie de página
        public function Footer()
        {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }
?>