<?php
$privilegiosPagina = 1;
include("seguridad.php");
$anoInicial = '1900';
$anoFinal = '2100';
$funcionTratarFecha = 'document.location = "?dia="+dia+"&mes="+mes+"&ano="+ano;';

function fechaEnLetras($fecha){
		$fecha = arreglafecha($fecha,"YYYY-mm-dd");
		$mes["1"]="Enero";
		$mes["2"]="Febrero";
		$mes["3"]="Marzo";
		$mes["4"]="Abril";
		$mes["5"]="Mayo";
		$mes["6"]="Junio";
		$mes["7"]="Julio";
		$mes["8"]="Agosto";
		$mes["9"]="Septiembre";
		$mes["10"]="Octubre";
		$mes["11"]="Noviembre";
		$mes["12"]="Diciembre";
		
		$dia[1]="Lunes";
		$dia[2]="Martes";
		$dia[3]="Miercoles";
		$dia[4]="Jueves";
		$dia[5]="Viernes";
		$dia[6]="Sabado";
		$dia[0]="Domingo";
	//echo " , ".$fecha." ";	
	$temp  = split("-",$fecha);
	$temp2 = strftime("%w",mktime(0,0,0,$temp[1],$temp[2],$temp[0]));
	//print_r($temp2);		
	$temp3 = $dia[$temp2]." ".$temp[2]." de ".$mes[$temp[1]]." de ".$temp[0];
		
	return $temp3;
}

function arreglafecha($fecha,$format = "")
{	
	$fechain = split("-",$fecha);
	if(!isset($fechain[0]) || !isset($fechain[1]) || !isset($fechain[2]))
		return $fecha;

	if($fecha=="") return false;
	if($format != ""){
		$tmp = split("-",$fecha);
		if($format == "YYYY-mm-dd"){
			if($tmp[0] < 1000){
				$fechaout = $tmp[2]."-".$tmp[1]."-".$tmp[0];	
			}else{
				$fechaout = $fecha;
			}
		}elseif($format == "dd-mm-YYYY"){
			if($tmp[2] < 1000){
				$fechaout = $tmp[2]."-".$tmp[1]."-".$tmp[0];	
			}else{
				$fechaout = $fecha;
			}
		}
	}else{
		//transforma tipo fecha yyyy-mm-dd en dd-mm-yyyy para mostrar en el mail.
		$fechain = split("-",$fecha);
		$fechaout = $fechain[2]."-".$fechain[1]."-".$fechain[0];	
	}
	return $fechaout;
}
?>

<!--Force IE6 into quirks mode with this comment tag-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Calendario Citas</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" />
<script type="text/javascript" src="scripts/funcionesHora.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
<style type="text/css">

body{
	margin: 0;
	padding: 0;
	border: 0;
	overflow: hidden;
	height: 130%;
	max-height: 100%;
}

#framecontent{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 210px; /*Height of frame div*/
	overflow: hidden; /*Disable scrollbars. Set to "scroll" to enable*/
	/*background-color: navy;
	color: white;*/
}


#maincontent{
	position: fixed;
	top: 210px; /*Set top value to HeightOfFrameDiv*/
	left: 0;
	right: 0;
	bottom: 0;
	overflow: auto;
	/*background: #fff;*/
}


* html body{ /*IE6 hack*/
padding: 130px 0 0 0; /*Set value to (HeightOfFrameDiv 0 0 0)*/
}

* html #maincontent{ /*IE6 hack*/
height: 100%; 
width: 100%; 
}

</style>

<script type="text/javascript">
/*** Temporary text filler function. Remove when deploying template. ***/
var gibberish=["This is just some filler text", "Welcome to Dynamic Drive CSS Library", "Demo content nothing to read here"]
function filltext(words){
for (var i=0; i<words; i++)
document.write(gibberish[Math.floor(Math.random()*3)]+" ")
}
</script>
<script>
function tratarFecha(dia,mes,ano){
  <?php echo $funcionTratarFecha?>
}

function busquedaNueva()
{
	buscarRut(formularioID);
}
</script>
<style>
.m1 {
   font-family:MS Sans Serif;
   font-size:7pt
}
a {
   text-decoration:none;
   color:#000000;
}

#mensaje_carga{
width:150px; 
height:90px; 
display : block;
top: -5%;
position: absolute;
border : 1px solid white;
background-color : #CC3300;
text-align : center;
}

</style>
</head>

<body>

