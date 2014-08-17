<?php 
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
$idCita = utf8_decode($_POST["idCita"]); 
//$medicamento = utf8_decode($_POST["medicamento"]);
$indicaciones = $_POST["indicaciones"];
//$receta = new Receta(0,$medicamento,$indicaciones,$idCita);
//$indicacionesSigno = htmlspecialchars(urldecode($indicaciones));
$receta = new Receta(0,$indicaciones,$idCita);
if($receta->insertar())
{
	echo "Prescripcion ingresado con exito";
}
else
{
	echo "Ha habido un error al ingresar la prescripcion";
}
?>