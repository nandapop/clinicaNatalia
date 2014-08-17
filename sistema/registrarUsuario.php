<?php
include_once("clases/Usuario.php");
include_once("clases/Categoria.php");

if($_POST)
{
	$id = $_POST['id'];
	$formato = 0;
}
if($_GET)
{
	$id = $_GET['id'];
	$formato = 1;
}

if($id==1)//Guardar
{
	$nombre=$_POST['nombre'];
	$apellidop = $_POST['apellidop'];
	$apellidom = $_POST['apellidom'];
	$id_usuario = $_POST['id_usuario'];
	$clave = $_POST['clave'];
	$categoria = $_POST['categoria'];
	$usuario_existe = Usuario::obtenerPorId($id_usuario);
	if($usuario_existe->Nombre!="")
		header("location: ingresarUsuario.php?msg=Nombre de Usuario ya existe");
	
	$usuario = new Usuario($id_usuario, $nombre, $apellidop, $apellidom, $clave, $categoria);
	$id = $usuario->insertar();
	if($id)
		header("location: ingresarUsuario.php?msg=Usuario ingresado con exito.");
	else
		header("location: ingresarUsuario.php?msg=Usuario no fue creado.");
}
elseif($id==2)//Modificar
{
	$nombre=$_POST['nombre'];
	$apellidop = $_POST['apellidop'];
	$apellidom = $_POST['apellidom'];
	$id_usuario = $_POST['id_usuario'];
	$clave = $_POST['clave'];
	$categoria = $_POST['categoria'];
	$usuarioAntiguo = Usuario::obtenerPorId($id_usuario);
	
	if($usuarioAntiguo->Nombre != $nombre)
		$usuarioAntiguo->Nombre = $nombre;
		
	if($usuarioAntiguo->ApellidoPaterno != $apellidop)
		$usuarioAntiguo->ApellidoPaterno = $apellidop;
	
	if($usuarioAntiguo->ApellidoMaterno != $apellidom)
		$usuarioAntiguo->ApellidoMaterno = $apellidom;	
	
	if($usuarioAntiguo->Clave != $clave)
		$usuarioAntiguo->Clave = $clave;

	$categoriaUs = $usuarioAntiguo->Categoria;
	if($categoriaUs->IdCategoria != $categoria)
		$usuarioAntiguo->Categoria = $categoria;

	if($usuarioAntiguo->Nombre != $nombre)
		$usuarioAntiguo->Nombre = $nombre;
	
	if($usuarioAntiguo->modificar())
		header("location: listarUsuario.php?msg=Usuario ".$id_usuario." modificado correctamente");
	else
		header("location: listarUsuario.php?msg=Usuario ".$id_usuario." no fue modificado. Intente nuevamente");
}
elseif($id==3)//Eliminar
{
	$id_usuario = $_GET['id_usuario'];
	$usuario = Usuario::obtenerPorId($id_usuario);
	if($usuario->eliminar())
		header("location: listarUsuario.php?msg=Usuario ".$id_usuario." eliminado correctamente");
	else
		header("location: listarUsuario.php?msg=Usuario ".$id_usuario." no fue eliminado. Intente nuevamente");
	
}
elseif($id==4)//Comprobar usuario
{
	$nombre = $_POST['usuario'];
	$usuario = Usuario::obtenerPorId($nombre);
	if($usuario->Nombre!="")
	{
		echo "NO";
	}
	else
	{
		echo "OK";
	}
	
}


?>
