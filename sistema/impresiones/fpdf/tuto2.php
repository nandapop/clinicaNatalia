<?php
require('../fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	$idCita = $_POST['idCita'];
	//Arial bold 15
	//$medicamento = 'Viadil';
	$this->SetFont('Arial','B',15);
	//Movernos a la derecha
	//$this->Cell(80);
	//Título
	$this->Cell(3,6,'Receta Medica',0,0,'C');
	$this->Cell(5,8,$$idCita,0,0,'C');
	//Salto de línea
	$this->Ln(20);
}

//Pie de página
function Footer()
{
	//Posición: a 6 cm del final
	$this->SetY(-6);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Número de página
	//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
	$this->Cell(0,9,'Pie de pagina',0,0,'C');
}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','cm',array(13,21));
//$pdf=new PDF();
//$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->SetFont('Times','',12);

//for($i=1;$i<=40;$i++)
	//$pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
		$pdf->Cell(7,9,'Pie de pagina',0,0,'C');
$pdf->Output();

$recetas = Receta::obtenerRecetaPorIdcita($idCita);
		foreach($recetas as $receta)
		{
			echo "<li>";
			echo "<input type='button' value='borrar' onclick='borrarPrescripcion($idCita,$receta->IdReceta)'>";
			echo "<ul>";
			echo "<li>";
			echo "<input name='idReceta' id='idReceta' type='hidden' value='$receta->IdReceta'>";
			echo $receta->Medicamento . " - " . $receta->Indicaciones . "";
			echo "</li>";
			echo "</ul>";
			echo "</li>";
		}
?>
