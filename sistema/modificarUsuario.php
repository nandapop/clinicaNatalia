<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");

$id_usuario=$_GET['id_usuario'];
if(!isset($id_usuario)) header("location: listarUsuario.php");
include("arriba.php");
?>
<div id="transparencia">
	<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
</div>
<script language="javascript" type="text/javascript">
	function volver()
	{
		location.href="listarUsuario.php";
	}
	
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
	
$usuario = Usuario::obtenerPorId($id_usuario);
?>
<form action="registrarUsuario.php" onSubmit="return validar(this)" method="post">
<table width="495" cellspacing="0" bordercolor="#CCCCCC" style=" border:0px; width:500px ">
  <tr>
  	<td colspan="2"><p style="text-align:center; font-size:24px">Modificar Usuario</p></td>
  </tr>
  	<input type="hidden" id="id" name="id" value="2" />
  <tr>
  	<td width="40%">Nombre</td>
	<td><input type="text" id="nombre" name="nombre" value='<?php echo $usuario->Nombre?>' size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Apellido Paterno</td>
    <td><input id="apellidop" name="apellidop" type="text" value='<?php echo $usuario->ApellidoPaterno?>' size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Apellido Materno</td>
    <td><input type="text" id="apellidom" name="apellidom" value="<?php echo $usuario->ApellidoMaterno?>" size="30" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF"/></td>
  </tr>
   <tr>
    <td>Nombre de Usuario</td>
	<td width="181"><input name="id_usuario" id="id_usuario" type="text" size="30" value='<?php echo $usuario->IdUsuario?>' readonly="yes" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" /></td>
  </tr>
  <tr>
    <td>Clave</td>
    <td><input name="clave" id="clave" type="password" value='<?php echo $usuario->Clave;?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="30" /></td>
  </tr>
  <tr>
    <td>Reingrese Clave</td>
    <td><input name="clave_conf" id="clave_conf" type="password" value='<?php echo $usuario->Clave;?>' style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF" size="30"/></td>
  </tr>
  <tr>
  	<td>Tipo Usuario</td>
	
	<?php 
	$categorias = Categoria::listar();
	?>
	<td><select name="categoria" class="inputNormal" style="border-left-color:#FFFFFF; border-right-color:#FFFFFF; border-top-color:#FFFFFF">
	<?php
	$cat = $usuario->Categoria; 
	foreach ($categorias as $categoria)
	{
	?>
					<option value="<?php echo $categoria->IdCategoria; ?>" <?php if($cat->IdCategoria==$categoria->IdCategoria) echo "selected";?>><?php echo "$categoria->NombreCategoria"?></option>
	<?php
	}
	?>
					</select></td>
   </tr>
  <tr>
	<td colspan="2" align="right"><input type="submit" value="Guardar" /> <input type="button" value="Volver" onclick="volver()" /> <input type="button" value="Limpiar" onclick="estadoIconos()"/></td>
  </tr>
</table>
</form>			
<?php
include("abajo.php");
?>