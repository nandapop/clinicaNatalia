<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Cita.php");
include_once("clases/Paciente.php");
$idCita = $_GET["idCita"];
$cita = Cita::obtenerPorId($idCita);
$paciente = Paciente::obtenerPorId($cita->IdPaciente);
$onload = 'tab()';
$archivosScripts = '<script type="text/javascript" src="scripts/funcionesFichaPaciente.js"></script>';
$archivosScripts .= '<script type="text/javascript" src="scripts/tabsFichaPaciente.js"></script>';
include("arriba.php");

function calcularEdad($fecha)
{
	//fecha actual
	$dia=date(j);
	$mes=date(n);
	$ano=date(Y);
	//fecha de nacimiento
	list($anonaz, $mesnaz, $diax) = split("-",$fecha);
	list($dianaz, $resto) = split(" ",$diax);
	//si el mes es el mismo pero el dia inferior aun no ha cumplido años, le quitaremos un año al actual
	if (($mesnaz == $mes) && ($dianaz > $dia))
		$ano=($ano-1);
	//si el mes es superior al actual tampoco habra cumplido años, por eso le quitamos un año al actual
	if ($mesnaz > $mes)
		$ano=($ano-1);
	//ya no habria mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
	$edad=($ano-$anonaz);
	return $edad;
}
?>
<div id="transparencia">
	<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
