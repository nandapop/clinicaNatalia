<?php session_start();
include_once("clases/Paciente.php");
$idPaciente = $_POST['idpaciente'];
$paciente = Paciente::obtenerPorId($idPaciente);
if($paciente->eliminarPacienteSinDatos())
	echo "OK";
else
	echo"No se pudo eliminar por problemas de conexion. Intente más tarde.";
?>