<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/PatologiaFrecuente.php");
$idOp=$_POST['idOp'];
if($idOp==1)
{
	$patologiafrecuente = $_POST["texto"];
	$patologia = new PatologiaFrecuente(0, $patologiafrecuente);
	$patologia->insertar();
	header('Location:patologiasFrecuentes.php?msg=Patologia guardada');
}
else if($idOp==2)
{
	$idPatologia = $_POST['idPatologia'];
	$patologia = PatologiaFrecuente::obtener($idPatologia);
	echo "OK-".$patologia->Patologia;
}
else if($idOp==3)
{
	$patologiafrecuente = $_POST["texto"];
	$idPatologia = $_POST["idPatologia"];
	$patologia = PatologiaFrecuente::obtener($idPatologia);
	$patologia->Patologia = $patologiafrecuente;
	if($patologia->modificar())
		header('Location:patologiasFrecuentes.php?msg=Patologia modificada');
	else
		header('Location:patologiasFrecuentes.php?msg=Patologia no modificada');
}

?>