<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
$idPaciente = utf8_decode($_POST["idPaciente"]); 
//$medicamento = utf8_decode($_POST["medicamento"]);
$indicaciones = utf8_decode($_POST["indicaciones"]);
$receta = new Receta(0,$indicaciones,0);
if(!isset($_SESSION["pac"]))
{
	$_SESSION["pac"] = serialize(array());
}
$recetas = unserialize($_SESSION["pac"]);
$recetas[] = $receta;
$_SESSION["pac"] = serialize($recetas);
// print_r($_SESSION["pac"]);
$i = 0;
echo "<ul>";
foreach($recetas as $receta)
{
	echo "<li>";
	echo "<input type='button' value='borrar' onclick='borrarPrescripcion($i)'>";
	echo "<ul>";
	echo "<li>";
	echo "<input name='idReceta' id='idReceta' type='hidden' value='$receta->IdReceta'>";
	//echo $receta->Medicamento . " - " . $receta->Indicaciones . "";
	echo nl2br($receta->Indicaciones);
	echo "</li>";
	echo "</ul>";
	echo "</li>";
	$i++;
}
echo "</ul>";

?>