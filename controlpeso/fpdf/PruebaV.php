<?php
require('./fpdf.php');

class PDF extends FPDF
{
    private $headerPosition = 0;

    function Header()
    {
        if ($this->headerPosition == 0 || $this->GetY() <= $this->headerPosition) {
            $this->Image('https://www.standrews.cl/wp-content/uploads/2022/10/logo-st-andrews.png', 260, 7, 20);
            $this->SetFont('Arial', 'B', 19);
            $this->Cell(30);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(200, 15, utf8_decode('ST. ANDREWS SMOKY DELICACIES S.A.'), 1, 1, 'C', 0);
            $this->Ln(3);
            $this->SetTextColor(103);

            // Obtener la información según el término de búsqueda
            $searchTerm = $_POST['buscar']; // Obtén el término de búsqueda
            $datosEncabezado = $this->obtenerDatosEncabezado($searchTerm); // Obtener datos para el encabezado

            // Mostrar la información en el encabezado
            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('FECHA: ' . $datosEncabezado['fecha']), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('CLIENTE: ' . $datosEncabezado['cliente']), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('LOTE: ' . $datosEncabezado['lote']), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('FICHA TÉCNICA: ' . $datosEncabezado['ficha']), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('MONITOR: ' . $datosEncabezado['monitor']), 0, 0, '', 0);
            $this->Ln(5);

            $this->Cell(10);  // mover a la derecha
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(96, 10, utf8_decode('SUPERVISOR: ' . $datosEncabezado['supervisor']), 0, 0, '', 0);
            $this->Ln(5);

            $this->SetTextColor(228, 100, 0);
            $this->Cell(90);
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(100, 10, utf8_decode("REGISTRO CONTROL DE PESO"), 0, 1, 'C', 0);
            $this->Ln(7);
            $this->SetFillColor(228, 100, 0);
            $this->SetTextColor(255, 255, 255);
            $this->SetDrawColor(163, 163, 163);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(20, 10, utf8_decode('FOLIO'), 1, 0, 'C', 1);
            $this->Cell(13, 10, utf8_decode('HORA'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 1'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 2'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 3'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 4'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 5'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 6'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 7'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 8'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 9'), 1, 0, 'C', 1);
            $this->Cell(15, 10, utf8_decode('PESO 10'), 1, 0, 'C', 1);
            $this->Cell(100, 10, utf8_decode('OBSERVACIONES'), 1, 1, 'C', 1);
        }
    }

    function obtenerDatosEncabezado($searchTerm)
    {
        $conex = mysqli_connect("localhost", "root", "", "formulario");
        if (!$conex) {
            die("Error al conectar: " . mysqli_connect_error());
        }

        // Realizar una consulta para obtener la información, incluido el nombre del cliente
        $consultaDatos = "SELECT datos.fecha, clientes.nombre_cliente AS cliente, datos.lote, datos.ficha, monitores.nombre_monitor AS monitor, supervisores.nombre_supervisor AS supervisor 
        FROM datos 
        LEFT JOIN clientes ON datos.cliente = clientes.customer_id 
        LEFT JOIN monitores ON datos.monitor = monitores.monitor_id 
        LEFT JOIN supervisores ON datos.supervisor = supervisores.supervisor_id 
        WHERE datos.fecha LIKE '%$searchTerm%' OR datos.cliente LIKE '%$searchTerm%' OR datos.lote LIKE '%$searchTerm%' OR datos.ficha LIKE '%$searchTerm%' OR datos.monitor LIKE '%$searchTerm%' OR datos.supervisor LIKE '%$searchTerm%'";
        $resultadoDatos = mysqli_query($conex, $consultaDatos);

        if ($resultadoDatos && mysqli_num_rows($resultadoDatos) > 0) {
            $fila = mysqli_fetch_assoc($resultadoDatos);
            mysqli_close($conex);
            return $fila;
        } else {
            mysqli_close($conex);
            return [
                'fecha' => '', 
                'cliente' => '', 
                'lote' => '', 
                'ficha' => '', 
                'monitor' => '', 
                'supervisor' => ''
            ]; // Retornar valores predeterminados si no se encuentran datos
        }
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $hoy = date('d/m/Y');
        $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C');
        $this->headerPosition = $this->GetY();
    }
}
function generarPDFBusqueda($searchTerm)
{
    $pdf = new PDF();
    $pdf->AddPage("landscape");
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetDrawColor(163, 163, 163);

    $conex = mysqli_connect("localhost", "root", "", "formulario");
    if (!$conex) {
        die("Error al conectar: " . mysqli_connect_error());
    }
    $consulta = "SELECT datos.*, clientes.nombre_cliente, monitores.nombre_monitor, supervisores.nombre_supervisor 
    FROM datos
    LEFT JOIN clientes ON datos.cliente = clientes.customer_id
    LEFT JOIN monitores ON datos.monitor = monitores.monitor_id
    LEFT JOIN supervisores ON datos.supervisor = supervisores.supervisor_id
    WHERE datos.fecha LIKE '%$searchTerm%' OR datos.lote LIKE '%$searchTerm%' OR clientes.nombre_cliente LIKE '%$searchTerm%' OR datos.ficha LIKE '%$searchTerm%'
    ORDER BY datos.folio";

    $resultado = mysqli_query($conex, $consulta);

    // Almacena todos los registros en una matriz
    $registros = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $registros[] = $fila;
    }

    // Mostrar la información en el PDF
    foreach ($registros as $fila) {
        $pdf->Cell(20, 10, utf8_decode($fila['folio']), 1, 0, 'C');
        $pdf->Cell(13, 10, utf8_decode($fila['hora']), 1, 0, 'C');
        for ($i = 1; $i <= 10; $i++) {
            $pdf->Cell(15, 10, utf8_decode($fila['peso' . $i]), 1, 0, 'C');
        }
        $pdf->MultiCell(100, 10, utf8_decode($fila['observaciones']), 1, 'C');
    }
    mysqli_close($conex);

    // Finaliza la generación del PDF después de obtener y mostrar los datos
    $pdf->Output('Reporte.pdf', 'I');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $searchTerm = trim($_POST['buscar']);
    generarPDFBusqueda($searchTerm);
}
?>