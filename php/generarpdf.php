<?php
    require_once('./fpdf/fpdf.php');
    require_once('./controller/controladorcategorias.php');
    require_once('./controller/controladorretos.php');

    $controladorCategorias = new ControladorCategorias();
    $controladorRetos = new ControladorRetos();

    if (isset($_GET['op']))
    {
        $opcion = $_GET['op'];

        switch($opcion)
        {
            case 1:
                listadoCategorias($controladorCategorias);
                break;

            case 2:
                session_start();    // Ya que se necesita sesión activa para sacar los retos.
                listadoRetos($controladorRetos);
                break;

            default:
                header('Location: ../index.php');
                break;
        }
    }
    else
    {
        header('Location: ../index.php');
    }

    /**
     * Crear dentro del PDF una tabla con los datos de las categorías.
     * @param ControladorCategorias $controlador Controlador de categorías.
     */
    function listadoCategorias($controlador)
    {
        // Instanciar objeto FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Título inicio documento
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', 'Listado de categorías'), 0, 0, 'C');
        $pdf->Ln(10);

        if ($controlador->cargarListado() == 1)
        {
            $categorias = $controlador->obtenerListado();
    
            // Cabecera tabla
            $header = array('ID', 'Categoría');
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
                {
                    $pdf->Cell(40, 6, iconv('UTF-8', 'windows-1252', $columna), 1);
                }
                    
                $pdf->Ln();
            }
        }
        else
        {
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(100, 10, iconv('UTF-8', 'windows-1252', 'No existen categorías.'), 0, 0, 'C');
        }

        // Generar
        $pdf->Output('categorias.pdf', 'D');
    }

    /**
     * Crear dentro del PDF una tabla con los datos de los retos del profesor actual.
     * @param ControladorRetos $controlador Controlador de retos.
     */
    function listadoRetos($controlador)
    {
        // Instanciar objeto FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Título inicio documento
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(50, 10, iconv('UTF-8', 'windows-1252', 'Listado de retos'), 0, 0, 'C');
        $pdf->Ln(10);

        if ($controlador->cargarRetos() == 1)
        {
            $retos = $controlador->obtenerListado();
    
            // Cabecera tabla
            $header = array('ID', 'Nombre', 'Dirigido a', 'Fecha inicio', 'Fecha fin');
            $w = array(20, 55, 35, 40, 40);
            $pdf->SetFillColor(0, 0, 255);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetDrawColor(0, 0, 128);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('', 'B');
    
            for($i=0; $i<count($header); $i++)
            {
                $pdf->Cell($w[$i], 7, iconv('UTF-8', 'windows-1252', $header[$i]), 1, 0, 'C', true);
            }

            // Contenido tabla
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 14);
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetTextColor(0);
    
            while($fila = $retos->fetch_array(MYSQLI_ASSOC))
            {
                $id = $fila['idReto'];
                $nombre = $fila['nombreReto'];
                $dirigido = $fila['dirigido'];
                $inicio = $fila['fechaInicioReto'];
                $fin = $fila['fechaFinReto'];

                // Formatear fechas y horas a fechas sin horas
                $f = new DateTime($inicio);
                $inicio = $f->format('d/m/Y');

                $f = new Datetime($fin);
                $fin = $f->format('d/m/Y');
                
                $pdf->Cell($w[0], 6, $id, 1);
                $pdf->Cell($w[1], 6, iconv('UTF-8', 'windows-1252', $nombre), 1);
                $pdf->Cell($w[2], 6, iconv('UTF-8', 'windows-1252', $dirigido), 1);
                $pdf->Cell($w[3], 6, $inicio, 1);
                $pdf->Cell($w[4], 6, $fin, 1);

                $pdf->Ln();
            }
        }
        else
        {
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(100, 10, iconv('UTF-8', 'windows-1252', 'El profesor actual no ha dado de alta ningún reto.'), 0, 0, 'C');
        }

        // Generar
        $pdf->Output('retos.pdf', 'D');
    }
?>