<?
define('FPDF_FONTPATH','font/');
require('impresiones/fpdf_js2.php');
include_once("clases/exLab.php");
include_once("clases/tipoEx.php");
include_once("clases/Paciente.php");
include_once("clases/Cita.php");
$idCita = $_POST['idCita'];

$pdf = new PDF_AutoPrint('P','cm','Letter');
$pdf->SetRightMargin(8);
$pdf->SetAutoPageBreak(true,10);
$pdf->AddPage();
//$pdf->Ln(2);

$examenes = exLab::obtenerExLabPorIdCita($idCita);
foreach($examenes as $examen)
{	
	$tipoEx = tipoEx::obtenerExamenPorId($examen->IdTipo);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,1,"º ".$tipoEx->Nombre,0,1,'L');
}
$pdf->AutoPrint(true);
$pdf->Output();

?>