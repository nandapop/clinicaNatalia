<head>
<meta name="description" content="#" />
<meta name="keywords" content="#" />
<meta name="author" content="#" />
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" media="screen" />
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
<?php echo $archivosScripts; ?>
<script type="text/javascript" src="scripts/funcionesPacienteEsperando.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-size: 12px}
-->

</style>
<title>Sistema Clinico Natalia Paredes Salfate</title>
<script type="text/javascript">
function cambiarEstados(liden, iden)
{
	var lihtml = document.getElementById(liden);
	var elhtml = document.getElementById(iden);
	if (elhtml.style.display == 'block')
	{
		lihtml.style.display = 'none';
		elhtml.style.display = 'none';
	}
	else
	{
		elhtml.style.display = 'block';
		lihtml.style.display = 'block';
		lihtml.style.background = 'transparent';
		lihtml.style.border = 'none';
	}
}

function AvisoNoCerrar()
{
 
 	if (!confirm('Esta es la ventana principal, para que el programa funcione correctamente por favor vuelva a abrirla'))
 	{
		window.open("indexValidado.php");
	}
	
}

function alCargar()
{
<?php

if (($_SESSION["autenticado"] == "si") && ($_SESSION["privilegios"] > 2))
{
	echo "msgWindow = false;\n";
	
}
?>	
	<?php echo $onload; ?>
}
</script>
</head>
<body onLoad="alCargar();">
<div id="banner">
  <div class="top_links clearfix" id="topnav">
    <!--<ul>
      <li><a href="http://jigsaw.w3.org/css-validator/validator-uri.html">CSS</a></li>
	  <li><a href="http://validator.w3.org/">XHTML</a></li>
      <li><a href="http://www.oswd.org/">OSWD</a></li>
    </ul>-->
  </div>
  <a href="indexValidado.php" style="border:0"><img src="imagenes/logoDemo3.jpg" width="169" height="116"></a>
  <div class="page_title"><span id="page_title">Dra. Natalia Paredes Salfate </span></div>
</div>
<div class="leftcontent" id="nav"> <img alt="bg image" src="imagenes/left_bg_top.gif" />
  <ul>
  		<?php
		if (($_SESSION["autenticado"] == "si") && ($_SESSION["privilegios"] > 2))
		{?>	
  		<li><a href="javascript:cambiarEstados('lipaciente', 'paciente')"><img alt="paciente" src="imagenes/paciente.png" />&nbsp;&nbsp;&nbsp;Pacientes</a></li>
		<li id="lipaciente" style="display:none">
			<ul id="paciente" style="display:none">
				<li style="background-color:#ffffff"><a href="javascript:abrir_guardarPaciente()">Ingresar</a></li>
				<li style="background-color:#ffffff"><a href="javascript:abrir_buscar()">Buscar Ficha</a></li>
				<li style="background-color:#ffffff"><a href="recetasFrecuentes.php">Recetas Frecuentes</a></li>
                <li style="background-color:#ffffff"><a href="patologiasFrecuentes.php">Patologías</a></li>
                <li style="background-color:#ffffff"><a href="javascript:verificarPacientes(false, 1)">Pacientes Esperando</a></li>
			</ul>
		</li>
		<li><a href="javascript:cambiarEstados('licalendario', 'calendario')"><img alt="calendario" src="imagenes/calendario.gif" />&nbsp;&nbsp;&nbsp;Calendario</a></li>
		<li id="licalendario" style="display:none">
			<ul id="calendario" style="display:none;">
				<li style="background-color:#ffffff"><a href="calendarioHoras.php">Valparaiso</a></li>
			</ul>
		</li>
		<li><a href="javascript:cambiarEstados('liusuarios', 'usuarios')"><img alt="usuario" src="imagenes/usuario.gif" />&nbsp;&nbsp;&nbsp;Usuarios</a></li>
		<li id="liusuarios" style="display:none">	
			<ul id="usuarios" style="display:none">
				<li style="background-color:#ffffff"><a href="ingresarUsuario.php">Ingresar Usuario</a></li>
				<li style="background-color:#ffffff"><a href="listarUsuario.php">Listar Usuarios</a></li>
				<li style="background-color:#ffffff"><a href="indexRespaldo.php">Respaldar BD</a></li>
				<li style="background-color:#ffffff"><a href="cambiarPassRespaldo.php">Cambiar Clave de Respaldo</a></li>
				<li style="background-color:#ffffff"><a href="soporte.php">Soporte</a></li>
			</ul>
		</li>
		<li><a href="salir.php"><img alt="salir" src="imagenes/salir.gif" />&nbsp;&nbsp;&nbsp;Salir</a></li><?php 
		}
		else
		{
		?>
		<li><a href="index.php"><img alt="ingresar" src="imagenes/acceso.gif" />Ingresar</a></li><?php
		}
		?>
      <!--<li><a href="#">Information</a></li>
      <li><a href="#">Contact</a></li>-->
  </ul>
  <div class="left_news">
    <!--<p>&nbsp;</p>
    <p><span class="news_title">News Area?</span><br />
      A little area for some news, links or perhaps a profile?</p>
    <p><span class="news_title">Note About Above Links</span><br />
	The left navigation links above show a small blue box on hover, at least they show up in anything other than IE (of course).</p>
	
	<p>The other browsers show them alright, except that there was a small lag in Opera, but the image showed up fine after that.</p>
	
	<p>It's not a huge deal, but i wanted to note it anyway. </p>-->
  </div>
</div>
<div id="centercontent">