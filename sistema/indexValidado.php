<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("arriba2.php");
?><p style="text-align:center; font-size:18px; color:#339966">Bienvenido al Sistema Clinico SAMED, <?php echo $_SESSION['idUsuario'];?></p><?php 
include_once("abajo.php");?>