<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/PatologiaFrecuente.php");

$idPatologia = $_GET["id"]; 
$receta = PatologiaFrecuente::obtener($idPatologia);
$receta->eliminar();
header('Location:patologiasFrecuentes.php?msg=Patologia eliminada');
?>