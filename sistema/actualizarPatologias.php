<?php
require_once("clases/PatologiaPaciente.php");
require_once("clases/PatologiaFrecuente.php");
$guardados=0;
$cantPatologia = $_POST['cantPatologia'];
$idPatologia = $_POST['idPatologia'];
$idPaciente = $_POST['idPaciente'];

$patologias = PatologiaFrecuente::listar();
for($i = 0; $i< count($patologias); $i++)
{
	$idPatologia = $patologias[$i]->Id;
	$patololiasExistentes=new PatologiaPaciente($idPatologia, $idPaciente);

	if($patololiasExistentes->existe())
		$patololiasExistentes->eliminar();
}
$retorno="esto:";	

for($i = 0; $i < $cantPatologia; $i++)
{
	$idPatologia=$_POST['idPatologia'.$i];
	
	$patologiaPaciente = new PatologiaPaciente( $idPatologia, $idPaciente);
	$retorno=$retorno." + ".$patologiaPaciente->Id." - ". $patologiaPaciente->IdPaciente;
	//revisamos si es que existe este antecedente para el paciente
	//si existe lo eliminamos y despues lo guardamos
	if($patologiaPaciente->insertar()!=-1)$guardados++;
}

if($guardados==$cantPatologia)
	echo "OK&".$retorno;
?>
