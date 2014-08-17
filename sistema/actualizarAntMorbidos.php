<?php
require_once("clases/AlergiaPaciente.php");
require_once("clases/Alergia.php");
$guardados=0;
$cantAlergia=$_POST['cantalergia'];
$idPaciente=$_POST['idPaciente'];
$alergias = Alergia::listarAlergias();
for($i=0;$i<count($alergias);$i++)
{
	$idAlergia = $alergias[$i]->IdAlergia;
	$alergiaExistentes=new AlergiaPaciente($idPaciente,$idAlergia,"");
	if($alergiaExistentes->existe())
		$alergiaExistentes->eliminar();
}
$retorno="esto:";	
for($i=0;$i<$cantAlergia;$i++)
{
	$idAlergia=$_POST['alergia'.$i];
	$comentario=$_POST['comentario'.$i];
	
	$alergiaPaciente = new AlergiaPaciente($idPaciente, $idAlergia, $comentario);
	$retorno=$retorno." + ".$alergiaPaciente->IdAlergia." - ". $alergiaPaciente->IdPaciente." - ".$alergiaPaciente->Comentario;
	//revisamos si es que existe este antecedente para el paciente
	//si existe lo eliminamos y despues lo guardamos
	if($alergiaPaciente->insertar()!=-1)$guardados++;
}

if($guardados==$cantAlergia)
	echo "OK&".$retorno;
?>
