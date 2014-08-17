<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Foto.php");
$idCita = $_POST["idCita"];
$descripcion = $_POST["descripcion"];
$foto = new Foto(0, $idCita, $descripcion);
if($foto->insertar())
{
	if(!move_uploaded_file($_FILES['uploadFile'] ['tmp_name'], "fotos/" . $foto->IdFoto . ".jpg"))
	{
		$foto->eliminar();
		header("location: fichaPaciente.php?idCita=$idCita&resultadoFoto=0");
	}
	else
	{
		header("location: fichaPaciente.php?idCita=$idCita&resultadoFoto=1");
	}
}
else
{
	header("location: fichaPaciente.php?idCita=$idCita&resultadoFoto=0");
}	
?>