<div id="framecontent">
<?php
$fecha = getdate(time());
if(isset($_GET["dia"]))$dia = $_GET["dia"];
else $dia = $fecha['mday'];
if(isset($_GET["mes"]))$mes = $_GET["mes"];
else $mes = $fecha['mon'];
if(isset($_GET["ano"]))$ano = $_GET["ano"];
else $ano = $fecha['year'];
$fecha = mktime(0,0,0,$mes,$dia,$ano);
$fechaInicioMes = mktime(0,0,0,$mes,1,$ano);
$fechaInicioMes = date("w",$fechaInicioMes);
?>
<div id="banner">
  <div class="top_links clearfix" id="topnav">
    <ul>
	  <?php
	  if($_SESSION['privilegios']==3)
	  {?>
	  <li><a href="indexValidado.php" title="Volver"><img src="imagenes/volver.gif" alt="volver" width="48" height="48" />Volver</a></li>
	  <?php
	  }
	  ?>
      <li><a href="javascript:abrir_guardarPaciente()" title="Paciente" onmouseover="window.status='Samed - DermoSalud';return true"><img src="imagenes/paciente.png" alt="paciente" />Paciente</a></li>
	  <li><a href="javascript:abrir_buscar()" onmouseover="window.status='Samed - DermoSalud';return true"><img src="imagenes/buscar.gif" width="48" height="48" />Buscar</a></li>
	  <li><a href="javascript:abrir_imprimirCalendario('imprimirCalendario.php?<?php echo "ano=".$ano."&mes=".$mes."&dia=".$dia; ?>')" title="Imprimir" onmouseover="window.status='Samed - DermoSalud';return true"><img src="imagenes/imprimir.png" />Imprimir</a></li>
      <li><a href="salir.php" onmouseover="window.status='Samed - DermoSalud';return true" title="Salir"><img src="imagenes/salir.gif" width="48" height="48" />Salir</a></li>
    </ul>
  </div>
  <img src="imagenes/logoDemo.jpg" width="169" height="116" />
  <div class="page_title"><span id="page_title">Dra. Natalia Paredes </span><br />
  </div>
