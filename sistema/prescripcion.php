<?php
//require('impresiones/fpdf.php');
define('FPDF_FONTPATH','font/');
require('impresiones/fpdf_js.php');
include_once("clases/Receta.php");
include_once("clases/Paciente.php");
include_once("clases/Cita.php");
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");
$idCita = $_POST['idCita'];
$prescripciones = $_POST['prescripciones'];
$pdf = new PDF_AutoPrint('P','cm','Letter');
$pdf->SetRightMargin(8);
//$pdf->SetAutoPageBreak(true,10);
$pdf->AddPage();
//$pdf->Ln(2);
//$espacio= 16.5 - $y 
//x= numeroletras/45  + num enter = numero lineas + 1
if (count($prescripciones) > 0 )
{
	// Loop para cada prescripcion
	foreach($prescripciones as $prescripcion)
	{
		$receta = Receta::obtenerRecetaPorId($prescripcion);
		$pdf->SetFont('Arial','',12);
		//$pdf->SetTextColor(255,255,0);
		$pdf->SetX(2);
		$y=$pdf->GetY();
		$espacio = 17 - $y;
		$numLetras = strlen($receta->Indicaciones);
		$contados = count_chars($receta->Indicaciones, 1);
		$numeroEnter = $contados[10];
		$numeroLineas = $numLetras / 45 + $numeroEnter;
		if ($espacio < $numeroLineas)
		{
			$pdf->AddPage();
			$pdf->SetX(2);
		}
		$pdf->MultiCellBlt(10,1,chr(149),($receta->Indicaciones),0,1,'L');
		$pdf->Ln(0.5);
	}
}
$pdf->AutoPrint(true);
$pdf->Output();
?>