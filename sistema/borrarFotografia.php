<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Foto.php");
$idCita = $_POST["idCita"];
$idFoto = $_POST["idFoto"];
$borrarFoto = new Foto($idFoto,$idCita,"");
$borrarFoto->eliminar();
?>