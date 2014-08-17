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
	<form id="formulario"  name="formulario" action="buscarFecha.php" method="post">
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
			<th colspan="3"><p style="font-size:16px;">Busqueda de Pacientes por fecha</p></th><th><img alt="Paciente" src="imagenes/paciente.png" /></th>
		</tr>
		<tr style="text-align:center">
			<td class="campo" colspan="3"><input name="dato" type="text" class="inputNormal" size="50" /></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center"><b>Buscar por:</b></td>
		</tr>
		<tr style="text-align:center">
			<td>Rut<input type="radio" name="buscar" value="rut" checked="checked" /></td>
			
		</tr>
		<tr>
			<td colspan="3"><button type="button" onclick="validaBuscar()" style="width:200px;">Buscar</button></td>
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
/*	else if($buscar=="apellido")
	{
		list($nombre, $apellido) = split("-",$dato);
		$pacientes = Paciente::buscarPaciente($nombre,$apellido);
	}
	else if($buscar=="apellidos")
	{
		list($nombre, $apellidop, $apellidom) = split("-",$dato);
		$pacientes = Paciente::buscarPacienteCompleto($nombre,$apellidop, $apellidom);
	}*/

if(count($pacientes)<1)
{
?>
<p><b>Error:</b> Paciente no encontrado.</p>
<p>Para volver a buscar presione <b onclick="location.href='buscarFecha.php'" style="cursor:pointer">aquí</b></p>
<?php
}
else if(count($pacientes)==1)
{
?>
<form name="formulario" id="formulario">
<input type="hidden" name="idPaciente" id="idPaciente" value="<?php echo $pacientes[0]->IdPaciente;?>" />

<table width="420">
	<tr>
		<th colspan="3">ANTECEDENTES PERSONALES</th>
		<td width="35"><img src="imagenes/ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, 'Ayuda','')"></td>
	</tr>
	<?php include_once("clases/Cita.php"); $citas=Cita::listarPorIdPaciente($pacientes[0]->IdPaciente);?>
	<?php if(count($citas) ==0 ) { ?>
	<tr>
		<td colspan="2" align="left"><div id="menudown"><ul><li><a href="#" onclick="eliminarPaciente(<?php echo $pacientes[0]->IdPaciente?>)" title="Eliminar paciente" ><img alt="Eliminar" src="imagenes/eliminarPac.gif" width="25" height="25" /> Eliminar Paciente</a></li></ul></div></td>
	</tr>
	<?php } ?>
    <tr>
		<td width="120" class="label" onmouseover="muestraAyuda(event, 'Run','')">Run</td>
		<td width="248" class="campo"><input class="inputNormal" id="run" name="run" type="text" value="<?php echo $pacientes[0]->Run?>"></td>
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
		<td class="label" onmouseover="muestraAyuda(event, 'Telefono','')">Telefono</td>
		<?php if($pacientes[0]->Telefono!="-") list($codigoc,$numero)=split("-",$pacientes[0]->Telefono); else{ $codigoc=""; $numero=""; }?>
		<td class="campo"><input class="inputNormal" type="text" id="codigoC" name="codigoC" size="2" maxlength="3" value="<?php echo $codigoc;?>"  />-<input class="inputNormal" type="text" id="numeroC" name="numeroC" size="8" maxlength="7" value="<?php echo $numero;?>" /></td>
	</tr>

	<tr>
		<td class="label" onmouseover="muestraAyuda(event, 'Celular','')">Celular</td>
		<?php if($pacientes[0]->Celular!="-") list($codigocel,$numerocel)=split("-",$pacientes[0]->Celular); else { $codigocel=""; $numerocel=""; } ?>
		<td class="campo"><input class="inputNormal" type="text" id="codigoCel" name="codigoCel" size="2" maxlength="2" value="<?php echo $codigocel;?>" />-<input class="inputNormal" type="text" id="numeroCel" name="numeroCel" size="8" maxlength="8" value="<?php echo $numerocel;?>" /></td>
	</tr>
	
	
		
  <tr>
			<td class="label" onmouseover="muestraAyuda(event, 'UltimaVisita','')">Fecha &uacute;ltima visita</td>
					<?php
						$citas = Cita::listarPorEstadoyPaciente(3,$pacientes[0]->IdPaciente);
						if($citas[0]->FechaCita!="0000-00-00 00:00:00")
						{
							list($anoP, $mesP, $resto) = split("-",$citas[0]->FechaCita);
							list($diaP,$l) = split(" ",$resto);
						}
						else
						{
							$anoP="";
							$mesP="";
							$diaP="";
						}
					?>
			<td class="campo">
            <input class="inputNormal" type="text" id="diaPrimeraCita" name="diaPrimeraCita" size="1" maxlength="2"/ value="<?php echo $diaP;?>">/
            <input class="inputNormal" type="text" id="mesPrimeraCita" name="mesPrimeraCita" size="1" maxlength="2"/ value="<?php echo $mesP;?>">/
            <input class="inputNormal" type="text" id="anoPrimeraCita" name="anoPrimeraCita" size="5.1" maxlength="4"/ value="<?php echo $anoP;?>">
            </td>
		</tr>
  <tr>
    <td class="label" onmouseover="muestraAyuda(event, 'ProximaVisita','')">Fecha pr&oacute;xima visita</td>
    <?php
		$citas = Cita::obtenerProximaCitaPorPaciente($pacientes[0]->IdPaciente);
		
		if (count($citas) != 0 && $citas[0]->FechaCita != "0000-00-00 00:00:00" )
		{
			list($anoP, $mesP, $resto) = split("-",$citas[0]->FechaCita);
			list($diaP,$l) = split(" ",$resto);
			$sucursal = $citas[0]->Consulta == 0?"Sucursal 1":"Sucursal 2";

		}
		else
		{
			$anoP="";
			$mesP="";
			$diaP="";
			$sucursal = "";
		
		}	
	?>
    <td class="campo">
		<input class="inputNormal" type="text" id="diaPrimeraCita" name="diaPrimeraCita" size="1" maxlength="2"/ value="<?php echo $diaP;?>">/
        <input class="inputNormal" type="text" id="mesPrimeraCita" name="mesPrimeraCita" size="1" maxlength="2"/ value="<?php echo $mesP;?>">/
        <input class="inputNormal" type="text" id="anoPrimeraCita" name="anoPrimeraCita" size="5.1" maxlength="4"/ value="<?php echo $anoP;?>"> 
        Sucursal:<?php echo $sucursal; ?> </td>
  </tr>
		<tr>
			<td colspan="2">
			  <div id="menudown">
				<ul>
				  <li><a href="javascript:cambiaEstadoUnico('hist', 'ficha')" title="Ver Historial"><img alt="Historial" src="imagenes/historial.png" width="25" height="25" />Historial</a></li>
				  <li><a href="#" onclick="imprimirFicha()" title="Imprimir ficha del paciente"><img alt="Imprimir" src="imagenes/imprimir.png" width="25" height="25" /> Imprimir Ficha</a></li>
				  <li><a href="javascript:location.href='buscarFecha.php'" title="Volver"><img alt="Volver" src="imagenes/volver.gif" width="25" height="25" />Volver</a></li>
				  <li><a href="javascript:window.close()" title="Cancelar"><img alt="Cancelar" src="imagenes/cancel.png" width="25" height="25" /> Cancelar</a></li>
				</ul>
			  </div>			 </td>
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
}
?>
</div>
<div id="mensajesAyuda">
			<div id="ayudaTitulo"></div>
			<div id="ayudaTexto"></div>
		</div>
</body>
</html>
