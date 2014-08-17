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
<?php
	if (isset($_GET["msg"]))
	{
		echo '<p class="error">'.$_GET["msg"].'</p>';
	}
?>
<script language="javascript" type="text/javascript">
	function modificar(id_usuario)
	{
		location.href="modificarUsuario.php?id_usuario="+id_usuario;
	}
	
	function eliminar(id_usuario)
	{
		if(confirm("¿Esta seguro que desea eliminar?"))
			location.href="registrarUsuario.php?id=3&id_usuario="+id_usuario;
	}
</script>
<table width="495" cellspacing="0" bordercolor="#CCCCCC" style=" border:thin double; width:500px ">
  <tr>
  	<td colspan="4" style="background-color: #fae3e8"><p style="text-align:center; font-size:24px">Lista de Usuarios</p></td>
  </tr>

  <tr style="background-color:#dddfe2;">
  	<th>Nombre</th>
	<th>Apellidos</th>
	<th>Mod.</th>
	<th>Eli.</th>
  </tr>
  <?php
  $i=0;
  $usuarios = Usuario::listarUsuarios();
  foreach($usuarios as $usuario)
  {
  		$categoria = $usuario->Categoria;
		if($categoria->IdCategoria!=3)
		{
  	?>
  <tr style="background-color:<?php if(($i%2)==0) echo "#f6f5e0"; else echo "#f3f3ee";?>">
    <td><p><?php echo $usuario->Nombre;?></p></td>
    <td><p><?php echo $usuario->ApellidoPaterno." ".$usuario->ApellidoMaterno;?></p></td>
	<td><center><img src="imagenes/editar.png" alt="Editar" onclick="modificar('<?php echo $usuario->IdUsuario;?>')" style="cursor:pointer" border="0" width="16" height="16" /></center></td>
	<td><center><img src="imagenes/cancelar.gif" alt="Eliminar" onclick="eliminar('<?php echo $usuario->IdUsuario;?>')" style="cursor:pointer" border="0" width="14" height="16" /></center></td>
  </tr>
  <?php 
  		$i++;
  		}
  }
  ?>

</table>
<?php
include("abajo.php");
?>
