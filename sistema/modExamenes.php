<p>Espere Por favor.........</p>
<p>&nbsp;</p>
<?php
include_once ("clases/tipoEx.php");
$id = $_GET["id"];
if ($id>=0)
{
$fila = tipoEx::eliminar($id);
if ($filas ==1)
	echo "Se ha eliminado el examen de id = $id";
}
else
{
	$nombre = $_POST['name'];
	$descripcion = $_POST['description'];
	$estado = $_POST['estado'];
	$fila =tipoEx::buscarPorNombre($nombre);
	echo "00".$fila."00";
	if ($fila<0)
	{
		$fila=tipoEx::insertar($nombre, $descripcion, $estado);
		if ($fila != -1)
			echo "Se ha insertado un examen";
	}
	else
		echo "no se puede repetir el examen, ingrese otro...";
}	?>
	<p><a href="adminExamenes.php">golver</a></p>
