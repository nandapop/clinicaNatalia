<?php
	include_once("clases/Categoria.php");
	include_once("clases/Usuario.php");

	$idUsuario = $_POST["usuario"];
	$clave = $_POST["clave"];
	if(Usuario::existeIdUsuario($idUsuario))
	{
		$usuario = Usuario::obtenerPorId($idUsuario);
		$categoria = $usuario->Categoria;
		if($usuario->validaClave($clave))
		{
			session_start();
			$_SESSION["autenticado"] = "si";
			$_SESSION["idUsuario"] = $idUsuario;
			$_SESSION["privilegios"] = $categoria->Privilegios;
			if($categoria->Privilegios==1)
				header('Location: calendarioHoras.php');
			else
				if($categoria->Privilegios==3)
					header('Location: indexValidado.php');
		}
		else
		{
			header('Location: index.php?errorusuario=si');
		}
	}
	else
	{
		header('Location: index.php?errorusuario=si');
	}
?>