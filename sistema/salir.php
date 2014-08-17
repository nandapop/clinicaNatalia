<?
session_start();
session_destroy();
include("arriba.php");
?>
<script language="javascript">
	alert("La sesión ha finalizado correctamente. ");
	location.href="index.php";
</script>
<?php
include("abajo.php");
?>