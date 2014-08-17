<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
$i = utf8_decode($_POST["i"]); 
$recetasOrigen = unserialize($_SESSION["pac"]);
$recetas = array();
$j = 0;
foreach($recetasOrigen as $receta)
{
	if($j != $i)
	{
		$recetas[] = $receta;
	}
	$j++;
}
$_SESSION["pac"] = serialize($recetas);
// print_r($_SESSION["pac"]);
$i = 0;
foreach($recetas as $receta)
{
	echo "<li>";
	echo "<input type='button' value='borrar' onclick='borrarPrescripcion($i)'>";
	echo "<ul>";
	echo "<li>";
	echo "<input name='idReceta' id='idReceta' type='hidden' value='$receta->IdReceta'>";
	echo nl2br($receta->Indicaciones);
	echo "</li>";
	echo "</ul>";
	echo "</li>";
	$i++;
}
?>