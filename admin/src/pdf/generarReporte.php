<?php
require_once '../../conexion.php';
require_once 'fpdf/fpdf.php';
//$pdf = new FPDF('P', 'mm', array(80, 200));
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(10, 0, 0);
$pdf->SetTitle("Ventas");
$pdf->SetFont('Arial', 'B', 12);
$id = $_GET['v'];
$idcliente = $_GET['cl'];
$config = mysqli_query($conexion, "SELECT * FROM configuracion");
$datos = mysqli_fetch_assoc($config);
$clientes = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$datosC = mysqli_fetch_assoc($clientes);
$ventas = mysqli_query($conexion, "SELECT d.*, p.descripcion FROM detalle_venta d INNER JOIN producto p ON d.id_producto = p.codproducto WHERE d.id_venta = $id");
$pdf->MultiCell(190, 15, utf8_decode($datos['nombre']), 0, 'C');

$pdf->image("../../assets/images/logosdcreations.jpg", 170, 17, 20, 20, 'PNG');

$pdf->SetFont('Arial', 'B', 10);
//$pdf->Cell(30, 6, utf8_decode("Dirección: "), 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(190, 6, utf8_decode($datos['direccion']), 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
//$pdf->Cell(30, 6, utf8_decode("Teléfono: "), 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 6, $datos['telefono'], 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
//$pdf->Cell(30, 6, "Correo: ", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(190, 6, utf8_decode($datos['email']), 0, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(190, 7, utf8_decode("HOJA DE REPORTE"), 0, 'C');

//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(70, 5, "==============================================", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 7, "Datos del cliente", 1, 1, 'C');
//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(70, 5, "==============================================", 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 7, utf8_decode('Nombre:'), 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, 7, utf8_decode($datosC['nombre']), 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 7, utf8_decode('Teléfono:'), 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, 7, utf8_decode($datosC['telefono']), 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 7, utf8_decode('Dirección:'), 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(160, 7, utf8_decode($datosC['direccion']), 1, 'L');
$pdf->Ln(3);

//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(70, 5, "==============================================", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 7, "Detalle de Productos y/o Servicios", 1, 1, 'C');
//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(70, 5, "==============================================", 0, 1, 'C');

$pdf->Cell(100, 7, utf8_decode('Descripcion'), 1, 0, 'L');
$pdf->Cell(30, 7, 'Cantidad', 1, 0, 'L');
$pdf->Cell(30, 7, 'Precio', 1, 0, 'L');
$pdf->Cell(30, 7, 'Sub Total.', 1, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$total = 0.00;
$desc = 0.00;
while ($row = mysqli_fetch_assoc($ventas)) {
    $pdf->Cell(100, 7, $row['descripcion'], 1, 0, 'L');
    $pdf->Cell(30, 7, $row['cantidad'], 1, 0, 'L');
    $pdf->Cell(30, 7, $row['precio'], 1, 0, 'L');
    $sub_total = $row['total'];
    $total = $total + $sub_total;
    $pdf->Cell(30, 7, number_format($sub_total, 2, '.', ','), 1, 1, 'L');
}
$pdf->Ln();
//$pdf->Cell(70, 5, "=========================", 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(185, 7, 'Total Pagar', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(185, 7, number_format($total, 2, '.', ','), 0, 1, 'R');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 7, '<<Gracias por su preferencia>>', 0, 1, 'C');

$pdf->Output("ventas.pdf", "I");

?>