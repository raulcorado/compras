<?php

include 'secure.php';
include 'conection.php';
include 'fpdf/fpdf.php';



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20, 20);
//$pdf->AddFont('segoeuil');
$pdf->SetFont('helvetica', '', 14);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(204, 204, 204); //gris
$pdf->SetDrawColor(191, 191, 191); //ninguno
$pdf->SetFillColor(0, 0, 0); //ninguno
$pdf->SetFillColor(235, 240, 250); //ninguno
$pdf->SetFont('helvetica', '', 8);
//$pdf->Cell(0, 20, $pdf->Image('img/logo.png', 150, 18, 33, 0), 1, 1, 'R');
$pdf->Image('img/logo.png', 150, 18, 33);
$pdf->Ln(33);

class PDF_cuadro extends FPDF {

    function cuadro($texto) {
        $pdf->Cell(0, 10, $texto, 1, 1, "L", 1);
    }

}
$pdf = new PDF_cuadro();
$pdf->cuadro("hola hola");

$pdf->Cell(0, 10, "REQUERIMIENTO DE PAGO", 1, 1, "L", 1);
$pdf->Cell(0, 10, "REQUERIMIENTO DE PAGO", 1, 1, "L", 1);
$pdf->Cell(0, 10, "REQUERIMIENTO DE PAGO", 1, 1, "L", 1);

//$pdf->Cell(150, 25, "REQUERIMIENTO DE PAGO", 1, 1,"R",0);

$pdf->Cell(150, 10, "    HOLA MUNDO", 1, 0, "", 1);
$pdf->SetFillColor(239, 235, 250);
$pdf->Cell(20, 10, "HOLA MUNDO", 1, 1, "", 1);
$pdf->Cell(120, 10, "", 1, 0);
$pdf->Cell(50, 10, "", 1, 1);
//170 width total

$text = "Es posible usar el formato apaisado, otros formatos de página y otras unidades de medida formato apaisado, otros formatos de página y otr Es posible usar el formato apaisado, otros formatos de página y otras unidades de medida formato apaisado, otros formatos de página y otr Es posible usar el formato apaisado, otros formatos de página y otras unidades de medida formato apaisado, otros formatos de página y otr Es posible usar el formato apaisado, otros formatos de página y otras unidades de medida formato apaisado, otros formatos de página y otr Es posible usar el formato apaisado, otros formatos de página y otras unidades de medida formato apaisado, otros formatos de página y otr \n\n";

$query = "select * from PAGOS";
$result = mysqli_query($link, $query);
mysqli_data_seek($result, 0);
$row = mysqli_fetch_row($result);

$pdf->Cell(($pdf->w) / 3, 10, $_GET['id'], 1, 1);
$pdf->Cell(($pdf->w) / 3, 10, $row[0], 1, 0);
$pdf->Cell(($pdf->w) / 3, 10, $row[1], 1, 0);
$pdf->Cell(($pdf->w) / 3, 10, $row[2], 1, 1);
$pdf->Cell(($pdf->w) / 3, 10, $row[3], 1, 0);




while ($row = mysqli_fetch_row($result)) {
    $pdf->Cell(($pdf->w) / 3, 10, $row[0], 1, 0);
    $pdf->Cell(($pdf->w) / 3, 10, $row[1], 1, 0);
    $pdf->Cell(($pdf->w) / 3, 10, $row[2], 1, 1);
    $pdf->Cell(($pdf->w) / 3, 10, $row[3], 1, 0);
}


//$pdf->MultiCell(0, $tam/1.8, $text, 0, "J");
//$pdf->MultiCell(0, $tam/1.8, $text, 0, "J");
//$pdf->Output($_POST['reqajustar'].".pdf","D");
$pdf->Output();
return false;
?>