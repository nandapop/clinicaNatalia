<?php
include_once ("clases/tipoEx.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<p>Tipos de Examenes </p>
<table width="392" border="1">
  <tr>
    <th width="46" scope="col">Id</th>
    <th width="79" scope="col">Nombre</th>
    <th width="116" scope="col">Descripcion</th>
    <th width="123" scope="col">Opciones</th>
  </tr>
  <?php
$fila=tipoEx::listarPorEstado("activo");
for($i = 0; $i < count($fila); $i++)
{
		$id=$fila[$i]->IdTipo;
		$nombre=$fila[$i]->Nombre;
		$descripcion=$fila[$i]->Descripcion;
?>
  <tr>
    <td><?php echo $id;?></td>
    <td><?php echo $nombre;?></td>
    <td><?php echo $descripcion;?></td>
    <td><a href="modExamenes.php?id=<?php echo $id; ?>">Eliminar</a> <a href="#">Modificar</a></td>
  </tr>
  <?php }?>
</table>

<p>&nbsp;</p>
<p>Agregar Nuevo Examen </p>
<form id="formulario" method="post" action="modExamenes.php">
<table width="451" border="1">
  <tr>
    <th width="144" height="25" scope="col">Nombre</th>
    <th width="144" scope="col">Descripcion</th>
    <th width="82" scope="col">Estado</th>
    <th width="53" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td><input name="name" type="Text"></td>
    <td><input name="description" type="Text"></td>
    <td><select name="estado">
      <option>activo
	  <option selected>inactivo
    </select></td>
    <td> <input type="submit" value="agregar">
	</td>
  </tr>
</table>
</form>
</body>
</html>
