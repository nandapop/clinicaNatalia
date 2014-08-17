<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Paciente.php");
include_once("clases/Cita.php");
include_once("clases/Receta.php");
include_once("clases/exLab.php");

$idPaciente = utf8_decode($_POST["idPaciente"]); 
$idCita = utf8_decode($_POST["idCita"]);

$citaEliminar = Cita::obtenerPorId($idCita);
$examenes = exLab::obtenerExLabPorIdCita($idCita);
// Eliminamos los examenes
foreach($examenes as $examen)
{
	$examen->eliminar();
}
// Eliminamos las prescripciones
$recetasEliminar = Receta::obtenerRecetaPorIdcita($idCita);
foreach($recetasEliminar as $recetaEliminar)
{
	$recetaEliminar->eliminar();
}
$citaEliminar->eliminar();

// Listamos el resto.
	$citas = Cita::listarPorEstadoyPaciente(3,$idPaciente);
	$i=0;  
	echo "<table width=\"100%\" style=\"display:none;\" id=\"hist\">";
	if(count($citas)<1)
	{
		echo "<tr><td>Sin Historial</td></tr>";
	}
	else
	{	
		foreach($citas as $cita)
		{
			list($ano,$mes,$resto)=split("-",$cita->FechaCita);
			list($dia,$rest)=split(" ",$resto);
			
			echo "<tr>
					<td style=\"background-color: ";
			if(($i%2)==0) echo "#B7D7AF";
			else echo "#7F9BC5";
			echo "\" colspan=\"2\">FECHA CITA:$dia/$mes/$ano <a href='fichaPaciente.php?idCita=$cita->IdCita' onClick='return targetopener(this, false, false, $cita->IdCita)'> Ver </a> <a onclick='eliminarCita($cita->IdCita);'>Eliminar</a></td>
				  </tr>";
			echo "<tr>
					<td valign=\"top\" width=\"25%\">Diagnostico</td>
					<td><div id=\"$cita->IdCita\">";
			if ($cita->DiagnosticoCita=="") echo "No hay diagnostico";
			else echo $cita->DiagnosticoCita;
			
			echo "</div></td>
				  </tr>";
			echo "<tr>
					<td valign=\"top\">Receta</td>
					<td><ul id=\"$i\">";
			$recetas = Receta::obtenerRecetaPorIdcita($cita->IdCita);
			foreach($recetas as $receta)
			{
				echo "<li>";
				echo nl2br($receta->Indicaciones);
				echo "</li>";
			}
			echo "</ul></td></tr>";	
			$i++;
		}
	}
	echo "</table>";
?>