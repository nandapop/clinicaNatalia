<?php

if($_POST)
{
	//si id==1 se guarda en la bd, de lo contrario se muestra el formulario de ingreso
	$id=$_POST['id'];
	if($id==1)
	{
		require_once("clases/Alergia.php");
		//variables POST
		$nombreAlergia=$_POST['nombrealergia'];
		$descripcion=$_POST['descripcion'];
		$idAlergia=0;
		$alergia = new Alergia($idAlergia,$nombreAlergia,$descripcion);
		$idAlergia=$alergia->insertar();
		echo "OK";
	}
	else
		echo "No se pudo guardar alergia";
}
else
{?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alergia :: Ingresar</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
<script type="text/javascript" src="scripts/funcionesAlergia.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
</head>
<body>
	<div id="formContenedor">
		<form id="formulario">
			<div id="transparencia">
				<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
			</div>
			<p>INGRESAR NUEVA ALERGIA</p>
			<table align="left">
				<tbody>
				  <tr>
					<th class="label" valign="top" onmouseover="muestraAyuda(event, 'Nombre','')">Nombre Alergia </th>
					<td height="23" valign="top" class="campo">
					  <input name="nombrealergia" id="nombreAlergia" type="text" class="inputNormal" />
					</td>
				  </tr>
				  <tr>
					<th class="label" valign="top" onmouseover="muestraAyuda(event, 'Descripcion','')">Descripcion</th>
					<td class="campo">
						<textarea name="descripcion" id="descripcion" class="inputNormal"></textarea>
					</td>
				  </tr>
				 </tbody>
			</table>
			<div>
				<button id="botonEnviar" type="button" onClick="validaForm()">Enviar</button>
				<button type="reset">Borrar</button>
		  </div>
		</form>
	</div>
	<div id="mensajesAyuda">
		<div id="ayudaTitulo"></div>
		<div id="ayudaTexto"></div>
	</div>
</body>
</html><?php } ?>