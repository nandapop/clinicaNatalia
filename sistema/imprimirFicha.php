<?
define('FPDF_FONTPATH','font/');
require('impresiones/fpdf_ficha.php');
include_once("clases/exLab.php");
include_once("clases/tipoEx.php");
include_once("clases/Receta.php");
include_once("clases/Paciente.php");
include_once("clases/Cita.php");
include_once("clases/AlergiaPaciente.php");
$idPaciente = $_GET['idPaciente'];

$pdf = new PDF_AutoPrint('P','cm','Letter');
$pdf->SetRightMargin(1.4);
$pdf->SetLeftMargin(1.4);
$pdf->SetAutoPageBreak(true,1);
$pdf->AddPage();
$pdf->Ln(1);

$paciente=Paciente::obtenerPorId($idPaciente);
$pdf->SetFont('Arial','BU',18);
$pdf->MultiCell(0,1,"Ficha Paciente",0,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Rut: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Run",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Nombre: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Nombre",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Apellido Paterno: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->ApellidoP",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Apellido Materno: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.8,"$paciente->ApellidoM",0,1,'L',0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Sexo: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
if($paciente->Sexo=="M")
	$sexo="Masculino";
else
	$sexo="Femenino";
$pdf->Cell(0,0.7,"$sexo",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Telefono: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Telefono",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Celular: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,1,"$paciente->Celular",0,1,'L',0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Direccion: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
if(strlen($paciente->Direccion)>=75)
{
	for($i=0;$i<=(int)(strlen($paciente->Direccion)/75);$i++)
	{
		$direccion = substr($paciente->Direccion, 75*$i, 75*($i+1));
		$pdf->Cell(0,0.7,"$direccion $j",0,1,'L',0);
	}
}
else
	$pdf->Cell(0,0.7,"$paciente->Direccion",0,1,'L',0);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Ocupacion: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Ocupacion",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Fecha Nac.: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$fechaC=split(" ",$paciente->FechaNac);
$fecha=split("-",$fechaC[0]);
$pdf->Cell(0,0.7,"$fecha[2]/$fecha[1]/$fecha[0]",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Edad: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,calcularEdad($paciente->FechaNac),0,1,'L',0);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Email: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Email",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Derivado por: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->DerivadoPor",0,1,'L',0);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Prevision: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Prevision",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Alergia: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$paciente->Alergia",0,1,'L',0);

$seguro="";
if($paciente->SeguroSalud=="0")
	$seguro="Sin información";
else if($paciente->SeguroSalud=="1")
	$seguro="Si";
else
	$seguro="No";
	
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Seguro de Salud: ",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$pdf->Cell(0,0.7,"$seguro",0,1,'L',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(4,0.7,"Primera Cita:",0,0,'L',0);
$pdf->SetFont('Arial','U',12);
$fechaC=split(" ",$paciente->FechaPrimeraCita);
$fecha=split("-",$fechaC[0]);
$pdf->Cell(0,0.7,"$fecha[2]/$fecha[1]/$fecha[0]",0,1,'L',0);

$pdf->Ln(2);
$pdf->SetFont('Arial','BU',14);
$pdf->MultiCell(0,1,"Historial Medico",0,'C');

$citas=Cita::listarPorIdPaciente($idPaciente);
$i=1;
foreach($citas as $cita)
{
	$fechaC=split(" ",$cita->FechaCita);
	$fecha=split("-",$fechaC[0]);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(1,1,"$i)",0,0,'L',0);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(1.4,1,"Fecha:",0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,1,"$fecha[2]/$fecha[1]/$fecha[0]",0,1,'L',0);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(3,1,"Diagnostico:",0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(0,1,"$cita->DiagnosticoCita",0,1,'L',0);
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(3,1,"Recetas:",0,1,'L',0);
	$recetas = Receta::obtenerRecetaPorIdcita($cita->IdCita);
	if(count($recetas)!=0)
		foreach($recetas as $receta)
		{
			$pdf->SetFont('Arial','',12);
			$pdf->SetX(2);
			$pdf->MultiCell(0,1,("»» ".$receta->Indicaciones),0,1,'L');
		}
	else
	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(3,1,"No Hubo receta.",0,1,'L',0);
	}
		
	$pdf->SetFont('Arial','U',12);
	$pdf->Cell(3,1,"Examenes:",0,1,'L',0);
	$examenes = exLab::obtenerExLabPorIdCita($cita->IdCita);
	if(count($examenes)!=0)
		foreach($examenes as $examen)
		{	
			$tipoEx = tipoEx::obtenerExamenPorId($examen->IdTipo);
			$pdf->SetFont('Arial','',12);
			$pdf->MultiCell(0,1,"»» ".$tipoEx->Nombre,0,1,'L');
		}
	else
	{
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(3,1,"No hubo examenes.",0,1,'L',0);
	}
		
	$i++;
}
$pdf->AutoPrint(true);
$pdf->Output();


function calcularEdad($fecha)
{
	//fecha actual
	$dia=date(j);
	$mes=date(n);
	$ano=date(Y);
	//fecha de nacimiento
	list($anonaz, $mesnaz, $diax) = split("-",$fecha);
	list($dianaz, $resto) = split(" ",$diax);
	//si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual
	if (($mesnaz == $mes) && ($dianaz > $dia))
		$ano=($ano-1);
	//si el mes es superior al actual tampoco habra cumplido años, por eso le quitamos un año al actual
	if ($mesnaz > $mes)
		$ano=($ano-1);
	//ya no habria mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
	$edad=($ano-$anonaz);
	return $edad;
}

?>