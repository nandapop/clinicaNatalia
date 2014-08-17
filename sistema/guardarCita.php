<?php
include_once("clases/Cita.php");
$idPaciente=$_POST['idPaciente'];
$fecha=$_POST['fecha'];
$hora=$_POST['hora'];
$minutos=$_POST['minutos'];
$tipoCita = $_POST['tipoCita'];
$estado=0;
$idCita=0;
$segundos="00";
$diagnostico="";
list($dia, $mes, $ano) = split("/",$fecha);
$fechaCita= $ano."/".$mes."/".$dia." ".$hora.":".$minutos.":".$segundos;

$cita = new Cita($idCita, $idPaciente, $estado, $fechaCita, $tipoCita, $diagnostico);
$idCita = $cita->insertar();
echo "<img src='imagenes/ok.gif' alt='Ok'><br>Cita guardada con exito para el ".$fecha." a las ".$hora.":".$minutos.".<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()'>Ok</button>";
?>