</div>
<input id="idCita" type="hidden" value="<?php echo "$idCita"; ?>">
<input id="idPaciente" type="hidden" value="<?php echo $cita->IdPaciente; ?>">
<form>
<table cellspacing="0" bordercolor="#CCCCCC" style=" border:0px; ">
  <tr>
  	<td colspan="4"><p style="text-align:center; font-size:24px">SAMED FICHA PACIENTE </p></td>
  </tr>
  <tr>
    <td colspan="4" style="background-color: #7F9BC5; color:#FFFFFF; font-size:20px; border-color:#000000; width:565px;">Antecedentes Personales</td>
  </tr>
  <tr>
  	<td>Rut</td>
	<td><input type="text" name="run" value='<?php echo "$paciente->Run" ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
	<td align="right">Sexo</td>
	<td><select name="sexo" id="sexo" class="inputNormal" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF">
						<option value="" <?php if($paciente->Sexo=="") echo "selected=\"selected\""; ?> >Seleccione</option>
						<option value="M" <?php if($paciente->Sexo=="M") echo "selected=\"selected\""; ?>>Masculino</option>
						<option value="F" <?php if($paciente->Sexo=="F") echo "selected=\"selected\""; ?>>Femenino</option>
						</select></td>
  </tr>
  <tr>
    <td>Nombre</td>
    <td><input name="nombre" type="text" value='<?php echo "$paciente->Nombre"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
	<td style="text-align:right">Apellidos</td>
    <td><input type="text" name="apellidoPM" value='<?php echo "$paciente->ApellidoP, $paciente->ApellidoM"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF"></td>
  </tr>
  <tr>
    <td>Telefono</td>
    <td><input type="text" name="telefono" value="<?php echo $paciente->Telefono; ?>" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF"/></td>
    <td style="text-align:right">Celular</td>
    <td><input type="text" name="celular" value="<?php echo $paciente->Celular; ?>" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF"/></td>
  </tr>
   <tr>
    <td>Direccion</td>
	<td colspan="3"><input name="direccion" type="text" size="60" value='<?php echo "$paciente->Direccion"; ?>'style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Ocupacion</td>
    <td><input name="ocupacion" type="text" value='<?php echo "$paciente->Ocupacion"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="25" /></td>
    <td style="text-align:right">Fecha Nac.</td>
	<td><input name="fechanac" type="text" value='<?php 
		if($paciente->FechaNac=="0000-00-00")
		{
			echo "Sin informacion";
		}
		else
		{
			if ($paciente->FechaNac == "0000-00-00 00:00:00")
				echo " ";
			else
			{		
			list($fecha,$resto)=split(" ",$paciente->FechaNac); 
			list($ano,$mes,$dia)= split("-",$fecha);
			echo "$dia/$mes/$ano, ".calcularEdad($paciente->FechaNac)." años";
			}
		}?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><input name="email" type="text" value='<?php echo "$paciente->Email"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="25"/></td>
    <td style="text-align:right">Derivado por</td>
	<td><input name="derivadopor" type="text" value='<?php echo "$paciente->DerivadoPor"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
  	<td>Prevision</td>
	<td><select name="prevision" id="prevision" class="inputNormal" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF">
					<option value="" <?php if($paciente->Prevision=="") echo "selected=\"selected\""; ?>>Seleccione</option>
					<option value="Banmedica" <?php if($paciente->Prevision=="Banmedica") echo "selected=\"selected\""; ?>>Banmedica</option>
					<option value="Colmena" <?php if($paciente->Prevision=="Colmena") echo "selected=\"selected\""; ?>>Colmena</option>	
					<option value="Consalud" <?php if($paciente->Prevision=="Consalud") echo "selected=\"selected\""; ?>>Consalud</option>
					<option value="Fonasa" <?php if($paciente->Prevision=="Fonasa") echo "selected=\"selected\""; ?>>Fonasa</option>
					<option value="Cruz Blanca" <?php if($paciente->Prevision=="Cruz Blanca") echo "selected=\"selected\""; ?>>Cruz Blanca</option>			
					<option value="Masvida" <?php if($paciente->Prevision=="Masvida") echo "selected=\"selected\""; ?>>Masvida</option>
					<option value="Particular" <?php if($paciente->Prevision=="Particular") echo "selected=\"selected\""; ?>>Particular</option>
					<option value="Vida tres" <?php if($paciente->Prevision=="Vida tres") echo "selected=\"selected\""; ?>>Vida tres</option></select></td>
	<td align="right">Alergia</td>
	<td><input type="text" value="<?php echo $paciente->Alergia;?>" name="alergia" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
   </tr>
   <tr>
    <td align="right">Primera Consulta </td>
    <td><input name="primeracita" type="text" value='<?php 
		if($paciente->FechaPrimeraCita=="0000-00-00 00:00:00")
		{
			//buscamos la primera ficha, i.e., la primera consulta y la guardamos.
			$primeraCita=Cita::buscarPrimeraCita($paciente->IdPaciente);
			$paciente->FechaPrimeraCita=$primeraCita->FechaCita;
			$paciente->modificar();
		}
		list($fecha,$resto)=split(" ",$paciente->FechaPrimeraCita); 
		list($ano,$mes,$dia)= split("-",$fecha); 
		echo "$dia/$mes/$ano"; ?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
	<td align="right">Seguro de Salud</td>
	<td><select name="seguroSalud" id="seguroSalud" class="inputNormal" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF">
			<option value="0" <?php if($paciente->SeguroSalud=="0") echo "selected=\"selected\""; ?>>Sin información</option>
			<option value="1" <?php if($paciente->SeguroSalud=="1") echo "selected=\"selected\""; ?>>Sí</option>
			<option value="2" <?php if($paciente->SeguroSalud=="2") echo "selected=\"selected\""; ?>>No</option>
		</select></td>
  </tr>
   <tr>
    
   </tr>
   <tr>
  	<td colspan="4" align="right"><input type="button" value="actualizar" onclick="actualizarPaciente(this.form);" /> <input type="button" value="imprimir" onclick="imprimirFicha()" /></td>
  </tr>
