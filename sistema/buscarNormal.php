<?php 
$privilegiosPagina = 1;
include("seguridad.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" />
<script type="text/javascript" src="scripts/funcionesBuscar.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
<script language="JavaScript" src="calendario/calendar1.js"></script>
<script language="JavaScript" src="calendario/calendar2.js"></script>
<script language="JavaScript" src="calendario/calendar3.js"></script>
<title>Buscar :: Paciente</title>
</head>
<body>
<div id="formContenedor">

			<div id="transparencia">
				<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
			</div>
<?php
if(!$_POST)
{?>
	<form id="formulario"  name="formulario" action="buscarNormal.php" method="post">
	<script language="JavaScript">
				<!-- 
				function validaBuscar()
				{
					with (document.formulario)
						if ( dato.value!="")
							submit();
						else
							alert("Ingrese informacion a buscar");
				}
				//-->
	</script>
	<center>
	<table id="buscar" style="display:block;">
		<tr>
			<th colspan="3"><p style="font-size:16px;">Busqueda de Pacientes</p></th><th><img alt="Paciente" src="imagenes/paciente.png" /></th>
		</tr>
        
		<tr style="text-align:center">
			<td class="campo" colspan="3"><input class="inputNormal" type="text" name="dato" size="50" /></td>
			<td></td>
		</tr>
        
		<tr>
			<td colspan="3" style="text-align:center"><b>Buscar por:</b></td>
			<td></td>
		</tr>
        
        <tr>
        <tr style="text-align:center">
			<td>Rut<input type="radio" name="buscar" value="rut" checked="checked" /></td>
			<td>Nombre-Apellido<input type="radio" name="buscar" value="apellido" /></td>
			<td>Nombre-ApellidoP-ApellidoM<input type="radio" name="buscar" value="apellidos" /></td>
			<td></td>
        </tr>
        
		<tr>
			<td colspan="4"><button type="button" onclick="validaBuscar()" style="width:200px;">Buscar</button></td>
		</tr>
        
	</table>
	</center>
	</form>
<?php
}
else
{
	include_once("clases/Paciente.php");
	$buscar=$_POST['buscar'];
	$dato=$_POST['dato'];
	if($buscar=="rut")
	{
		$pacientes = Paciente::buscarPacienteRut($dato);
	}
	else if($buscar=="apellido")
	{
		list($nombre, $apellido) = split("-",$dato);
		$pacientes = Paciente::buscarPaciente($nombre,$apellido);
	}
	else if($buscar=="apellidos")
	{
		list($nombre, $apellidop, $apellidom) = split("-",$dato);
		$pacientes = Paciente::buscarPacienteCompleto($nombre,$apellidop, $apellidom);
	}

if(count($pacientes)<1)
{
?>
<p><b>Error:</b> Paciente no encontrado.</p>
<p>Para volver a buscar presione <b onclick="location.href='buscarNormal.php'" style="cursor:pointer">aquí</b></p>
<?php
}
else if(count($pacientes)==1)
{
?>
<form name="formulario" id="formulario">
<input type="hidden" name="idPaciente" id="idPaciente" value="<?php echo $pacientes[0]->IdPaciente;?>" />

<table>
	<tr>
		<th colspan="3">ANTECEDENTES PERSONALES</th>
		<td><img src="imagenes/ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, 'Ayuda','')"></td>
	</tr>
	<?php include_once("clases/Cita.php"); $citas=Cita::listarPorIdPaciente($pacientes[0]->IdPaciente);?>
	<?php if(count($citas) ==0 ) { ?>
	<tr>
		<td colspan="2" align="left"><div id="menudown"><ul><li><a href="#" onclick="eliminarPaciente(<?php echo $pacientes[0]->IdPaciente?>)" title="Eliminar paciente" ><img alt="Eliminar" src="imagenes/eliminarPac.gif" width="25" height="25" /> Eliminar Paciente</a></li></ul></div></td>
	</tr>
	<?php } ?>
    <tr>
		<td width="110" class="label" onmouseover="muestraAyuda(event, 'Run','')">Run</td>
		<td width="520" class="campo"><input class="inputNormal" id="run" name="run" type="text" value="<?php echo $pacientes[0]->Run?>"></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'Nombre','')">Nombre</td>
		<td class="campo"><input class="inputNormal" type="text" id="nombre" name="nombre" size="30" value="<?php echo $pacientes[0]->Nombre?>" /></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'ApellidoP','')">Apellido Paterno</td>
		<td class="campo"><input class="inputNormal" type="text" id="apellidop" name="apellidop" size="30" value="<?php echo $pacientes[0]->ApellidoP?>"></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'ApellidoM','')">Apellido Materno</td>
		<td class="campo"><input class="inputNormal" type="text" id="apellidom" name="apellidom" size="30" value="<?php echo $pacientes[0]->ApellidoM?>"></td>
	</tr>
	<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'Prevision','')">Prevision</td>
			<td class="campo"><select name="prevision" class="inputNormal" id="prevision">
					<option value="" <?php if($pacientes[0]->Prevision=="") echo "selected=\"selected\""; ?>>Seleccione</option>
					<option value="Banmedica" <?php if($pacientes[0]->Prevision=="Banmedica") echo "selected=\"selected\""; ?>>Banmedica</option>
					<option value="Colmena" <?php if($pacientes[0]->Prevision=="Colmena") echo "selected=\"selected\""; ?>>Colmena</option>	
					<option value="Consalud" <?php if($pacientes[0]->Prevision=="Consalud") echo "selected=\"selected\""; ?>>Consalud</option>
					<option value="Fonasa" <?php if($pacientes[0]->Prevision=="Fonasa") echo "selected=\"selected\""; ?>>Fonasa</option>
					<option value="Cruz Blanca" <?php if($pacientes[0]->Prevision=="Cruz Blanca") echo "selected=\"selected\""; ?>>Cruz Blanca</option>			
					<option value="Masvida" <?php if($pacientes[0]->Prevision=="Masvida") echo "selected=\"selected\""; ?>>Masvida</option>
					<option value="Particular" <?php if($pacientes[0]->Prevision=="Particular") echo "selected=\"selected\""; ?>>Particular</option>
					<option value="Vida tres" <?php if($pacientes[0]->Prevision=="Vida tres") echo "selected=\"selected\""; ?>>Vida tres</option></select>
	  </td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'Telefono','')">Telefono</td>
		<?php if($pacientes[0]->Telefono!="-") list($codigoc,$numero)=split("-",$pacientes[0]->Telefono); else{ $codigoc=""; $numero=""; }?>
		<td class="campo"><input class="inputNormal" type="text" id="codigoC" name="codigoC" size="2" maxlength="3" value="<?php echo $codigoc;?>"  />-<input class="inputNormal" type="text" id="numeroC" name="numeroC" size="8" maxlength="7" value="<?php echo $numero;?>" /></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'Sexo','')">Sexo</td>
		<td class="campo"><select name="sexo" class="inputNormal" id="sexo">
						<option value="" <?php if($pacientes[0]->Sexo=="") echo "selected=\"selected\""; ?> >Seleccione</option>
						<option value="M" <?php if($pacientes[0]->Sexo=="M") echo "selected=\"selected\""; ?>>Masculino</option>
						<option value="F" <?php if($pacientes[0]->Sexo=="F") echo "selected=\"selected\""; ?>>Femenino</option>
						</select></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'Celular','')">Celular</td>
		<?php if($pacientes[0]->Celular!="-") list($codigocel,$numerocel)=split("-",$pacientes[0]->Celular); else { $codigocel=""; $numerocel=""; } ?>
		<td class="campo"><input class="inputNormal" type="text" id="codigoCel" name="codigoCel" size="2" maxlength="2" value="<?php echo $codigocel;?>" />-<input class="inputNormal" type="text" id="numeroCel" name="numeroCel" size="8" maxlength="8" value="<?php echo $numerocel;?>" /></td>
	</tr>
	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'FechaNac','')">Fecha Nacimiento</td>
		<?php if($pacientes[0]->FechaNac!="0000-00-00 00:00:00"){ list($ano, $mes, $resto)=split("-",$pacientes[0]->FechaNac); list($dia,$l)=split(" ",$resto);}else{ $ano="";$mes="";$dia="";}?>
		<td class="campo"><input class="inputNormal" type="text" id="dia" name="dia" size="1" maxlength="2" onChange="calculoEdad()" value="<?php echo $dia;?>" />/<input class="inputNormal" type="text" id="mes" name="mes" size="1" maxlength="2" onChange="calculoEdad()" value="<?php echo $mes?>"/>/<input class="inputNormal" type="text" id="ano" name="ano" size="5.1" maxlength="4" onChange="calculoEdad()" value="<?php echo $ano?>" /></td>
	</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'Edad','')">Edad</td>
			<? 
			function calcularEdad($fecha)
			{
				//fecha actual
				$dia=date(j);
				$mes=date(n);
				$ano=date(Y);
				//fecha de nacimiento
				list($anonaz, $mesnaz, $diax) = split("-",$fecha);
				list($dianaz, $resto) = split(" ",$diax);
				//si el mes es el mismo pero el dia inferior aun no ha cumplido aï¿½os, le quitaremos un aï¿½o al actual
				if (($mesnaz == $mes) && ($dianaz > $dia))
					$ano=($ano-1);
				//si el mes es superior al actual tampoco habra cumplido aï¿½os, por eso le quitamos un aï¿½o al actual
				if ($mesnaz > $mes)
					$ano=($ano-1);
				//ya no habria mas condiciones, ahora simplemente restamos los aï¿½os y mostramos el resultado como su edad
				$edad=($ano-$anonaz);
				return $edad;
			}

			//list($fecha,$resto)=split(" ",$paciente[0]->FechaNac);
			//list($ano,$mes,$dia)= split("-",$fecha);
		//	$edadP = calcularEdad($paciente[0]->FechaNac);
			?>
	<td class="campo">
	<input class="inputNormal" disabled="disabled" class="inputNormal" type="text" id="edad" size="4" value ="<?php if($pacientes[0]->FechaNac!="0000-00-00 00:00:00") echo calcularEdad($pacientes[0]->FechaNac); ?>" /></td>
		</tr>
		<tr>
			<td class="label"  onmouseover="muestraAyuda(event, 'Direccion','')">Direccion</td>
		  <td class="campo"><input class="inputNormal" type="text" id="direccion" name="direccion" size="70" value="<?php echo $pacientes[0]->Direccion;?>"  /></td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'Correo','')">Email</td>
			<td class="campo"><input class="inputNormal" type="text" id="email" name="email" size="50" value="<?php echo $pacientes[0]->Email?>" /></td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'Ocupacion','')">Ocupaci&oacute;n</td>
			<td class="campo"><input class="inputNormal" type="text" id="ocupacion" name="ocupacion" value="<?php echo $pacientes[0]->Ocupacion;?>"/></td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'DerivadoPor','')">Derivado por</td>
			<td class="campo"><input class="inputNormal" type="text" id="derivadopor" name="derivadopor" size="40" value="<?php echo $pacientes[0]->DerivadoPor;?>" /></td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event,'Alergia','')">Alergia</td>
			<td class="campo"><input class="inputNormal" type="text" id="alergia" name="alergia" size="20" value="<?php echo $pacientes[0]->Alergia;?>" /></td>
		</tr>
		<tr>
			<td class="label">Seguro de Salud</td>
			<td class="campo"><select name="seguroSalud" id="seguroSalud" class="inputNormal">
			<option value="0" <?php if($pacientes[0]->SeguroSalud=="0") echo "selected=\"selected\""; ?>>Sin información</option>
			<option value="1" <?php if($pacientes[0]->SeguroSalud=="1") echo "selected=\"selected\""; ?>>Sí</option>
			<option value="2" <?php if($pacientes[0]->SeguroSalud=="2") echo "selected=\"selected\""; ?>>No</option>
		</select></td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'PrimeraConsulta','')">Primera Cita</td>
				<?php
					$citas = Cita::listarPorEstadoyPaciente(3,$pacientes[0]->IdPaciente);
					$idxPrimeraCita = count($citas) - 1;
					if($citas[$idxPrimeraCita]->FechaCita!="0000-00-00 00:00:00")
					{
						list($anoP, $mesP, $resto) = split("-",$citas[$idxPrimeraCita]->FechaCita);
						list($diaP, $horaP) = split(" ",$resto);

						list($diaP,$l) = split(" ",$resto);
						$sucursal = $citas[$idxPrimeraCita]->Consulta == 0?"Valparaíso":"Viña del Mar";
						$idAtencion = $citas[$idxPrimeraCita]->Atencion;
 						

						if ($idAtencion == 1)
	     					{
						$atencion = "Paramédico";
	      					}

						if ($idAtencion == 2)
	     					{
						$atencion = "Dra. Fuentes";
	      					}
						else if ($idAtencion == 4) 
						{
						$atencion = "Dra. Paredes"; 
						}
						else if ($idAtencion == 3) 
						{
						$atencion = "Carol"; 
						}
						
						else if ($idAtencion == 5) 
						{
						$atencion = "Viviana"; 
						}
						else  
						{
						$atencion = "Hanady"; 	 	
						}
					}
						else
					{
						$anoP="";
						$mesP="";
						$diaP="";
						$horaP="";
						$sucursal="";
						$atencion="";
					}
				?>
			<td class="campo"><input class="inputNormal" type="text" id="diaPrimeraCita" name="diaPrimeraCita" size="1" maxlength="2"/ value="<?php echo $diaP;?>">/<input class="inputNormal" type="text" id="mesPrimeraCita" name="mesPrimeraCita" size="1" maxlength="2"/ value="<?php echo $mesP;?>">/<input class="inputNormal" type="text" id="anoPrimeraCita" name="anoPrimeraCita" size="5" maxlength="4"/ value="<?php echo $anoP;?>">

 <?php echo $horaP; ?> Sucursal:<?php echo $sucursal; ?> - Atención: <?php echo $atencion; ?> 

 </td>
		</tr>
		<tr>
			<td class="label" onmouseover="muestraAyuda(event, 'UltimaVisita','')">Fecha &uacute;ltima visita</td>
				<?php
					$citas = Cita::listarPorEstadoyPaciente(3,$pacientes[0]->IdPaciente);

					if($citas[0]->FechaCita!="0000-00-00 00:00:00")
					{
						list($anoP, $mesP, $resto) = split("-",$citas[0]->FechaCita);
						list($diaP, $horaP) = split(" ",$resto);

						list($diaP,$l) = split(" ",$resto);
						$sucursal = $citas[0]->Consulta == 0?"Valparaíso":"Viña del Mar";
						$idAtencion = $citas[0]->Atencion;
 						

						if ($idAtencion == 1)
	     					{
						$atencion = "Paramédico";
	      					}

						if ($idAtencion == 2)
	     					{
						$atencion = "Dra. Fuentes";
	      					}
						else if ($idAtencion == 4) 
						{
						$atencion = "Dra. Paredes"; 
						}
						else if ($idAtencion == 3) 
						{
						$atencion = "Carol"; 
						}
						
						else if ($idAtencion == 5) 
						{
						$atencion = "Viviana"; 
						}
						else  
						{
						$atencion = "Hanady"; 	
						}
					}
					else
					{
						$anoP="";
						$mesP="";
						$diaP="";
						$horaP="";
						$sucursal="";
						$atencion="";
					}
				?>
			<td class="campo">
            <input class="inputNormal" type="text" id="diaUltimaVisita" name="diaUltimaVisita" size="1" maxlength="2"/ value="<?php echo $diaP;?>">/
            <input class="inputNormal" type="text" id="mesUltimaVisita" name="mesUltimaVisita" size="1" maxlength="2"/ value="<?php echo $mesP;?>">/
            <input class="inputNormal" type="text" id="anoUltimaVisita" name="anoUltimaVisita" size="5" maxlength="4"/ value="<?php echo $anoP;?>">
 <?php echo $horaP; ?> Sucursal:<?php echo $sucursal; ?> - Atención: <?php echo $atencion; ?>
            </td>
		</tr>
  <tr>
    <td class="label" onmouseover="muestraAyuda(event, 'ProximaVisita','')">Fecha pr&oacute;xima visita</td>
    <?php
		$citas = Cita::obtenerProximaCitaPorPaciente($pacientes[0]->IdPaciente);
		if (count($citas) != 0 && $citas[0]->FechaCita != "0000-00-00 00:00:00" )
		{
			list($anoP, $mesP, $resto) = split("-",$citas[0]->FechaCita);
			list($diaP, $horaP) = split(" ",$resto);
			$sucursal = $citas[0]->Consulta == 0?"Valparaíso":"Viña del Mar";
			$idAtencion = $citas[0]->Atencion;
 			

			if ($idAtencion == 1)
	     		 {
				$atencion = "Paramédico";
	      		 }

			if ($idAtencion == 2)
	     		 {
				$atencion = "Dra. Fuentes";
	      		 }
			 else if ($idAtencion == 4) 
			 {
				$atencion = "Dra. Paredes"; 
			 }
			 else if ($idAtencion == 3) 
			 {
				$atencion = "Carol"; 
			 }
			 
			 else if ($idAtencion == 5) 
			 {
				$atencion = "Viviana"; 
			 }
			 else  
			 {
				$atencion = "Hanady"; 
  			 }
		} else {
			$anoP="";
			$mesP="";
			$diaP="";
			$horaP="";
			$sucursal="";
			$atencion="";
		}
