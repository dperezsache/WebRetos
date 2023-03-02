<?php
    require_once('./fpdf/fpdf.php');
    require_once('./controller/controladorcategorias.php');
    $controlador = new ControladorCategorias();

    if ($controlador->cargarListado() == 1)
    {
        $categorias = $controlador->obtenerListado();

        $pdf = new FPDF();
        $pdf->AddPage();
        
        $header = array('ID', 'Categoría');
        crearTabla($header, $categorias, $pdf);

        $pdf->Output('categorias.pdf', 'D');
    }

    /**
     * Crear dentro del PDF una tabla con los datos de las categorías.
     * @param string[] $header Array con las columnas de la tabla.
     * @param mixed $categorias Array con las categorías.
     * @param FPDF $pdf Archivo .pdf
     */
    function crearTabla($header, $categorias, $pdf)
    {
        // Título inicio documento
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', 'Listado de categorías'), 0, 0, 'C');
        $pdf->Ln(10);

        // Cabecera tabla
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(.3);
        $pdf->SetFont('', 'B');

        for($i=0; $i<count($header); $i++)
        {
            $pdf->Cell(40, 7, iconv('UTF-8', 'windows-1252', $header[$i]), 1, 0, 'C', true);
        }

        // Contenido tabla
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 14);
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);

        while($fila = $categorias->fetch_array(MYSQLI_ASSOC))
        {
            foreach($fila as $columna) 
                $pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', $columna), 1);

            $pdf->Ln();
        }
    }
?>