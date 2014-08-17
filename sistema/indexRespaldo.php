<?php
include("seguridad.php");
include("arriba.php");
?>
<style type="text/css">
<!--
.Estilo2 {font-size: 16px}
-->
</style>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form id="loginform" method="post" action="respaldoClinica.php">
<fieldset>
<legend>Ingrese clave para respaldar </legend>

<?php
	if ($_GET["errorusuario"]=="si")
	{
		echo '<p class="error"> clave no v&aacute;lida</p>';
	}
?>
  <label for="usuario"></label>
    <label for="clave"><input type="password" name="clave" tabindex="2" id="clave" />
    </label>
	<label for="submit">
    <input name="Submit" type="submit" id="submit" tabindex="4" value="Respaldar" />
	</label>
 </fieldset>
</form>
<p>&nbsp;</p>
<?php
include("abajo.php");
?>