?>

</div>
</body>
</html>

	
    <td class="campo">
		<input class="inputNormal" type="text" id="diaProximaVisita" name="diaProximaVisita" size="1" maxlength="2"/ value="<?php echo $diaP;?>">/
        <input class="inputNormal" type="text" id="mesProximaVisita" name="mesProximaVisita" size="1" maxlength="2"/ value="<?php echo $mesP;?>">/
        <input class="inputNormal" type="text" id="anoProximaVisita" name="anoProximaVisita" size="5" maxlength="4"/ value="<?php echo $anoP;?>"> 
        <?php echo $horaP; ?> Sucursal:<?php echo $sucursal; ?> - Atención: <?php echo $atencion; ?> </td>
  </tr>
		<tr>
			<td colspan="2">
			  <div id="menudown">
				<ul>
				  <li><a href="#" onclick="guardarCambios(this.form)" title="Guardar Cambios"><img alt="Guardar" src="imagenes/save.png" width="25" height="25" /> Guardar</a></li>
				  <li><a style="" href="javascript:cambiaEstadoUnico('ficha', 'hist')" title="Agregar Cita"><img alt="Agregar" src="imagenes/add.png" width="25" height="25" />Agregar Cita</a></li>
				  <li><a href="javascript:cambiaEstadoUnico('hist', 'ficha')" title="Ver Historial"><img alt="Historial" src="imagenes/historial.png" width="25" height="25" />Historial</a></li>
				  <li><a href="#" onclick="imprimirFicha()" title="Imprimir ficha del paciente"><img alt="Imprimir" src="imagenes/imprimir.png" width="25" height="25" /> Imprimir Ficha</a></li>
				  <li><a href="javascript:location.href='buscar.php'" title="Volver"><img alt="Volver" src="imagenes/volver.gif" width="25" height="25" />Volver</a></li>
				  <li><a href="javascript:window.close()" title="Cancelar"><img alt="Cancelar" src="imagenes/cancel.png" width="25" height="25" /> Cancelar</a></li>
				</ul>
			  </div>
			 </td>
		</tr>
