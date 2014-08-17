<?php
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");
$clave = $_POST["clave"];
$usuario = "respaldo";
if (Usuario::existeIdUsuario($usuario))
{
	$usuario = Usuario::obtenerPorId($usuario);
	$categoria = $usuario->Categoria;
	if($usuario->validaClave($clave))
	{	
	header("Content-Type: application/force-download"); 
	include("respaldo/bdSamed.sql");
	}
	else
	{
		header('Location: indexRespaldo.php?errorusuario=si');
	}
}
?>