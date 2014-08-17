<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/RecetaFrecuente.php");
$idOp=$_POST['idOp'];
if($idOp==1)
{
	$recetafrecuente = $_POST["texto"];
	$receta = new RecetaFrecuente(0, $recetafrecuente);
	$receta->insertar();
	header('Location:recetasFrecuentes.php?msg=Receta guardada');
}
else if($idOp==2)
{
	$idReceta = $_POST['idReceta'];
	$receta = RecetaFrecuente::obtener($idReceta);
	echo "OK-".$receta->Receta;
}
else if($idOp==3)
{
	$recetafrecuente = $_POST["texto"];
	$idReceta = $_POST["idReceta"];
	$receta = RecetaFrecuente::obtener($idReceta);
	$receta->Receta = $recetafrecuente;
	if($receta->modificar())
		header('Location:recetasFrecuentes.php?msg=Receta modificada');
	else
		header('Location:recetasFrecuentes.php?msg=Receta no modificada');
}

?>