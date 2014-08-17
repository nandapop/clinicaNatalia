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
<title>Buscar :: Seleccion</title>
</head>
<body>
<div id="formContenedor">
	<div id="transparencia">
		<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
	</div>
	<center>
	<table id="buscar" style="display:block;">
		<tr>
			<th><p style="font-size:16px;"><a href="buscarNormal.php">Busqueda de pacientes</a></p></th><th><img alt="Paciente" src="imagenes/paciente.png" /></th>
		</tr>
		<tr>
			<th><p style="font-size:16px;"><a href="buscarPatologia.php">Busqueda por patolog&iacute;as </a></p></th>
			<th></th>
		</tr>
	</table>
	</center>
</div>
</body>
</html>
