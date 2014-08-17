<?php
include_once("clases/Categoria.php");
include_once("clases/Usuario.php");

if($_POST)
{
	//si id==1 se guarda en la bd, de lo contrario se muestra el formulario de ingreso
	//si id == 2 se elimina de la bd, de lo contrario se muestra el formulario de ingreso
	$id=$_POST['id'];
	if($id==1)
	{	
		//variables POST
		$idUsuario=$_POST['idUsuario'];
		$nombre=$_POST['nombre'];
		$apellidopaterno=$_POST['apellidopaterno'];
		$apellidomaterno=$_POST['apellidomaterno'];
		$clave=$_POST['clave'];
		$idCategoria=$_POST['idCategoria'];
		
		// Aquí falta una comprobación pero no hay comprobación en la función de buscar categoría.
		//$categoria = Categoria::obtenerPorId($idCategoria);
		
		$categoria = Categoria::obtenerPorId($idCategoria);
		if($categoria)
		{
			$usuario = new Usuario($idUsuario, $nombre, $apellidopaterno, $apellidomaterno, $clave, $categoria);
			if($usuario->insertar())
			{
				echo "OK";
			}
			else
			{
				echo "No se pudo guardar el usuario, por favor intente nuevamente.";
			}
		}
		else
		{
			echo "$idCategoria no existe";
		}
	}//fin if id=1
	else if ($id == 2)
	{
		$idUsuario = $_POST['idUsuario'];
		$usuario = Usuario::obtenerPorId($idUsuario);
		if ($usuario->eliminar())
		{
			echo "OK";
		}
		else
		{
			echo "No se pudo eliminar el usuario, por favor intente nuevamente.";
		}
	}
	else if ($id == 3 )
	{
		$idUsuario = $_POST['idUsuario'];
		$nombre	= $_POST['nombre'];
		$apellidopaterno = $_POST['apellidopaterno'];
		$apellidomaterno = $_POST['apellidomaterno'];
		$clave = $_POST['clave'];
		$idCategoria = $_POST['idCategoria'];
		
		$categoria = Categoria::obtenerPorId($idCategoria);
		
		$usuario = Usuario::obtenerPorId($idUsuario);
		$usuario->Nombre = $nombre;
		$usuario->ApellidoPaterno = $apellidopaterno;
		$usuario->ApellidoMaterno = $apellidomaterno;
		$usuario->Categoria = $categoria;
		
		if ($clave != "")
		{
			$usuario->Clave = $clave;
		}
		if ($usuario->modificar())
		{
			echo "OK";
		}
		else
		{
			echo "No se pudo modificar el usuario, por favor intente nuevamente";
		}
	}
}
else
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Paciente :: Ingresar</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
<script type="text/javascript" src="scripts/funcionesUsuario.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
</head>
<body>
	<div id="formContenedor">
		<form id="formulario">
			<div id="transparencia">
				<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
			</div>
		
			<table width="668">
				<tbody>
					<tr>
						<th colspan="8">EDITAR USUARIO </th>
						<td><img src="imagenes/ayuda.gif" alt="Ayuda" onMouseOver="muestraAyuda(event, 'Ayuda','')"></td>
					</tr>
					<tr>
						<td width="110" class="label" onMouseOver="muestraAyuda(event, 'Usuario','')">Usuario</td>
						<td width="520" class="campo"><span class="label">Nombre</span></td>
						<td width="520" class="campo"><span class="label">Apellido Paterno</span></td>
						<td width="520" class="campo"><span class="label">Apellido Materno</span></td>
						<td width="520" class="campo"><span class="label">Categoria</span></td>
						<td width="520" class="campo">Acci&oacute;n</td>
						<td width="520" class="campo">&nbsp;</td>
					</tr>
					<tr>
						
					<?php 
					$usuarios = Usuario::listarUsuarios(); 
					foreach($usuarios as $usuario)
					{
					?>
						<td class="label">
						<?php echo $usuario->IdUsuario; ?>
						</span></td>
						<td class="campo"><?php echo $usuario->Nombre; ?></td>
						<td class="campo"><?php echo $usuario->ApellidoPaterno; ?></td>
						<td class="campo"><?php echo $usuario->ApellidoMaterno; ?></td>
						<td class="campo"><?php echo $usuario->Categoria->NombreCategoria; ?></td>
						<td class="campo"><button id="botonEliminar" onClick="eliminarUsuario('<?php echo $usuario->IdUsuario; ?>')" type="button">Eliminar</button></td>
						<td class="campo"><button id="botonModificar" onClick="llenarFormularioModificar('<?php echo $usuario->IdUsuario; ?>','<?php echo $usuario->Nombre;?>','<?php echo $usuario->ApellidoPaterno; ?>','<?php echo $usuario->ApellidoMaterno; ?>','<?php echo $usuario->Categoria->IdCategoria;?>')" type="button">Modificar</button></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="7"></td>
					</tr>
				</tbody>
				  <?php }?>
			</table>
			<p align="center">&nbsp;</p>
			<p align="center">DERMOSALUD USUARIO </p>
			<table width="668">
				<tbody>
					<tr>
						<th colspan="3">AGREGAR USUARIO </th>
						<td><img src="imagenes/ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, 'Ayuda','')"></td>
					</tr>
					<tr>
						<td width="110" class="label" onmouseover="muestraAyuda(event, 'Usuario','')">Usuario</td>
						<td width="520" class="campo"><input class="inputNormal" id="idUsuario" name="idUsuario" type="text"></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Nombre','')">Nombre</td>
						<td class="campo"><input class="inputNormal" type="text" id="nombre" name="nombre" size="30" /></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'ApellidoP','')">Apellido Paterno</td>
						<td class="campo"><input class="inputNormal" type="text" id="apellidopaterno" name="apellidopaterno" size="30"></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'ApellidoM','')">Apellido Materno</td>
						<td class="campo"><input class="inputNormal" type="text" id="apellidomaterno" name="apellidomaterno" size="30"></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Categoria','')">Categoria</td>
						<td class="campo"><select name="idCategoria" class="inputNormal" id="idCategoria">
							<?php
						$categorias = Categoria::listar();
						foreach($categorias as $categoria)
						{
							echo "<option value='$categoria->IdCategoria'>$categoria->NombreCategoria</option>";
						}
						?>
						</select></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Clave','')">Clave</td>
						<td class="campo"><input class="inputNormal" type="password" id="clave" name="clave"/></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'ReingresoClave','')">Re ingrese Clave </td>
						<td class="campo"><input class="inputNormal" type="password" id="ReingresoClave" /></td>
					</tr>
					
						<tr>
							<td></td>
							<td colspan="2">							</td>			
						</tr>
			  </tbody>
		  </table>
				
				<div>
					<button id="botonEnviar" onClick="validaForm()" type="button">Enviar</button>
					<button type="reset">Limpiar</button>
					<button id="mostrarModificar" onClick="modificarUsuario()" type="button">Modificar</button>
				</div>
	  </form>
		</div>
		<div id="mensajesAyuda">
			<div id="ayudaTitulo"></div>
			<div id="ayudaTexto"></div>
		</div>
	</body>
</html><?php }?>