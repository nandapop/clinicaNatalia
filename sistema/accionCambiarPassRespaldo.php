<?php
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");

$actual = $_POST['actual'];
$nueva = $_POST['nueva'];

$usuario = "respaldo";
$usuario = Usuario::obtenerPorId($usuario);

if($usuario->Clave == $actual)
{
	$usuario->Clave = $nueva;
	if($usuario->modificar())
		header('location: cambiarPassRespaldo.php?msg=Clave cambiada con exito');
	else
		header('location: cambiarPassRespaldo.php?msg=No se ha podido cambiar la clave');
}
else
	header('location: cambiarPassRespaldo.php?msg=Clave actual no coincide');	

?>
