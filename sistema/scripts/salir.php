<?
session_start();
session_destroy();
include("arriba.php");
?>
<script language="javascript">
	alert("La sesi�n ha finalizado correctamente. ");
	location.href="index.php";
</script>
<?php
include("abajo.php");
?>