</div>
<form>
<table border="0" cellpadding="5" width="135" cellspacing="0" bgcolor="#D4D0C8" id="calendario" style="display:none; position:absolute; top:20px; left:20px;">
		  	<tr>
				<td width="100%">
				<select size="1" name="mes" class="m1" onChange="document.location = '?dia=<?=$dia?>&mes=' + document.forms[0].mes.value + '&ano=<?=$ano?>';">
			<?php
			$meses = Array ('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
			for($i = 1; $i <= 12; $i++){
			  echo '      <option ';
			  if($mes == $i)echo 'selected ';
			  echo 'value="'.$i.'">'.$meses[$i-1]."\n";
			}
			?>
				</select>&nbsp;&nbsp;<select style="width: 52px;" size="1" name="ano" class="m1" onChange="document.location = '?dia=<?=$dia?>&mes=<?=$mes?>&ano=' + document.forms[0].ano.value;">
			<?php
			for ($i = $anoInicial; $i <= $anoFinal; $i++){
			  echo '      <option ';
			  if($ano == $i)echo 'selected ';
			  echo 'value="'.$i.'">'.$i."\n";
			}
			?>
			</select><br>
			<font size="1">&nbsp;</font><table border="0" cellpadding="2" cellspacing="0" width="100%" class="m1" bgcolor="#FFFFFF" height="100%">
			<?php
			$diasSem = Array ('L','M','M','J','V','S','D');
			$ultimoDia = date('t',$fecha);
			$numMes = 0;
			for ($fila = 0; $fila < 7; $fila++){
			  echo "      <tr>\n";
			  for ($coln = 0; $coln < 7; $coln++){
				$posicion = Array (1,2,3,4,5,6,0);
				echo '        <td width="14%" height="19"';
				if($fila == 0)echo ' bgcolor="#808080"';
				if($dia-1 == $numMes)echo ' bgcolor="#0A246A"';
				echo " align=\"center\">\n";
				echo '        ';
				if($fila == 0)echo '<font color="#D4D0C8">'.$diasSem[$coln];
				elseif(($numMes && $numMes < $ultimoDia) || (!$numMes && $posicion[$coln] == $fechaInicioMes)){
				  echo '<a href="#" onclick="tratarFecha('.(++$numMes).','.$mes.','.$ano.')">';
				  if($dia == $numMes)echo '<font color="#FFFFFF">';
				  echo ($numMes).'</a>';
				}
				echo "</td>\n";
			  }
			  echo "      </tr>\n";
			}
			?>
			</table>
			</td>
		  </tr>
  </table>
</form>
<div id="container">
<!-- Mensaje de carga -->
	<div id="mensaje_carga">	
		<img src="ico_reloj.gif"><br>
		<p><h3 style="color:#FFFFFF">Cargando... <br>Espere, por favor</h3></p>
	</div>
<!--Fin mensaje de carga-->
	<div id="transparencia">
		<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
	</div>
	<p align="center"><strong>CALENDARIO DE CITAS VALPARAISO</strong></p>
	<div>
		<a style="background-color:#FFFFFF; color:#FFFFFF" href="javascript:cambiaEstado('calendario')"><img src="imagenes/cal.gif" title="Ver Calendario" alt="Calendario"/></a>
	</div>
<?php

$diaSig=$dia+1;
$diaAnt=$dia-1;
$mesSig=$mes;
$mesAnt=$mes;
$anoSig=$ano;
$anoAnt=$ano;
if($mes==4 || $mes==6 || $mes==9 || $mes==11)
{
	if($dia==30)
	{
		$diaSig=1;
		$mesSig=$mes+1;
		$diaAnt=29;
		$mesAnt=$mes;
	}
	elseif($dia==1)
	{
		$diaSig=$dia+1;
		$mesSig=$mes;
		$diaAnt=31;
		$mesAnt=$mes-1;
	}
	$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
	$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
	//Solo con datos del dia anterior
	if($anterior==0) //Domingo
		$diaAnt = $diaAnt - 2;
				
	if($siguiente==6) //Sabado
		$diaSig = $diaSig + 2;
		
	if($diaSig>30)
	{
		$diaSig = $diaSig-30;
		$mesSig = $mes + 1;
	}
	if($diaAnt<0)
	{
		$diaAnt = $diaAnt + 31;
		$mesAnt = $mes - 1;
	}
}
elseif($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12)
{
	if($dia==31)
	{
		if($mes==12)
		{
			$diaSig=1;
			$mesSig=1;
			$anoSig=$ano+1;
		}
		else
		{
			$diaSig=1;
			$mesSig=$mes+1;
			$diaAnt=30;
			$mesAnt=$mes;
		}
		$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
		$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
		//Solo con datos del dia anterior
		if($anterior==0) //Domingo
			$diaAnt = $diaAnt - 2;
					
		if($siguiente==6) //Sabado
			$diaSig = $diaSig + 2;
		
		if($diaSig>31)
		{
			$diaSig = $diaSig-31;
			$mesSig = $mes+1;
		}
		
		if($diaAnt<=0)
		{
			$diaAnt = $diaAnt + 30;
			$mesAnt = $mes - 1;
		}		
	}
	elseif($dia==1)
	{
		$diaSig=$dia+1;
		$mesSig=$mes;
		if($mes==3)
		{
			if(($ano%4)==0)
				$diaAnt=29;
			else
				$diaAnt=28;
			
			$mesAnt = $mes - 1;
		}
		elseif($mes==1)
		{
			$diaAnt=31;
			$mesAnt=12;
			$anoAnt=$ano-1;
		}	
		elseif($mes==8)
		{
			$diaAnt=31;
			$mesAnt=$mes-1;
		}
		else
		{
			$diaAnt=30;
			$mesAnt=$mes-1;
		}
		$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
		$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
		//Solo con datos del dia anterior
		if($anterior==0) //Domingo
			$diaAnt = $diaAnt - 2;
					
		if($siguiente==6) //Sabado
			$diaSig = $diaSig + 2;
		
		if($diaAnt<=0 && $mes==3)
		{
			if(($ano%4)==0)
				$diaAnt = $diaAnt + 29;
			else
				$diaAnt = $diaAnt + 28;
		}
		elseif($diaAnt<=0)
		{
			$diaAnt = $diaAnt + 30;
			$mesAnt = $mes - 1;
		}
	}
	else
	{
		$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
		$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
		//Solo con datos del dia anterior
		if($anterior==0) //Domingo
			$diaAnt = $diaAnt - 2;
					
		if($siguiente==6) //Sabado
			$diaSig = $diaSig + 2;
		
		if($diaSig>31)
		{
			$diaSig = $diaSig -31;
			$mesSig = $mes + 1;
		}
		
		if($diaAnt<=0 && $mes==3)
		{
			if(($ano%4)==0)
				$diaAnt = $diaAnt + 29;
			else
				$diaAnt = $diaAnt + 28;
			
			$mesAnt = $mes - 1;
		}
		elseif($diaAnt<=0)
		{
			$diaAnt = $diaAnt + 30;
			$mesAnt = $mes - 1;
		}
	}
}
elseif(($ano%4)==0) //bisiesto
{
	if($mes==2 && $dia==28)
	{
		$diaSig=$dia+1;
		$mesSig=$mes;
		$diaAnt=$dia-1;
		$mesAnt=$mes;
	}
	elseif($mes==2 && $dia==29)
	{
		$diaSig=1;
		$mesSig=$mes+1;
		$diaAnt=$dia-1;
		$mesAnt=$mes;
	}
	$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
	$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
	//Solo con datos del dia anterior
	if($anterior==0) //Domingo
		$diaAnt = $diaAnt - 2;
				
	if($siguiente==6) //Sabado
		$diaSig = $diaSig + 2;
	
	if($diaSig>29)
	{
		$diaSig = $diaSig - 29;
		$mesSig = $mes + 1;
	}
	
	if($diaAnt<=0)
	{
		$diaAnt = $diaAnt + 29;
		$mesAnt = $mes - 1;
	}
}
else//No bisiesto
{
	if($mes==2 && $dia==28) 
	{
		$diaSig=1;
		$mesSig=$mes+1;
		$diaAnt=$dia-1;
		$mesAnt=$mes;
	}
	$anterior =  date("w",mktime(0,0,0,$mesAnt,$diaAnt,$anoAnt));
	$siguiente = date("w",mktime(0,0,0,$mesSig,$diaSig,$anoSig));
	//Solo con datos del dia anterior
	if($anterior==0) //Domingo
		$diaAnt = $diaAnt - 2;
				
	if($siguiente==6) //Sabado
		$diaSig = $diaSig + 2;
	
	if($diaSig>28)
	{
		$diaSig = $diaSig - 28;
		$mesSig = $mes + 1;
	}
	
	if($diaAnt<=0)
	{
		$diaAnt = $diaAnt + 28;
		$mesAnt = $mes - 1;
	}
}
?>
<table>
	<tr>
		<td width="70"><a href="#" onclick="tratarFecha('<?php echo $diaAnt;?>','<?php echo $mesAnt;?>','<?php echo $anoAnt?>')">&laquo;Anterior</a>&nbsp;&nbsp;|</td>
		<td><?php echo fechaEnLetras($ano."-".$mes."-".$dia);?></td>
		<td width="70">|&nbsp;&nbsp;<a href="#" onclick="tratarFecha('<?php echo $diaSig;?>','<?php echo $mesSig;?>','<?php echo $anoSig?>')">Siguiente&raquo;</a></td>
	</tr>
</table><table border="1">
  <tr>
    <th height="23" scope="col" width="35">Hora</th>
	<th scope="col" width="45">Ver</th>
    <th scope="col" width="85">Rut</th>
    <th scope="col" width="128">Nombre</th>
	<th scope="col" width="148">Apellidos</th>
	<th scope="col" width="108">Telefono</th>
    <th scope="col" width="100">Prevision</th>
	<th scope="col" width="78">Confirmacion</th>
    <th scope="col" width="90">Procedimiento </th>
    <th scope="col" width="65">Pagado</th>
    <th scope="col" width="20">Aviso</th>
	<th scope="col" width="35">Accion</th>
  </tr>
  <!--aqui -->
  </table>

</div>


<div id="maincontent">
 <?php 
  //aca van las consultas y busqueda de datos
  include_once("clases/Cita.php");
  include_once("clases/Paciente.php");
  $hora=8;
  $minutos=0;
  
  $fechaInicio = $ano."-".$mes."-".$dia." 00:00:00";
  $fechaFin = $ano."-".$mes."-".$dia." 23:59:59";	
  $citasTotal = Cita::listarRangoFecha($fechaInicio, $fechaFin, 0); 
 	
  
  for($i=0;$i<73;$i++)
  {
  	if(($i%6)==0)
	{
		$minutos=0;
		$hora++;
	}
	$fechaHora = $ano."-".$mes."-".$dia." ".$hora.":".$minutos."0:00";
	//$citas = Cita::listarPorFecha($fechaHora);
	$citas = array();
	$fechaCita = $citasTotal[0]->FechaCita;
	while (count($citasTotal) != 0 && strtotime($fechaCita, 8640000) <= strtotime($fechaHora, 8640000))
	{
		$citas[] = array_shift($citasTotal);
		$fechaCita = $citasTotal[0]->FechaCita;
	}	
	
	$cantCitas = count($citas);
	
  ?>
  <table width="1030"  border="1">
  <tr>
  	<td colspan="10" style="border: 0px;"></td>
  </tr>
  	<?php
	if($cantCitas==0)
	{?>
  <tr>
	<th height="23" scope="row" style="background-color:#f6f5e0"><?php echo ($hora < 10?0 . $hora:$hora) .":".$minutos."0";?></th>
	<form>
    <input type="hidden" name="atencion" value="1" />
	<input type="hidden" name="idPac" value="" />
	<input class="inputNormal" type="hidden" name="fechaHora" value="<?php echo $fechaHora; ?>"/>
	<td><div>&nbsp;<button type="button" name="ver" onclick="" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">Ver</div></button></div></td>
    <td><div><input class="inputNormal" type="text" name="rut" value="" onchange="buscarRut(this.form)" size="10" /></div></td>
    <td><div><input class="inputNormal" type="text" name="nombre" value="" disabled="disabled" size="15" /></div></td>
	<td><div><input class="inputNormal" type="text" name="apellidop" value="" disabled="disabled" size="18" /></div></td>
    <td><div><input class="inputNormal" type="text" name="telefono" value="" disabled="disabled" size="12" /></div></td>
	<td><div><select class="inputNormal" name="prevision" disabled="disabled">
				<option value="" selected="selected">Seleccione</option>
				<option value="Banmedica">Banmedica</option>
				<option value="Colmena">Colmena</option>	
				<option value="Consalud">Consalud</option>
				<option value="Fonasa">Fonasa</option>
				<option value="Cruz Blanca">Cruz Blanca</option>			
				<option value="Masvida">Masvida</option>
				<option value="Particular">Particular</option>
				<option value="Vida tres">Vida tres</option></select></div></td>				
    <td><div>&nbsp;<button type="button" name="ok" onclick="" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">OK</div></button> <button type="button" name="nc" onclick="" style="border: 1px solid; color:#FF0000; width:35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">NC</div></button></div></td>
    <td><div><select class="inputNormal" name="box" disabled="disabled">
				<option value="" selected="selected">Seleccione</option>
				<option value="1">Consulta</option>
                <option value="2">Nitrógeno</option>
                <option value="3">Curación</option>
                <option value="4">Pabellón</option>
                <option value="5">Retiro de puntos</option>
			</select></div></td>
   
    <td><div><input class="inputNormal" type="text" name="pagado" value="" disabled="disabled" size="7" /></div></td>
	<td><div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="" disabled="disabled"><img src="imagenes/espera_no.png" alt="En Espera" width="16" height="16" /></button></div></td>
	<td><div style="width:100"><button type="button" name="aceptar" style="background-color:#FFFFFF; color:#FFFFFF; width:22px; height:16; border:none;" onclick="guardarCita(this.form,0)" disabled="disabled"><img src="imagenes/aceptar.png" alt="Aceptar" width="16" height="16" /></button><button type="button" name="cancelar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" title="Cancelar" disabled="disabled"><img src="imagenes/cancelar.gif" alt="Cancelar" width="16" height="18" /></button></div></td>
	</form>
  </tr>
	<?php //fin count=0
	}
	else
	{
		if($cantCitas==1)
		{ 
			$paciente = Paciente::obtenerPorId($citas[0]->IdPaciente);?>
		<tr>
		<th height="23" scope="row" rowspan="2" style="background-color:#79b6e5"><?php echo ($hora < 10?0 . $hora:$hora).":".$minutos."0";?></th>
	   <form>
		<input type="hidden" name="idPac" value="" />
		<input class="inputNormal" type="hidden" name="fechaHora" value="<?php echo $fechaHora; ?>"/>

	<td><div>&nbsp;<button type="button" name="ver" onclick="" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">Ver</div></button></div></td>
		<input type="hidden" name="idPac" value="" />
		<td><div><input class="inputNormal" type="text" name="rut" value="" onchange="buscarRut(this.form)" size="10" /></div></td>
		<td><div><input class="inputNormal" type="text" name="nombre" value=""  disabled="disabled" size="15" /></div></td>
		<td><div><input class="inputNormal" type="text" name="apellidop" value="" disabled="disabled" size="18" /></div></td>
		<td><div><input class="inputNormal" type="text" name="telefono" value="" disabled="disabled" size="12" /></div></td>
		<td><div><select class="inputNormal" name="prevision" disabled="disabled">
					<option value="" selected="selected">Seleccione</option>
					<option value="Banmedica">Banmedica</option>
					<option value="Colmena">Colmena</option>	
					<option value="Consalud">Consalud</option>
					<option value="Fonasa">Fonasa</option>
					<option value="Ing">ING</option>			
					<option value="Masvida">Masvida</option>
					<option value="Particular">Particular</option>
					<option value="Vida tres">Vida tres</option></select></div></td>				
		<td><div>&nbsp;<button type="button" name="ok" onclick="" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">OK</div></button> <button type="button" name="nc" onclick="" style="border: 1px solid; color:#FF0000; width:35px; text-decoration:underline; height:18px; text-align:center" disabled="disabled"><div style="text-decoration:underline">NC</div></button></div></td>
		<td><div><select class="inputNormal" name="box" disabled="disabled">
					<option value="" selected="selected">Seleccione</option>
				<option value="1">Consulta</option>
                <option value="2">Nitrógeno</option>
                <option value="3">Curación</option>
                <option value="4">Pabellón</option>
                <option value="5">Retiro de puntos</option>
				</select></div></td>
		
		<td><div><input class="inputNormal" type="text" name="pagado" value="" onblur="" disabled="disabled" size="7" /></div></td>
		<td><div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="" disabled="disabled"><img src="imagenes/espera_no.png" alt="En Espera" width="16" height="16" /></button></div></td>
		<td><div style="width:100"><button type="button" name="aceptar" style="background-color:#FFFFFF; color:#FFFFFF; width:22px; height:16; border:none;" onclick="guardarCita(this.form,0)" disabled="disabled"><img src="imagenes/aceptar.png" alt="Aceptar" width="16" height="16" /></button><button type="button" name="cancelar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" title="Cancelar" disabled="disabled"><img src="imagenes/cancelar.gif" alt="Cancelar" width="16" height="18" /></button></div></td>
		</form>
	   </tr>
		<tr>
		<form>
		<input type="hidden" name="idPac" value="<?php echo $citas[0]->IdPaciente; ?>" />
	<td><div>&nbsp;<button type="button" name="ver" onclick="window.open('fichaPaciente.php?idCita=<?php echo $citas[0]->IdCita; ?>', 'newWindow');" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center"><div style="text-decoration:underline">Ver</div></button></div></td>

		<input class="inputNormal" type="hidden" name="idCita" value="<?php echo $citas[0]->IdCita; ?>" />
		<input class="inputNormal" type="hidden" name="fechaHora" value="<?php echo $fechaHora; ?>"/>
		<td><div><input class="inputNormal" type="text" name="rut" value="<?php echo $paciente->Run; ?>" readonly="true" size="10" /></div></td>
		<td><div><input class="inputNormal" type="text" name="nombre" value="<?php echo $paciente->Nombre; ?>" disabled="disabled" size="15" /></div></td>
		<td><div><input class="inputNormal" type="text" name="apellidop" value="<?php echo $paciente->ApellidoP." ".$paciente->ApellidoM;?>" onchange="" disabled="disabled" size="18" /></div></td>
		<td><div><input class="inputNormal" type="text" name="telefono" value="<?php echo $paciente->Telefono;?>" onblur="cargaD(this.form)" disabled="disabled" size="12" /></div></td>
		<td><div><select class="inputNormal" name="prevision" <?php if($paciente->Prevision!="") echo "disabled=\"disabled\"";?>>
					<option value="" <?php if($paciente->Prevision=="") echo "selected=\"selected\""; ?>>Seleccione</option>
					<option value="Banmedica" <?php if($paciente->Prevision=="Banmedica")echo "selected=\"selected \"";?>>Banmedica</option>
					<option value="Colmena" <?php if($paciente->Prevision=="Colmena")echo "selected=\"selected \"";?>>Colmena</option>	
					<option value="Consalud" <?php if($paciente->Prevision=="Consalud")echo "selected=\"selected \"";?>>Consalud</option>
					<option value="Fonasa" <?php if($paciente->Prevision=="Fonasa") echo "selected=\"selected \"";?>>Fonasa</option>
					<option value="Ing" <?php if($paciente->Prevision=="Ing") echo "selected=\"selected \"";?>>ING</option>			
					<option value="Masvida" <?php if($paciente->Prevision=="Masvida") echo "selected=\"selected \"";?>>Masvida</option>
					<option value="Particular" <?php if($paciente->Prevision=="Particular") echo "selected=\"selected \"";?>>Particular</option>
					<option value="Vida tres" <?php if($paciente->Prevision=="Vida tres") echo "selected=\"selected \"";?>>Vida tres</option>
					</select></div></td>				
		<td><?php 
		if ($citas[0]->Estado==0)
		{?>
		<div>&nbsp;<button type="button" name="ok" onclick="confirmarHora(this.form,1)" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center"><div style="text-decoration:underline">OK</div></button> <button type="button" name="nc" onclick="confirmarHora(this.form,4)" style="border: 1px solid; color:#FF0000; width:35px; text-decoration:underline; height:18px; text-align:center"><div style="text-decoration:underline">NC</div></button></div>
		<?php 
		}
		else
			if($citas[0]->Estado==1 || $citas[0]->Estado==2 || $citas[0]->Estado==5 || $citas[0]->Estado==3)
			{?>
			<div style="color:#336600; text-align:center">Confirmado</div>
			<?php
			}
			else
			{ //falta agregar cuando esta atendido ?>
			<div style="color:#FF0000; font-size:10px">NC</div><button type="button" name="cambiar" onclick="confirmarHora(this.form,1)" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline;"><div style="text-decoration:underline; font-size:10px">OK</div></button>
			<?php
			}
		?></td>
		<td><div><select class="inputNormal" name="box" disabled="disabled">
					<option value="" <?php if($citas[0]->tipoCita==0) echo "selected=\"selected\"";?>>Seleccione</option>
					
					<option value="1" <?php if($citas[0]->tipoCita==1) echo "selected=\"selected \"";?>>Consulta</option>
                <option value="2" <?php if($citas[0]->tipoCita==2) echo "selected=\"selected \"";?>>Nitrógeno</option>   
                 <option value="3" <?php if($citas[0]->tipoCita==3) echo "selected=\"selected \"";?>>Curación</option> 
                  <option value="4" <?php if($citas[0]->tipoCita==4) echo "selected=\"selected \"";?>>Pabellón</option> 
                  <option value="5" <?php if($citas[0]->tipoCita==5) echo "selected=\"selected \"";?>>Retiro de puntos</option> 
              
				</select></div></td>
		
		<td><div><input class="inputNormal" type="text" name="pagado" value="<?php echo $citas[0]->Pagado;?>" onchange="actualizarCita(this.form)" disabled="disabled"  size="7" /></div></td>
		<td><?php
		if($citas[0]->Estado!=2 && $citas[0]->Estado!=5 && $citas[0]->Estado!=3)
		{?>
		<div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="confirmarHora(this.form,2)"><img src="imagenes/espera.png" alt="En Espera" width="16" height="16" /></button></div>
		<?php
		}
		else
		{?>
		<div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="" disabled="disabled"><img src="imagenes/espera_no.png" alt="En Espera" width="16" height="16" /></button></div>
		<?php
		}
		?></td>
		<td><button type="button" name="editar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" onclick="editarForm(this.form)"><img src="imagenes/editar.png" alt="Editar" width="16" height="16" /></button><button type="button" name="cancelar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" title="Cancelar" onclick="eliminarCita(this.form)"><img src="imagenes/cancelar.gif" alt="Cancelar" width="16" height="18" /></button></div></td>
		</form>
	   </tr>
	<?php //fin count=1
		}
		else
		{?>
			<tr>
			<th height="23" scope="row" rowspan="2" style="background-color:#b7d7ae"><?php echo ($hora < 10?0 . $hora:$hora).":".$minutos."0";?></th><?php
			for($j=0;$j<$cantCitas;$j++)
			{
				$paciente = Paciente::obtenerPorId($citas[$j]->IdPaciente);
		?>
				<form>
				<input type="hidden" name="idPac" value="<?php echo $citas[$j]->IdPaciente; ?>" />
				<input type="hidden" name="idCita" value="<?php echo $citas[$j]->IdCita; ?>" />
				<input class="inputNormal" type="hidden" name="fechaHora" value="<?php echo $fechaHora; ?>"/>

				<td><div><input class="inputNormal" type="text" name="rut" value="<?php echo $paciente->Run; ?>" readonly="true" size="10" /></div></td>
				<td><div><input class="inputNormal" type="text" name="nombre" value="<?php echo $paciente->Nombre; ?>" onblur="cargaD(this.form)" disabled="disabled" size="15" /></div></td>
				<td><div><input class="inputNormal" type="text" name="apellidop" value="<?php echo $paciente->ApellidoP." ".$paciente->ApellidoM;?>" onchange="" disabled="disabled" size="18" /></div></td>
				<td><div><input class="inputNormal" type="text" name="telefono" value="<?php echo $paciente->Telefono;?>" onblur="cargaD(this.form)" disabled="disabled" size="12" /></div></td>
				<td><div><select class="inputNormal" name="prevision" disabled="disabled">
							<option value="" <?php if($paciente->Prevision=="") echo "selected=\"selected\""; ?>>Seleccione</option>
							<option value="Banmedica" <?php if($paciente->Prevision=="Banmedica")echo "selected=\"selected \"";?>>Banmedica</option>
							<option value="Colmena" <?php if($paciente->Prevision=="Colmena")echo "selected=\"selected \"";?>>Colmena</option>	
							<option value="Consalud" <?php if($paciente->Prevision=="Consalud")echo "selected=\"selected \"";?>>Consalud</option>
							<option value="Fonasa" <?php if($paciente->Prevision=="Fonasa") echo "selected=\"selected \"";?>>Fonasa</option>
							<option value="Ing" <?php if($paciente->Prevision=="Ing") echo "selected=\"selected \"";?>>ING</option>			
							<option value="Masvida" <?php if($paciente->Prevision=="Masvida") echo "selected=\"selected \"";?>>Masvida</option>
							<option value="Particular" <?php if($paciente->Prevision=="Particular") echo "selected=\"selected \"";?>>Particular</option>
							<option value="Vida tres" <?php if($paciente->Prevision=="Vida tres") echo "selected=\"selected \"";?>>Vida tres</option>
							</select></div></td>				
				<td><?php 
		if ($citas[$j]->Estado==0)
		{?>
		<div>&nbsp;<button type="button" name="ok" onclick="confirmarHora(this.form,1)" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline; height:18px; text-align:center"><div style="text-decoration:underline">OK</div></button> <button type="button" name="nc" onclick="confirmarHora(this.form,4)" style="border: 1px solid; color:#FF0000; width:35px; text-decoration:underline; height:18px; text-align:center"><div style="text-decoration:underline">NC</div></button></div>
		<?php 
		}
		else
			if($citas[$j]->Estado==1 || $citas[$j]->Estado==2 || $citas[$j]->Estado==5 || $citas[$j]->Estado==3)
			{?>
			<div style="color:#336600; text-align:center">Confirmado</div>
			<?php
			}
			else
			{ //falta agregar cuando esta atendido ?>
			<div style="color:#FF0000; font-size:10px">N/C</div><button type="button" name="cambiar" onclick="confirmarHora(this.form,1)" style="border: 1px solid; color: #339900; width: 35px; text-decoration:underline;"><div style="text-decoration:underline; font-size:10px">OK</div></button>
			<?php
			}
		?></td>
				<td><div><select class="inputNormal" name="box" disabled="disabled">
							<option value="" <?php if($citas[$j]->tipoCita==0) echo "selected=\"selected\"";?>>Seleccione</option>
							
							<option value="1" <?php if($citas[0]->tipoCita==1) echo "selected=\"selected \"";?>>Consulta</option>
                <option value="2" <?php if($citas[0]->tipoCita==2) echo "selected=\"selected \"";?>>Nitrógeno</option>   
                 <option value="3" <?php if($citas[0]->tipoCita==3) echo "selected=\"selected \"";?>>Curación</option> 
                  <option value="4" <?php if($citas[0]->tipoCita==4) echo "selected=\"selected \"";?>>Pabellón</option> 
                  <option value="5" <?php if($citas[0]->tipoCita==5) echo "selected=\"selected \"";?>>Retiro de puntos</option> 
                            
                            
                            
                         </div></td>
				
				<td><div><input class="inputNormal" type="text" name="pagado" value="<?php echo $citas[$j]->Pagado;?>" size="7"  disabled="disabled" onchange="actualizarCita(this.form)"/></div></td>
				<td><?php
		if($citas[$j]->Estado!=2 && $citas[$j]->Estado!=5 && $citas[$j]->Estado!=3)
		{?>
		<div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="confirmarHora(this.form,2)"><img src="imagenes/espera.png" alt="En Espera" width="16" height="16" /></button></div>
		<?php
		}
		else
		{?>
		<div style="text-align:center"><button type="button" name="espera" style="background-color:#FFFFFF; color:#FFFFFF; border:none; width:18px; height:18px;" onclick="" disabled="disabled"><img src="imagenes/espera_no.png" alt="En Espera" width="16" height="16" /></button></div>
		<?php
		}
		?></td>
				<td><button type="button" name="editar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" onclick="editarForm(this.form)"><img src="imagenes/editar.png" alt="Editar" width="16" height="16" /></button><button type="button" name="cancelar" style="width:22px; height:16; border:none; background-color:#FFFFFF; color:#FFFFFF" title="Cancelar" onclick="eliminarCita(this.form)"><img src="imagenes/cancelar.gif" alt="Cancelar" width="16" height="18" /></button></div></td>
				</form>
  </tr>
		<?php
			}
		}
	}
	?>
  <tr>
  	<td colspan="10" style="border: 0px;"></td>
  </tr>
  <?php
  	$minutos++;
  } //fin del for
  //aca se termina
  ?>
</table>
</div>
<div class="mensaje" id="error"></div>
</div>
</body>
</html>
