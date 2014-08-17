<?php
	$idPaciente = utf8_decode($_POST["idPaciente"]); 
	include_once("clases/Cita.php");
	include_once("clases/Receta.php");
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
			echo "\" colspan=\"2\">FECHA CITA: <br />";
			?>
			<form id="frmModificarFechaCitaVieja<?php echo $cita->IdCita; ?>" name="frmModificarFechaCitaVieja<?php echo $cita->IdCita; ?>" method="post" action="">
				<input name="diaCitaVieja" type="text" id="diaCitaVieja" value="<?php echo $dia; ?>" size="3" maxlength="2" /> 
				/ <input name="mesCitaVieja" type="text" id="mesCitaVieja" value="<?php echo $mes; ?>" size="3" maxlength="2" /> 
				/ <input name="anoCitaVieja" type="text" id="anoCitaVieja" value="<?php echo $ano; ?>" size="4" maxlength="4" />
				</form>
			<?php
			echo "<a href=\"#\" onclick='modificarFechaCitaVieja($cita->IdCita);'>Modificar Fecha</a>&nbsp;&nbsp;<a href='fichaPaciente.php?idCita=$cita->IdCita' onClick='return targetopener(this, false, false, $cita->IdCita)'>Ver</a>&nbsp;&nbsp;<a href=\"#\" onclick='eliminarCita($cita->IdCita);'>Eliminar</a></td>
				  </tr>";
			echo "<tr>
					<td valign=\"top\" width=\"25%\">Diagnostico</td>
					<td align=\"left\"><div id=\"$cita->IdCita\">";
			if ($cita->DiagnosticoCita=="") echo "No hay diagnostico";
			else echo nl2br($cita->DiagnosticoCita);
			
			echo "</td>
				  </tr>";
			echo "<tr>
					<td valign=\"top\">Receta</td>
					<td align=\"left\"><ul id=\"$i\">";
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
