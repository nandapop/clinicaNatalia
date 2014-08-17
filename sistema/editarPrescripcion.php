<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
$idReceta = $_POST["idReceta"];
$indicaciones = $_POST["indicaciones"];
//$borrarReceta = new Receta($idReceta,"","",$idCita);
$editarReceta = Receta::obtenerRecetaPorId($idReceta);
$editarReceta->Indicaciones = $indicaciones;
$editarReceta->modificar();
?>