<?php
session_start();
session_destroy();
include("arriba.php");
?>
<form id="loginform" method="post" action="validar.php">
<fieldset>
<legend>Log in</legend>
<p>Ingrese sus datos para ingresar al sistema</p>
<?php
	if ($_GET["errorusuario"]=="si")
	{
		echo '<p class="error">Usuario o clave no v&aacute;lidos</p>';
	}
?>
  <label for="usuario"><input type="text" name="usuario" tabindex="1" id="usuario" />
  usuario</label>
    <label for="clave"><input type="password" name="clave" tabindex="2" id="clave" />
    clave</label>
	<label for="submit">
    <input name="Submit" type="submit" id="submit" tabindex="4" value="Ingresar" />
	</label>
 </fieldset>
</form>
<?php
include("abajo.php");
?>