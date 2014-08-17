<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/RecetaFrecuente.php");
include("arriba.php");
?>
<div id="transparencia">
	<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
</div>
<p>
  <?php
	if (isset($_GET["msg"]))
	{
		echo '<p class="error">'.$_GET["msg"].'</p>';
	}
?>
<script language="javascript" type="text/javascript" src="scripts/funcionesAjax.js"></script>
<script language="javascript" type="text/javascript">
	
	function eliminar(idReceta)
	{
		if(confirm("¿Esta seguro que desea eliminar?"))
			location.href="eliminarRecetaFrecuente.php?id="+idReceta;
	}
	function modificar(idReceta)
	{
		var id = document.getElementById('idOp');
		var idRec = document.getElementById('idReceta');
		var receta = document.getElementById('texto');
		var ajax=nuevoAjax();
		ajax.open("POST", "insertarRecetaFrecuente.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "idReceta="+idReceta+"&idOp=2";
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				valores = respuesta.split("-");

				if(valores[0]=="OK")
				{
					id.value = "3";
					idRec.value = idReceta;
					receta.value = valores[1];
				}
				else
				{
					alert("No se pudo recuperar receta. Intente nuevamente");
				}
				
			}
		}
	}
</script>
</p>
<form action="insertarRecetaFrecuente.php" method="post" name="formulario">
<table width="495" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <th width="356" scope="col">
      <div align="right">
	  	<input type="hidden" id="idOp" name="idOp" value="1"/>
	  	<input type="hidden" id="idReceta" name="idReceta" />
	  	<!--<input type="text" id="texto" name="texto" value="" width="40" height="40" />-->
		<textarea rows="5" id="texto" name="texto"></textarea>
        </div></th>
    <th width="133" scope="col"><div align="left">
      <input type="submit" name="Submit" value="guardar" />
    </div></th>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<table width="495" cellspacing="0" bordercolor="#CCCCCC" style=" border:thin double; width:500px ">
  <tr>
  	<td colspan="3" style="background-color: #fae3e8"><p style="text-align:center; font-size:24px">Recetas Frecuentes </p></td>
  </tr>

  <tr style="background-color:#dddfe2;">
  	<th width="425">Nombre</th>
	
	<th width="67">Mod.</th>
	<th width="67">Eli.</th>
  </tr>
  <?php
  $i=0;
  $recetas = RecetaFrecuente::listar();
  foreach($recetas as $receta)
  {
		  	?>
  <tr style="background-color:<?php if(($i%2)==0) echo "#f6f5e0"; else echo "#f3f3ee";?>">
    <td><p><?php echo $receta->Receta;?></p></td>
    <td><center><img src="imagenes/ok.gif" alt="Modificar" onclick="modificar('<?php echo $receta->Id;?>')" style="cursor:pointer" border="0" width="14" height="16"/></center></td>
	<td><center><img src="imagenes/cancelar.gif" alt="Eliminar" onclick="eliminar('<?php echo $receta->Id;?>')" style="cursor:pointer" border="0" width="14" height="16" /></center></td>
  </tr>
  <?php 
  		$i++;
  		
  }
  ?>
</table>
<?php
include("abajo.php");
?>