</table>
</form>
<table>
  <tr>
    <td style="background-color: #7F9BC5; color:#FFFFFF; font-size:20px; width:565px;">Antecedentes Morbidos</td>
  </tr>
  <tr><td>[<a href="javascript:cambiaEstado('mor')" title="Ver">Ver</a>]</td></tr>
  <tr>
  	<td>
		<table id="mor" style="display:none">
		<form name="morbidos">
	<?php 
	include_once("clases/AlergiaPaciente.php");
	include_once("clases/Alergia.php");
	$alergias = Alergia::listarAlergias();
	$alergiaPac = AlergiaPaciente::listarAlergiaPaciente($paciente->IdPaciente);
	?>
	<input type="hidden" name="cantAlergias" value="<?php echo count($alergias); ?>" />
	<input type="hidden" name="idPaciente" value="<?php echo $paciente->IdPaciente; ?>" />
	<?php
	for($i=0;$i<count($alergias);$i++)
	{
		$nombreAlergia = $alergias[$i]->NombreAlergia;
		$idAlergia = $alergias[$i]->IdAlergia;
		$descripcion = $alergias[$i]->Descripcion;
		$esAlergia=0;
		$comentario="";
		for($j=0;$j<count($alergiaPac);$j++)
			if($idAlergia==$alergiaPac[$j]->IdAlergia)
			{
				$esAlergia=1;
				$comentario=$alergiaPac[$j]->Comentario;
			}
		?>
		<tr <?php if ($esAlergia==1) echo "style=\"background-color: #CCFFCC;\"";?>>
			<td valign="top" align="left"><?php echo $nombreAlergia ?></td>
			<td valign="top"><input type="checkbox" value="<?php echo $idAlergia ?>" name="alergia" <?php if ($esAlergia==1) echo "checked=\"checked\"";?> />[<a href="javascript:cambiaEstado('<?php echo $idAlergia ?>')" title="Ingresar Comentario">+</a>]</td>
			<td>
			<table id="<?php echo $idAlergia ?>" style="display:none">
				<tr>
					<td valign="top">Comentario</td>
					<td><textarea name="comentario"><?php echo $comentario;?></textarea></td>
				</tr>
			</table>
			</td>
		</tr>
<?php		
	}
	?>
	<tr><td colspan="3"><input type="button" value="actualizar" onclick="guardarMorbidos(this.form)" /></td></tr>
	</form>
	</table>
	</td>
  </tr>
</table>
<br />
<table>
  <tr>
    <td style="background-color: #7F9BC5; color:#FFFFFF; font-size:20px; width:565px;">Patolog&iacute;as</td>
  </tr>
  <tr><td>[<a href="javascript:cambiaEstado('pat')" title="Ver">Ver</a>]</td></tr>
  <tr>
  	<td>
		<table id="pat" style="display:none">
		<form name="patologias">
	<?php 
	include_once("clases/PatologiaFrecuente.php");
	include_once("clases/PatologiaPaciente.php");
	$patologias = PatologiaFrecuente::listar();
	$patologiaPac = PatologiaPaciente::listarPatologiaPaciente($paciente->IdPaciente);
	?>
	<input type="hidden" name="cantPatologia" value="<?php echo count($patologias); ?>" />
	<input type="hidden" name="idPaciente" value="<?php echo $paciente->IdPaciente; ?>" />
	<?php
	for($i = 0; $i < count($patologias); $i++)
	{
		$nombrePatologia = $patologias[$i]->Patologia;
		$idPatologia = $patologias[$i]->Id;
		$esPatologia = 0;
		
		for($j = 0; $j < count($patologiaPac); $j++)
		{
			if($idPatologia == $patologiaPac[$j]->Id)
			{
				$esPatologia=1;
			}
		}
		?>
		<tr <?php if ($esPatologia==1) echo "style=\"background-color: #CCFFCC;\"";?>>
			<td valign="top" align="left"><?php echo $nombrePatologia ?></td>
			<td valign="top">
            <input type="checkbox" value="<?php echo $idPatologia ?>" name="idPatologia" <?php if ($esPatologia==1) echo "checked=\"checked\"";?> /></td>
			<td>
			
			</td>
		</tr>
<?php		
	}
	?>
	<tr><td colspan="3"><input type="button" value="actualizar" onclick="guardarPatologias(this.form)" /></td></tr>
	</form>
	</table>
	</td>
  </tr>
</table>
<table>
  <tr>
    <td style="background-color: #7F9BC5; color:#FFFFFF; font-size:20px; width:565px;">Historial Medico </td>
  </tr>
</table>
<div class="contenedorAutocompletar"><div id="lista" class="fill"></div></div>
	
			<div id="demo">
				<div class="tabOn" id="diagnostico">Diagnóstico</div>
				<div class="tabOff" id="prescripcion">Prescripción</div>
				<div class="tabOff" id="examenes">Exámenes</div>
				<div class="tabOff" id="historial">Historial</div>
				<div id="tabContenido">
					<form method="post" action="ingresarDiagnostico.php" name="ingresarDiagnostico" id="ingresarDiagnostico">
					<input name="idCita" id="idCita" type="hidden" value="<?php echo $idCita; ?>">
					<textarea name='diagnostico' id="diagnostico" style="width:500; height:200"><?php echo $cita->DiagnosticoCita; ?></textarea>
					<br /><input type='button' value='guardar' onclick="guardarDiagnostico();">
					</form>
				</div>
			</div>
			
<?php
include("abajo.php");
?>
