<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Cita.php");
include_once("clases/Receta.php");
include_once("clases/tipoEx.php");
include_once("clases/exLab.php");
include_once("clases/Foto.php");
/* Declaro como indice del array los distintos identificadores de seccion que ya habia declarado como valor en la configuracion del archivo JS.
Como valores declaro otro array que contiene el nombre de la tabla donde tiene que buscar los datos de la seccion (por ejemplo tabs_tabla_1), el nombre de la columna
que actua como ID, el valor que debe contener ese ID y tambien la columna en donde esta el string de la seccion.
Para mas claridad por favor revisen la estructura de las tablas adjuntas en el .sql. */

/*$secciones=array(
'seccion1'=>array('tabs_tabla_1', 'id', '1', 'datos'),
'seccion2'=>array('tabs_tabla_1', 'id', '2', 'datos'),
'seccion3'=>array('tabs_tabla_2', 'id', '1', 'datos')
);*/

$seccion = $_POST['seccion'];
$idCita = $_POST['idCita'];
$idPaciente = $_POST['idPaciente'];
if ($seccion == 'diagnostico')
{
$cita = Cita::obtenerPorId($idCita);
?>
	<form method="post" action="ingresarDiagnostico.php" name="ingresarDiagnostico" id="ingresarDiagnostico">
	<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">
	<textarea name='diagnostico' id="diagnostico" style="width:500; height:200"><?php echo $cita->DiagnosticoCita; ?></textarea><br />
	<input type='button' value='guardar' onclick="guardarDiagnostico();">
	</form>
<?php
}
else if ($seccion == 'prescripcion')
{
?>
<table style="border:0px #33CC00 dashed;">
	<tr>
		<table style="border:0px" >
			<tr>
				<td width="40%" rowspan="2" valign="top" style="border:1px dotted #999999; border-left-color:#FFFFFF; border-top-color:#FFFFFF; border-bottom-color:#FFFFFF"><p>Ingresar Medicamento</p>
		    	<form method="post" action="ingresarPrescripcion.php" name="ingresarPrescripcion" id="ingresarPrescripcion">
				<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>"><input name="idReceta" id="idReceta" type="hidden" value="0">
				<p align="left"><textarea name='indicaciones' id="indicaciones" cols='3' rows='3' onkeyup="inputFilling(event, this);" onblur="setInput(this, document.getElementById('lista'))"></textarea>
				<input type='button' value='guardar' onclick="guardarPrescripcion();" /> <input name="btnCancelar" id="btnCancelar" type='button' value='cancelar' onclick="cancelarEdicion();" style="display:none"/></p>
		  		</form>
	  			</td>
				<td width="60%" style="border: #FFFFFF 1px;" valign="top"><b><center>PRESCRIPCIONES</center></b></td>
			</tr>
			<tr>
			<td valign="top">
				<form id="formImprimirPrescripcion" name="formImprimirPrescripcion" method="post" action="prescripcion.php" target="_blank">
				<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">
				<table>
				<?php
				$recetas = Receta::obtenerRecetaPorIdcita($idCita);
				foreach($recetas as $receta)
				{
					echo "<tr><td>
							<li>";
					echo "<input type='button' value='borrar' onclick='borrarPrescripcion($idCita,$receta->IdReceta)'>";
					echo " <input type='button' value='editar' onclick='editarPrescripcion($receta->IdReceta, \"" . urlencode($receta->Indicaciones) . "\")'>";
					echo "<input type='checkbox' name='prescripciones[]' value='$receta->IdReceta' checked='checked'/>
							</li></td></tr>";
					echo "<tr><td>";
					echo "<input name='idReceta' id='idReceta' type='hidden' value='$receta->IdReceta'>";
					//echo $receta->Medicamento . " - " . $receta->Indicaciones . "";
					echo "<p>$receta->Indicaciones</p>";
					echo "</td></tr>";
				}	
				?>
				</table>
	<center><input type="submit" name="enviar" value="Imprimir" /></center>
	</form>
	</td>
	</tr>
</table>
<?php
}
else if ($seccion == 'examenes')
{
	$estado = "activo";

?>
	EXAMENES A REALIZAR
	<center>
	<form  method="post" name="ingresarExamen" id="ingresarExamen">
	<table width="500" border="0" cellspacing="4">
	<tr>
		<td width="30%" height="72" valign="top"><?php
	$descripciones = TipoEx::listarDescripciones("activo");
	$cantExamenes = 0;
	$contadorDescripciones = 0;
	foreach($descripciones as $descripcion) 
	{
		$contadorDescripciones++;
		?>
		<table border="1" width="248">
			<tr>
				<td style="background-color: #7F9BC5; color:#FFFFFF; font-size:13px; border-color:#000000"><?php echo $descripcion->Descripcion; ?></td>
			</tr>
			<?php
			$examenes = TipoEx::listarPorEstadoDescripcion("activo", $descripcion->Descripcion); 
			foreach($examenes as $examen)
			{
				echo "<tr><td style='font-size:10px;'>";
				echo $examen->Nombre;
				echo "</td>";
				$examenLab = new exLab($idCita, $examen->IdTipo, "");
				echo "<td width='22'><input name='examen' type='checkbox' value='$examen->IdTipo' ";
				if ($examenLab->comprobarExamenGuardado())
				{
					echo "checked='checked'";
				}
				echo "/></td></tr>";
				$cantExamenes++;
			}
			?>
			</table>
			<?php
			if($contadorDescripciones == 3 || $contadorDescripciones == 7)
			{
			?>
		  </td>
			<td width="35%" valign="top">
			<?php
			}
		}
	echo "</td></tr>";
?>
<tr>
<td colspan="3" style="text-align:center;">
<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>" />

<input name="cantExamenes" type="hidden" value="<?php echo $cantExamenes; ?>" />
<input type='button' value='Guardar e Imprimir' onclick="guardarExamen();">
</td>
</tr>
</table>
</form>
<form id="formImprimirExamenes" name="formImprimirExamenes" method="post" action="imprimirExamenes.php" target="_blank">		
	<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">
</form>
</center>
<?php
}
else if ($seccion == 'historial')
{
	$citas = Cita::listarPorEstadoyPaciente(3,$idPaciente);
	$i=0;  
	echo "<object width=\"500px\">
		  <table width=\"100%\">";
	if(count($citas)<1)
	{
		echo "Sin Historial";
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
			echo "\" colspan=\"2\">FECHA CITA:$dia/$mes/$ano <a href='fichaPaciente.php?idCita=$cita->IdCita' onClick='return targetopener(this, false, false, $cita->IdCita)'> Ver </a><a href=\"#\" onclick='eliminarCita($cita->IdCita);'>Eliminar</a></td>
				  </tr>";
			echo "<tr>
					<td valign=\"top\" width=\"25%\">Diagnostico</td>
					<td><div id=\"$cita->IdCita\">";
			if ($cita->DiagnosticoCita=="") echo "No hay diagnostico";
			else echo nl2br($cita->DiagnosticoCita);
			
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
	echo "</table>
	      </object>";
}
else if ($seccion == 'foto')
{
?>
<table style="width:500; border:#FFFFFF">
	<tr>
		<td width="40%" rowspan="2" valign="top" style="border:1px dotted #999999; border-left-color:#FFFFFF; border-top-color:#FFFFFF; border-bottom-color:#FFFFFF">
			<form method="post" action="ingresarFotografia.php" name="ingresarFotografia" id="ingresarFotografia" enctype="multipart/form-data">
			<p><input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">Ingresar fotografía:<br /></p>
			<p><input name='uploadFile' type="file" id="uploadFile" class="inputNormal" style="border:#000000 thin;" /></p>
			<p>Descripción:<br /></p>
			<p><textarea name='descripcion' id="descripcion" cols='5' rows='5'></textarea></p>
			<input type='submit' value='guardar'>
			</form>
		</td>
		<td colspan="2" valign="top"><b><center>Fotografías anteriores:</center></b></td>
	</tr>
	<tr>
	
	<td valign="top">
	<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">
	<ul>
	<?php
		
		$fotos = Foto::obtenerFotosPorIdcita($idCita);
		foreach($fotos as $foto)
		{
			echo "<li>";
			echo "<input type='button' value='borrar' onclick='borrarFotografia($idCita,$foto->IdFoto)'>";
			echo "<ul>";
			echo "<li>";
			echo "<input name='idFoto' id='idFoto' type='hidden' value='$foto->IdFoto'>";
			echo "<a href='$foto->Imagen' target='_blank'><img src='$foto->Miniatura' /></a>" . "<br />" . $foto->Descripcion;
			echo "</li>";
			echo "</ul>";
			echo "</li>";
		}
		echo "</td></tr>";
	
	?>
	</ul></td>

	</tr>
</table>
<?php
}

/*echo "<script type=\"text/javascript\" src=\"tabsDiagnosticoFichaPaciente.js\"></script>\n<div id=\"demoDiag\">
				<div class=\"tabOnDiag\" id=\"diag\" onClick=\"tabDiag();\">Diagnostico</div>
				<div class=\"tabOffDiag\" id=\"foto\" onClick=\"tabDiag();\">Foto</div>
				<div class=\"tabOffDiag\" id=\"pres\" onClick=\"tabDiag();\">Prescripcion</div>
				<div class=\"tabOffDiag\" id=\"exam\" onClick=\"tabDiag();\">Ex. Laboratorio</div>
				<div class=\"tabOffDiag\" id=\"parc\" onClick=\"tabDiag();\">Prueba Parche</div>
				<div id=\"tabContenidoDiag\"></div>
			</div>";*/

/*
echo "<table width=\"533\" border=\"1\" cellspacing=\"0\">
                    <tr>
                      <td bgcolor=\"#0066FF\"><span class=\"Estilo1\">DIAGNOSTICO</span></td>
                      <td bgcolor=\"#99FF33\"><span class=\"Estilo1\">FOTO</span></td>
                      <td bgcolor=\"#CC33CC\"><span class=\"Estilo1\">PRESCRIPCION</span></td>
                      <td bgcolor=\"#FFFF66\"><span class=\"Estilo1\">EXAMEN LABORATORIO </span></td>
                      <td bgcolor=\"#66FFCC\"><span class=\"Estilo1\">PRUEBA PARCHE </span></td>
                    </tr>
                  </table>";


$consulta=$resultado=NULL;
if(isset($secciones[$seccion]))
{
	include 'conexion.php';
	conectar();
	
	$consulta=mysql_query("SELECT {$secciones[$seccion][3]} FROM {$secciones[$seccion][0]} WHERE {$secciones[$seccion][1]}={$secciones[$seccion][2]}") or
	die (mysql_error());
	
	desconectar();
	$resultado=mysql_fetch_array($consulta);
	echo utf8_encode($resultado[0]);
}*/
?>
