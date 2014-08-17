<?php
session_start();
require('impresiones/fpdf.php');

class PDF_Javascript extends FPDF
{

	var $javascript;
	var $n_js;

	function IncludeJS($script) {
		$this->javascript=$script;
	}

	function _putjavascript() {
		$this->_newobj();
		$this->n_js=$this->n;
		$this->_out('<<');
		$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
		$this->_out('>>');
		$this->_out('endobj');
		$this->_newobj();
		$this->_out('<<');
		$this->_out('/S /JavaScript');
		$this->_out('/JS '.$this->_textstring($this->javascript));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putresources() {
		parent::_putresources();
		if (!empty($this->javascript)) {
			$this->_putjavascript();
		}
	}

	function _putcatalog() {
		parent::_putcatalog();
		if (isset($this->javascript)) {
			$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
		}
	}
}

class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
	//Launch the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}

	//Cabecera de pagina
	function Header()
	{
		$this->SetFont('Arial','B',14);
		//$this->SetTextColor(255,255,0);
		$cita = Cita::obtenerPorId($_POST['idCita']);
		$paciente = Paciente::obtenerPorId($cita->IdPaciente);
		$usuario = Usuario::obtenerPorId($_SESSION['idUsuario']);
		$this->SetXY(2.5,4);
		$this->Cell(8,1,"Nombre:  " .$paciente->NombreCompleto,0,1,'L');
		$this->SetX(2.5);
		$this->Cell(8,1,"Rut:  " .$paciente->Run,0,1,'L');
		//$this->SetX(2.5);
		//$this->Cell(8,1,"Atendido por:	".$usuario->NombreCompleto,0,1,'L');
		$this->Ln(1);		
	}

	//Pie de pagina
	function Footer()
	{
		$cita = Cita::obtenerPorId($_POST['idCita']);
		$this->SetXY(1.5,19.5);
		$this->Cell(8,1,date("j-m-Y"),0,1,'R');
		//fecha hoy
	}
	
	//MultiCell with bullet
    function MultiCellBlt($w,$h,$blt,$txt,$border=0,$align='J',$fill=0)
    {
        //Get bullet width including margins
        $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

        //Save x
        $bak_x = $this->x;

        //Output bullet
        $this->Cell($blt_width,$h,$blt,0,'',$fill);
        //Output text
        $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

        //Restore x
        $this->x = $bak_x;
    }
	
	function ObtenerFila()
	{
	
	}
}
?>