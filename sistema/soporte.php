<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");
include("arriba.php");
?>
<table cellspacing="0" bordercolor="#CCCCCC" style=" border:thin double; width:650px ">
  <tr>
  	<td colspan="4" style="background-color: #fae3e8"><p style="text-align:center; font-size:24px">Datos de contacto </p></td>
  </tr>

  <tr style="background-color:#dddfe2;">
  	<th><div align="center">Nombre</div></th>
	<th><div align="center">Apellido</div></th>
	<th><div align="center">Telefono</div></th>
	<th><div align="center">E-Mail</div></th>
  </tr>
  
  <tr style="background-color:#f6f5e0">
    <td><p align="center">Agustín</p></td>
    <td><p align="center">Cautín</p></td>
	<td><p align="center">09-98166246</p></td>
	<td><p align="center">acautin@gmail.com</p></td>
  </tr>
  <tr style="background-color:#f6f5e0">
    <td><p align="center">Fernanda</p></td>
    <td><p align="center">Ramirez</p></td>
	<td><p align="center">09-87257814</p></td>
	<td><p align="center">nandapop@gmail.com</p></td>
  </tr>

</table>
<?php
include("abajo.php");
?>