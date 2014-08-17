<?php 
  //aca van las consultas y busqueda de datos
  include_once("clases/Cita.php");
  include_once("clases/Paciente.php");
  $total_pagado=0;
  $total_garantia=0;
  $total_garantiaPagada=0;
  $hora=8;
  $minutos=0;
  $dia=$_GET['dia'];
  $mes=$_GET['mes'];
  $ano=$_GET['ano'];
  
  function fechaEnLetras($fecha){
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
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Citas DermoSalud</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" />
</head>
<body onload="window.print()">
<table border="1">
  <tr>
    <td colspan="6" style="text-align:center">Sistema Clinico Samed  <?php echo fechaEnLetras($ano."-".$mes."-".$dia);?></td>
  </tr>
  <tr>
  	<td colspan="6" style="text-align:center">Sucursal 1</td>
  </tr>
  <tr>
    <th>Hora</th>
    <th>Nombres</th>
    <th>Apellidos</th>
	<th>Prevision</th>
	<th>Atendido por</th>
	<th>Valor Pagado</th>
  </tr>
  <?php
  $n=0;
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
	
	<?php
		for($j=0;$j<$cantCitas;$j++)
		{
			$paciente = Paciente::obtenerPorId($citas[$j]->IdPaciente);
			if(is_numeric($citas[$j]->Pagado))
				$total_pagado += $citas[$j]->Pagado;
			else
				{
					$pago_paciente=split("-",$citas[$j]->Pagado);
					if(is_numeric($pago_paciente[0]))
						$total_pagado+=$pago_paciente[0];
				}
		if(($n%2)==0)
		{
			$n++;
			$color="#dddfe2";
		}
		else
		{
			$n++;
			$color="#fae3e8";
		}
		?>
		<tr style="background-color:<? echo $color;?>">
			<th><div style="font-size:11px"><?php echo $hora.":".$minutos."0";?></div></th>
			<?php list($nombre,$nombre2) = split(" ",$paciente->Nombre);?>
			<td><div style="font-size:11px"><?php echo $nombre; ?></div></td>
			<td><div style="font-size:11px"><?php echo $paciente->ApellidoP." ".$paciente->ApellidoM;?></div></td>
			<td><div style="font-size:11px"><?php echo $paciente->Prevision?></div></td>
			<td><div style="font-size:11px"><?php echo "Dra. Natalia Paredes"; ?></div></td>
			<td style="width:inherit;"><div style="font-size:11px"><?php echo $citas[$j]->Pagado;?></div></td>
		</tr>
  		<?php
		}
  		$minutos++;
  	} //fin del for
  ?>
  <tr>
  	<td colspan="5" style="text-align:right; border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF;">Total</td>
	<td style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF;">$<?php echo $total_pagado?></td>
  </tr>
</table>
</body>
</html>