</table>
</form>
	<!-- Historial -->
	<div id="historialDiv">
	<?php 
		echo "<table width=\"100%\" style=\"display:none;\" id=\"hist\">";
		echo "</table>";
	?>
	</div>
	<!-- Nueva Ficha -->
	<div id="nuevaFichaDiv">
	<table id="ficha" style="display:none">
		<tr>
			<td>
			<form name="nuevaFicha" method="post" action="ingresarDiagnostico.php" name="ingresarDiagnostico" id="ingresarDiagnostico">
					Fecha: <input type="Text" name="fecha" id="fecha"><a href="javascript:cal11.popup();"> <img src="imagenes/cal.gif" width="16" height="16" border="0" alt="Escoja fecha"></a><br /><br />
						<input type="hidden" name="idPaciente" value="<?php echo $pacientes[0]->IdPaciente;?>" />
						<p>Diagnostico:</p><textarea name='diagnostico' id="diagnostico" style="width:500; height:200"></textarea>							
						</form>
						<br /><br /><br />
						<table style="border:0px" >
	<tr>
		<td rowspan="2" valign="top" style="border:groove"><p>Ingresar Medicamento</p><br />
		    <form method="post" action="ingresarPrescripcion.php" name="ingresarPrescripcion" id="ingresarPrescripcion">
			<input type="hidden" name="idPaciente" value="<?php echo $pacientes[0]->IdPaciente;?>" />
				<textarea name='indicaciones' id="indicaciones" cols='3' rows='3'></textarea>
				<input type='button' value='Agregar Prescripcion' onclick="guardarPrescripcion();">
		  </form>
	  	</td>
		<td colspan="2" style="border: #FFFFFF 1px;" valign="top">PRESCRIPCIONES</td>
	</tr>
	<tr>
	
	<td valign="top">
	<div id="listadoDiagnosticosViejos">
	<ul>
