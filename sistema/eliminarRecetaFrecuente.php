<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/RecetaFrecuente.php");

$idReceta = $_GET["id"]; 
$receta = RecetaFrecuente::obtener($idReceta);
$receta->eliminar();
header('Location:recetasFrecuentes.php?msg=Receta eliminada');
?>