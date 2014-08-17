<?php
$privilegiosPagina = 2;
include("seguridad.php");
include("arriba.php");
?>
<div id="transparencia">
	<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
</div>

<script language="javascript">
	function validar(formulario)
	{
		if((formulario.actual.value==formulario.actual_conf.value) && (formulario.nueva.value==formulario.nueva_conf.value))
		{
			return true;
		}
		else
		{
			alert("Claves no coinciden");
			return false;
		}
	}
</script>

<form id="loginform" method="post" onSubmit="return validar(this)" action="accionCambiarPassRespaldo.php">
<fieldset>
<legend>Cambiar Clave de Respaldo</legend>

<?php
	if (isset($_GET["msg"]))
	{
		echo '<p class="error">'.$_GET["msg"].'</p>';
	}
?><p>Clave Actual</p>
  <label for="ingrese clave actual"><input type="password" name="actual" tabindex="1" id="actual" />
  ingrese</label>
    <label for="reingrese clave actual"><input type="password" name="actual_conf" tabindex="2" id="actual_conf" />
    reingrese</label>
	<br />
	<p>Clave Nueva</p>
  <label for="ingrese clave nueva"><input type="password" name="nueva" tabindex="3" id="nueva" />
  ingrese</label>
    <label for="reingrese clave nueva"><input type="password" name="nueva_conf" tabindex="4" id="nueva_conf" />
    reingrese</label>
	<br />
	<label for="submit"><input name="Submit" type="submit" id="submit" tabindex="5" value="Actualizar" /></label>
 </fieldset>
</form>
<?php
include("abajo.php");
?>
