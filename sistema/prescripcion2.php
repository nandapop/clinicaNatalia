<?php
require('impresiones/fpdf.php');
include_once("clases/Receta.php");
//include_once("clases/Cita.php");
$idCita = $_POST['idCita'];
//$pdf=new FPDF();
$pdf = new FPDF('P','cm',array(13,21));
$pdf->SetLeftMargin(2);
$pdf->AddPage();

//$pdf->Cell(0,0,'ID CITA'.':'.$idCita,0,0,'C');
//$pdf->Cell(20,2,'Medicamento :');
/*for($i=1;$i<=40;$i++)
	$pdf->Cell(20,1,'Imprimiendo línea número '.$i,0,1);*/
$pdf->Ln(2);
$recetas = Receta::obtenerRecetaPorIdcita($idCita);
foreach($recetas as $receta)
{	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(10,1,$receta->Medicamento,0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,1,$receta->Indicaciones,0,1,'L');
}
$pdf->Output();
?>