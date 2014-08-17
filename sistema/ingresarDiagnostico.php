<?php 
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Cita.php");
$idCita = utf8_decode($_POST["idCita"]); 
$diagnosticoCita = $_POST["diagnostico"];
$cita = Cita::obtenerPorId($idCita);
$cita->DiagnosticoCita = $diagnosticoCita;
if($cita->modificar())
{
	echo $diagnosticoCita;
	echo "<br /><br />Diagnostico ingresado con exito";
}
else
{
	echo "Ha habido un error al ingresar el diagnostico";
}
?>
