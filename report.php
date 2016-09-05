<?php

include 'secure.php';
include 'conection.php';
include 'fpdf/fpdf.php';

class PDF_cuadro extends FPDF {

    function inicializar() {
        $this->SetDrawColor(191, 191, 191);
        $this->SetFillColor(235, 240, 250); //ninguno
    }

    function cuadro($tipo = 0, $tipoborde = 0, $tamano = 0, $texto1 = "") {
        //210 width pagina total
        //170 es sin los margenes 20+20. entonces 170/12=14.1666
        $col = $tamano * 14.1666666666666666666666666;

        switch ($tipoborde) {
            case 1:
                $border = "TL";
                break;
            case 2:
                $border = "T";
                break;
            case 3:
                $border = "TR";
                break;
            case 4:
                $border = "L";
                break;
            case 5:
                $border = "";
                break;
            case 6:
                $border = "R";
                break;
            case 7:
                $border = "BL";
                break;
            case 8:
                $border = "B";
                break;
            case 9:
                $border = "BR";
                break;
        }
        $fill = 0;



        switch ($tipo) {
            case 0:
                $h = 16;
                //$this->Ln($h);
                $this->SetTextColor(0, 112, 192);
                $this->SetFont('helvetica', '', $h);
                $border = "";
                break;
            case 1:
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('helvetica', '', $h = 12);
                $fill = 1;
                break;
            case 2:
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('helvetica', '', $h = 10);
                break;
            case 3:
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('helvetica', 'B', $h = 8);
                break;
            case 4:
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('helvetica', '', $h = 8);
                break;
        }
        $x = ($this->GetX()) + ($col);

        $texto1 = utf8_decode($texto1);

        if (($tipo == 4) and ( $tamano == 12)) {
            $this->MultiCell($col, $h - ($h / 2), $texto1, 'LBR', 'J', $fill);
        } else {
            $this->Cell($col, $h - ($h / 5), $texto1, $border, ($x > 189 ? 1 : 0), 'L', $fill);
        }
    }

}

$pdf = new PDF_cuadro();
//$pdf = new FPDF();

$pdf->AddPage();
$pdf->SetMargins(20, 10, 20, 5);
//$pdf->AddFont('segoeuil');
$pdf->SetDrawColor(204, 204, 204); //gris
$pdf->SetDrawColor(191, 191, 191); //ninguno
$pdf->SetLineWidth(0.3);
$pdf->SetFillColor(0, 0, 0); //ninguno
$pdf->SetFillColor(235, 240, 250); //ninguno
$pdf->SetFont('helvetica', '', 8);
//$pdf->Cell(0, 20, $pdf->Image('img/logo.png', 150, 18, 33, 0), 1, 1, 'R');
$pdf->Image('img/logo.png', 150, 15, 38);
$pdf->Ln(33);






$query = "select p.id, p.reqpor, date_format(p.fecha,'%d/%b/%Y') as f, d.depto, p.moneda, p.monto, p.iva, p.totalpagoq, p.metodopagoid, p.recepbienes, p.ordencomp, p.paguesea, p.just, p.infoad, p.epepid, c.costo, m.cuentamayor     from pagos p, sdepto d, ccosto c, cmayor m where (p.deptoid=d.id) and (p.ccostid=c.id) and (p.cmayorid=m.id)"
        . " and (p.id=" . $_GET['id'] . ")"
        . " and (p.deptoid=" . $_SESSION['deptoid'] . ")";




$result = mysqli_query($link, $query);
mysqli_data_seek($result, 0);
$row = mysqli_fetch_row($result);





//$pdf->cuadro(2, 5, 9, "");
$pdf->cuadro(0, 1, 10, "REQUERIMIENTO DE PAGO");
$pdf->cuadro(2, 0, 2, "ID:" . sprintf("%06d", $row[0]));
$pdf->ln(12); 


$pdf->cuadro(3, 1, 9, "REQUERIDO POR:");
$pdf->cuadro(3, 3, 3, "FECHA CREACION:");
$pdf->cuadro(4, 4, 9, $row[1]);
$pdf->cuadro(4, 6, 3, $row[2]);

$pdf->cuadro(3, 1, 11, "DEPARTAMENTO | UNIDAD DE PROGRAMA:");
$pdf->cuadro(3, 3, 1, "");
$pdf->cuadro(4, 4, 11, $row[3]);
$pdf->cuadro(4, 6, 1, "");

$pdf->cuadro(1, 1, 11, "INFORMACION DEL REQUERIMIENTO:");
$pdf->cuadro(1, 3, 1, "");





