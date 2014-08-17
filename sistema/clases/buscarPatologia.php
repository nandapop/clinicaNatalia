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
{
	include_once("clases/PatologiaFrecuente.php");
	$patologias = PatologiaFrecuente::listar();
	$hayPatologias = false;
?>
	<form id="formulario"  name="formulario" action="buscarPatologia.php" method="post">
	<script language="JavaScript">
				<!-- 
				function validaBuscar()
				{
					with (document.formulario)
						submit();
				}
				//-->
	</script>
	<center>
	<table id="buscar" style="display:block;">
		<tr>
			<th colspan="3"><p style="font-size:16px;">Busqueda de Pacientes por patolog&iacute;a</p></th><th><img alt="Paciente" src="imagenes/paciente.png" /></th>
		</tr>
		<tr style="text-align:center">
			<td class="campo" colspan="3"><label>Seleccione patolog&iacute;a<select name="idPatologia">
<?php
	foreach($patologias as $patologia)
	{
		$hayPatologias = true;
		?>
			<option value = "<?php echo $patologia->Id; ?>"><?php echo $patologia->Patologia; ?></option>
		<?php
	}
?>
			</select></label></td>
		</tr>
		<tr>
			<?php
			if($hayPatologias)
			{
			?>
				<td colspan="3"><button type="button" onclick="validaBuscar()" style="width:200px;">Buscar</button></td>
			<?php
			}
			else
			{
			?>
				<td colspan="3">No hay patolog&iacute;as ingresadas</td>
			<?php
			}
			?>
		</tr>
	</table>
	</center>
	</form>
<?php
}
else
{
	include_once("clases/PatologiaPaciente.php");
	include_once("clases/Paciente.php");
	$idPatologia=$_POST['idPatologia'];
	$patologiaPacientes = PatologiaPaciente::listarPorIdPatologia($idPatologia);
}
if(count($patologiaPacientes)<1)
{
?>
<p><b>Error:</b> No hay pacientes con esa patolog&iacute;a.</p>
<p>Para volver a buscar presione <b onclick="location.href='buscarPatologia.php'" style="cursor:pointer">aqu&iacute;</b></p>
<?php
}
else
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
	foreach($patologiaPacientes as $patologiaPaciente)
	{
		$pacs = Paciente::obtenerPorId($patologiaPaciente->IdPaciente);
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
