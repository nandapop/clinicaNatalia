<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Cita.php");
include_once("clases/Paciente.php");
// Se quiere validar si hay o no más pacientes
// OK - Significa que no han llegado más pacientes
// NO OK - Significa que hay pacientes sin avisar
if(isset($_POST["accion"]) && ($_POST["accion"] == 1))
{
	$citas = Cita::listarNuevasCitasEsperando();
	$citasTodas = Cita::listarCitasEsperando();
	if(count($citas) == 0 && count($citasTodas) == $_SESSION['contadorCitas'])
	{
		echo "OK";
	}
	else
	{
		echo "NO OK";
	}
}
else if(isset($_POST["accion"]) && ($_POST["accion"] == 2))
{
	$citas = Cita::listarCitasEsperando();
	if(count($citas) == 0)
	{
		echo "OK";
	}
	else
	{
		echo "NO OK";
	}
}
else
{
if(isset($_GET["atencion"]))
{
	$atencionRequerida = $_GET["atencion"];
}
else
{
	//Por defecto entregamos los pacientes de la doctora Paredes.
	$atencionRequerida = 1;
}
$citasTodas = Cita::listarCitasEsperando();
$_SESSION['contadorCitas'] = count($citasTodas);
?>
<html>
<head>
<title>Pacientes esperando</title>
<script type="text/javascript" src="scripts/funcionesPacienteEsperando.js"></script>
<SCRIPT TYPE="text/javascript">
<!--
function targetopener(mylink, closeme, closeonly, idCita)
{
	if (!window.focus)
	{
		return true;
	}
	
	// Siempre en ventana nueva
	window.open(mylink.href, "ventanaabierta", "toolbar=1, location=1, directories=1, status=1, menubar=1, scrollbars=1, resizable=1")
	actualizarCita(idCita);
	
	// Ventana nueva si no hay pero el opener se pierde :S
	/*
	if(!window.opener)
	{
		window.open(mylink.href)
		actualizarCita(idCita);
	}
	else if (!closeonly)
	{
		window.opener.focus();
		window.opener.location.href = mylink.href;
		actualizarCita(idCita);
	}
	*/
	if (closeme)
	{
		window.close();
	}
	return false;
}
//-->
</SCRIPT>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
</head>
<body>
<?php
	$citas = Cita::listarNuevasCitasEsperando();
	if(count($citas) != 0)
	{
?>
		<object width="0" height="0" type="application/x-shockwave-flash" data="sonidos/musicplayer.swf?&autoplay=true&song_url=sonidos/sonido.mp3&"> <param name="movie" value="sonidos/musicplayer.swf?&autoplay=true&song_url=sonidos/sonido.mp3&" /> <img width="0" height="0" src="noflash.gif" />
		</object>
<?php
	}
?>
	<div id="listaEspera">
<?php
	$citas = Cita::listarCitasEsperando();
	echo "<ul>";
	$pacientesListados = 0;
	foreach($citas as $cita)
	{
		//Validamos que la cita sea el doctor a listar
		if($cita->Atencion != $atencionRequerida)
		{
			continue;
		}
		// Listamos el paciente de la cita
		$paciente = Paciente::obtenerPorId($cita->IdPaciente);
		list($resto, $horaLlegada) = split(" ", $cita->HoraLlegada);
		$lugarAtencion = ($cita->TipoCita == 1)?"Consulta":"Pabellón";
		if ($cita->Atencion == 1)
		{
			$doctoraAtencion = "Dra. Paredes";
		}

		if ($cita->Consulta == 0 )
		{
			echo "<li><a href='fichaPaciente.php?idCita=$cita->IdCita' onClick='return targetopener(this, false, false, $cita->IdCita)'>$paciente->NombreCompleto -- $lugarAtencion<br>$doctoraAtencion -- $horaLlegada // $cita->SoloFecha </a></li>";
		}
		else  // Esto se debe modificar si es que no hay otra sucursal.
		{
			echo "<li class=\"vina\"><a href='fichaPaciente.php?idCita=$cita->IdCita' onClick='return targetopener(this, false, false, $cita->IdCita)'>$paciente->NombreCompleto -- $lugarAtencion<br>$doctoraAtencion -- $horaLlegada // $cita->SoloFecha </a></li>";
		}
		// Marcamos la cita como avisada.
		$cita->Estado = 5;
		$cita->modificar();
		$pacientesListados++;
	}
	echo "</ul>";
	if($pacientesListados == 0)
	{
?>
		<h2>No hay pacientes en espera </h2>
<?php
	}
?>
</div>
</body>
</html>
<?php
}
?>