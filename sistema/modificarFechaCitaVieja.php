<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Cita.php");

$idCita = utf8_decode($_POST["idCita"]);
$fecha = utf8_decode($_POST["fecha"]);

$cita = Cita::obtenerPorId($idCita);
$cita->FechaCita = $fecha;
$cita->modificar();
?>