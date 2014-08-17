<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Cita.php");

$idCita = $_POST["idCita"];
$cita = Cita::obtenerPorId($idCita);
$cita->Estado = 3; // Significa que fue atendido
$cita->modificar();
echo "OK";
?>