$pdf->cuadro(3, 1, 3, "MONTO: " . $row[4] . " " . number_format($row[5], 2, '.', ','));
$pdf->cuadro(3, 2, 3, "METODO DE PAGO:");
$pdf->cuadro(3, 2, 3, "RECEPCION DE BIENES:");
$pdf->cuadro(3, 3, 3, "ORDEN DE COMPRA:");

$pdf->cuadro(4, 4, 3, "IVA: " . $row[6]);
$pdf->cuadro(4, 5, 3, $row[8]);
$pdf->cuadro(4, 5, 3, $row[9]);
$pdf->cuadro(4, 6, 3, $row[10]);

$pdf->cuadro(4, 4, 11, "TOTAL A PAGAR: " . $row[7]);
$pdf->cuadro(4, 6, 1, "");

$pdf->cuadro(3, 1, 11, "PAGUESE A:");
$pdf->cuadro(3, 3, 1, "");
$pdf->cuadro(4, 4, 12, "$row[11]");


$pdf->cuadro(3, 1, 11, "JUSTIFICACION DEL PAGO:");
$pdf->cuadro(3, 3, 1, "");
$pdf->cuadro(4, 4, 12, "$row[12]");


$pdf->cuadro(3, 1, 11, "INFORMACION ADICIONAL:");
$pdf->cuadro(3, 3, 1, "");
$pdf->cuadro(4, 4, 12, "$row[13]");


$pdf->cuadro(1, 1, 11, "CARGAR A LA CUENTA");
$pdf->cuadro(1, 3, 1, "");

$pdf->cuadro(3, 1, 4, "ELEMENTO PEP:");
$pdf->cuadro(3, 2, 4, "CENTRO DE COSTO:");
$pdf->cuadro(3, 3, 4, "CUENTA MAYOR:");

$pdf->cuadro(4, 4, 4, "$row[14]");
$pdf->cuadro(4, 5, 4, "$row[15]");
$pdf->cuadro(4, 6, 4, "$row[16]");




$pdf->cuadro(1, 1, 11, "LEA LAS GARANTIAS ANTES DE FIRMAR");
$pdf->cuadro(1, 3, 1, "");

if ($row[5] > $_SESSION['nivelaut']) {
    $pdf->cuadro(3, 1, 3, "ELABORADO:");
    $pdf->cuadro(3, 1, 3, "APROBADO:");
    $pdf->cuadro(3, 1, 3, "CERTIFICADO:");
    $pdf->cuadro(3, 1, 2, "DIRECTORA:");
    $pdf->cuadro(3, 3, 1, "");

    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 2, "");
    $pdf->cuadro(4, 6, 1, "");

    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 4, 2, "");
    $pdf->cuadro(4, 6, 1, "");

    $pdf->cuadro(4, 7, 3, "Empleado delegado");
    $pdf->cuadro(4, 7, 3, "Jefe depto / Gerente");
    $pdf->cuadro(4, 7, 3, "Finanzas / Sub-gerente");
    $pdf->cuadro(4, 7, 2, "Directora");
    $pdf->cuadro(4, 9, 1, "");
} else {
    $pdf->cuadro(3, 1, 4, "ELABORADO:");
    $pdf->cuadro(3, 1, 4, "APROBADO:");
    $pdf->cuadro(3, 1, 3, "CERTIFICADO:");
    $pdf->cuadro(3, 3, 1, "");

    $pdf->cuadro(4, 4, 4, "");
    $pdf->cuadro(4, 4, 4, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 6, 1, "");

    $pdf->cuadro(4, 4, 4, "");
    $pdf->cuadro(4, 4, 4, "");
    $pdf->cuadro(4, 4, 3, "");
    $pdf->cuadro(4, 6, 1, "");

    $pdf->cuadro(4, 7, 4, "Empleado delegado");
    $pdf->cuadro(4, 7, 4, "Jefe depto / Gerente");
    $pdf->cuadro(4, 7, 3, "Finanzas / Sub-gerente");
    $pdf->cuadro(4, 9, 1, "");
}


$garantias = "ELABORADO: Declara que el Pago o servicio es para propósitos de PLAN, y que todos los detalles que se proveen en este   requerimiento son verdaderos y correctos."
        . "\nAPROBADO: Autorizo el pago a ser hecho o servicios a ser obtenidos de acuerdo a los procedimientos de PLAN. Además, Certifican que ninguna excepción a los procedimientos como se explico es aceptable / razonable y está autorizado bajo su   discreción ejecutiva."
        . "\nCERTIFICA: Confirma que: El requerimiento es aritméticamente correcto; los documentos que la soportan están completos y Correctos; hay un presupuesto aprobado|disponible para el objeto del requerimiento; y que está en conformidad con las   políticas y procedimientos de PLAN.";
        
$pdf->cuadro(4, 4, 12, $garantias);














            





$pdf->Output('PAGO-' . sprintf("%06d", $row[0]),'I');
return false;
?>