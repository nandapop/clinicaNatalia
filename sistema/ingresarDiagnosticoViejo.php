<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
include_once("clases/Cita.php");
$idPaciente = utf8_decode($_POST["idPaciente"]); 
$fecha = utf8_decode($_POST["fecha"]);
$diagnostico = utf8_decode($_POST["diagnostico"]);

$hora = "00";
$minutos = "00";
$segundos = "00";
list($ano, $mes, $dia) = split("-",$fecha);
$fechaCita= $ano."/".$mes."/".$dia." ".$hora.":".$minutos.":".$segundos;

$cita = new Cita(0, $idPaciente, 3, $fechaCita, $tipoCita, $diagnostico, $fechaCita, 0, 0, -1);
$idCita = $cita->insertar();
if($idCita == -1)
{}
else
{
	if(!isset($_SESSION["pac"]))
	{
		$_SESSION["pac"] = serialize(array());
	}
	$recetas = unserialize($_SESSION["pac"]);
	
	// print_r($_SESSION["pac"]);
	foreach($recetas as $receta)
	{
		$receta->IdCita = $idCita;
		$receta->insertar();
	}
	unset($_SESSION["pac"]);
	if(!isset($_SESSION["pac"]))
	{
		$_SESSION["pac"] = serialize(array());
	}
	$recetas = unserialize($_SESSION["pac"]);
	$i = 0;
	echo "<ul>";
	foreach($recetas as $receta)
	{
		echo "<li>";
		echo "<input type='button' value='Borrar' onclick='borrarPrescripcion($i)'>";
		echo "<ul>";
		echo "<li>";
		echo "<input name='idReceta' id='idReceta' type='hidden' value='$receta->IdReceta'>";
		echo $receta->Medicamento . " - " . $receta->Indicaciones . "";
		echo "</li>";
		echo "</ul>";
		echo "</li>";
		$i++;
	}
	echo "</ul>";
}
?>
