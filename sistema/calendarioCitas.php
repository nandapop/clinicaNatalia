<?
$anoInicial = '1900';
$anoFinal = '2100';
$funcionTratarFecha = 'document.location = "?dia="+dia+"&mes="+mes+"&ano="+ano;';

function fechaEnLetras($fecha){
		$fecha = arreglafecha($fecha,"YYYY-mm-dd");
		$mes["01"]="Enero";
		$mes["02"]="Febrero";
		$mes["03"]="Marzo";
		$mes["04"]="Abril";
		$mes["05"]="Mayo";
		$mes["06"]="Junio";
		$mes["07"]="Julio";
		$mes["08"]="Agosto";
		$mes["09"]="Septiembre";
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
		$fechaout = $fechain[2]."-".$fechain[1]