<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Receta.php");
$idCita = $_POST["idCita"];
$idReceta = $_POST["idReceta"];
//$borrarReceta = new Receta($idReceta,"","",$idCita);
$borrarReceta = new Receta($idReceta,"",$idCita);
$borrarReceta->eliminar();
?>