<?php
if(!isset($_SESSION["pac"]))
{
	$_SESSION["pac"] = serialize(array());
}
$recetas = unserialize($_SESSION["pac"]);
$i = 0;
foreach($recetas as $receta)
{
	echo "<li>";
	echo "<input type='button' value='Borrar' onclick='borrarPrescripcion($i)'>";
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
?>
	</ul>
	</div>
	</td>
	</tr>
	<tr>
	<td><center><input type='button' value='Guardar Historial' onclick="guardarDiagnostico();"></center></td>
	</tr>
</table>
			</td>
		</tr>
	</table>
	</div>
	<script language="JavaScript">
				<!-- // create calendar object(s) just after form tag closed
					 // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
					 // note: you can have as many calendar objects as you need for your application

					var cal11 = new calendar3(document.forms['nuevaFicha'].elements['fecha']);
					cal11.year_scroll = true;
					cal11.time_comp = true;
					
				//-->
				</script>
<?php
}
else if(count($pacientes)>1)
{
//Listado de todos los pacientes
?>
<script language="JavaScript">
				<!-- 
function validar() {
	var marcado = "no";
	with (document.lista){
		for ( var i = 0; i < dato.length; i++ ) {
			if ( dato[i].checked ) {
			marcado="si";
			submit();
			}
		}
		if ( marcado == "no" ){
			window.alert("Seleccione paciente" ) ;
		}
	}
}

function eliminar(){
	var marcado = "no";
	with (document.lista){
		for ( var i = 0; i < dato.length; i++ ) {
			if ( dato[i].checked ) {
				marcado="si";
				if(historial[i].value=="no"){
					eliminarPaciente(idpaciente[i].value);
				}
				else{
					window.alert("No puede eliminar el Paciente ya que posee Historial dentro de la clínica");
				}
			}
		}
		if ( marcado == "no" ){
			window.alert("Seleccione paciente" ) ;
		}
	}
}
				//-->
</script>
<table>
	<tr>
		<td colspan="5">Selecione un paciente <img src="/DermoSalud/imagenes/buscar.gif" alt="Buscar" width="22" height="21" /></td>
	</tr>
	<tr>
		<td colspan="5"> </td>
	</tr>
	<tr>
		<th>#</th>
		<th>Selecci&oacute;n</th>
		<th>Nombre Completo</th>
		<th>Run</th>
		<th>Fecha Nac.</th>
		<th>Prevision</th>
		<th>¿Posee Historial?</th>
	</tr>
	<form name="lista" action="buscarNormal.php" method="post">
	<input type="hidden" name="buscar" value="rut" />
	<?php
	$i=0;
	include_once("clases/Cita.php");
	foreach($pacientes as $pacs)
	{
		?>
		<tr bgcolor="<?php if($i%2==0) {  echo "#C0DCC0"; } else { echo "#A6CAF0"; } ?>" >
			<td><?php echo $i+1; ?></td>
			<td><input type="radio" name="dato" value="<?php echo $pacs->Run;?>" /></td>
			<input type="hidden" name="idpaciente" value="<?php echo $pacs->IdPaciente?>" />
			<td align="left"><?php echo ucfirst(strtolower($pacs->Nombre))." ".ucfirst(strtolower($pacs->ApellidoP))." ".ucfirst(strtolower($pacs->ApellidoM)); ?></td>
			<td><?php echo $pacs->Run;?></td>
			<td><?php $fecha=split(" ",$pacs->FechaNac); echo $fecha[0];?></td>
			<td><?php echo $pacs->Prevision;?></td>
			<?php $citas=Cita::listarPorIdPaciente($pacs->IdPaciente);?>
			<td><?php if(count($citas) !=0 ) { echo "S&iacute;"; echo "<input type=\"hidden\" name=\"historial\" value=\"si\" />";} else { echo "No"; echo "<input type=\"hidden\" name=\"historial\" value=\"no\" />";}?></td>
		</tr>			
		<?php
		$i++;
	}
	?>
	<tr>
		<td colspan="5"><button type="button" onclick="validar()" name="enviar" value="Aceptar">Aceptar</button><button type="button" onclick="eliminar()" name="elimina" value="Eliminar">Eliminar</button><button type="button" onclick="location.href='buscar.php'">Volver</button></td>
	</tr>
	</form>
</table>
<?php
}
}
?>
</div>
		<div id="mensajesAyuda">
			<div id="ayudaTitulo"></div>
			<div id="ayudaTexto"></div>
		</div>
</body>
</html>
