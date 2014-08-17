<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");
include("arriba.php");
?>
<div id="transparencia">
	<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
</div>
<script language="javascript" type="text/javascript">
	function validar(formulario)
	{
		if(formulario.nombre.value=="")
		{	
			alert("ingrese nombre");
			formulario.nombre.focus();
			return false;
		}
		if(formulario.apellidop.value=="")
		{
			alert("ingrese apellido paterno");
			formulario.apellidop.focus();
			return false;
		}
		if(formulario.id_usuario.value=="")
		{
			alert("ingrese nombre de usuario");
			formulario.id_usuario.focus();
			return false;
		}
		if(formulario.clave.value=="" || formulario.clave_conf.value=="")
		{
			alert("ingrese claves")
			formulario.clave.focus();
			return false;
		}
		if(formulario.clave.value!=formulario.clave_conf.value)
		{
			alert("confirme clave secreta");
			formulario.clave_conf.focus();
			return false;
		}
		return true;
	}
</script>
<?php
	if (isset($_GET["msg"]))
	{
		echo '<p class="error">'.$_GET["msg"].'</p>';
	}
?>
<form action="registrarUsuario.php" onSubmit="return validar(this)" method="post">
<table width="495" cellspacing="0" bordercolor="#CCCCCC" style=" border:0px; width:500px ">
  <tr>
  	<td colspan="5"><p style="text-align:center; font-size:24px">Ingresar nuevo Usuario</p></td>
  </tr>
  	<input type="hidden" id="id" name="id" value="1" />
  <tr>
  	<td width="40%">Nombre</td>
	<td colspan="4"><input type="text" id="nombre" name="nombre" value='' size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Apellido Paterno</td>
    <td colspan="4"><input id="apellidop" name="apellidop" type="text" value='' size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Apellido Materno</td>
    <td colspan="4"><input type="text" id="apellidom" name="apellidom" value="" size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF"/></td>
  </tr>
   <tr>
    <td>Nombre de Usuario</td>
	<td width="181"><input name="id_usuario" id="id_usuario" type="text" size="30" value=''style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
	<td width="91"><a style="display:block" id="link_comprobar" onClick="comprobarUsuario(this.form)" title="Comprobar Usuario">Comprobar</a></td>
	<td width="57"><img id="aceptado" src="imagenes/aceptar.png" style="display:none" /></td>
	<td width="215"><img id="no_aceptado" src="imagenes/cancelar.gif" style="display:none" /></td>
  </tr>
  <tr>
    <td>Clave</td>
    <td colspan="4"><input name="clave" id="clave" type="password" value='' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="30" /></td>
  </tr>
  <tr>
    <td>Reingrese Clave</td>
    <td colspan="4"><input name="clave_conf" id="clave_conf" type="password" value='' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="30"/></td>
  </tr>
  <tr>
  	<td>Tipo Usuario</td>
	<?php 
	$categorias = Categoria::listar();
	?>
	<td colspan="4"><select name="categoria" class="inputNormal" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF">
	<?php
	foreach ($categorias as $categoria)
	{
	?>
					<option value="<?php echo $categoria->IdCategoria; ?>"><?php echo $categoria->NombreCategoria?></option>
	<?php
	}
	?>
					</select></td>
   </tr>
  <tr>
	<td colspan="2" align="right"><input type="submit" value="Guardar" /> <input type="button" value="Limpiar" onclick="estadoIconos()"/></td>
  </tr>
</table>
</form>			
<?php
include("abajo.php");
?>
