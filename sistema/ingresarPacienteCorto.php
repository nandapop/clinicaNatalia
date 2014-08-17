<?php
$privilegiosPagina = 1;
include("seguridad.php");

if($_POST)
{
	//si id==1 se guarda en la bd, de lo contrario se muestra el formulario de ingreso
	$id=$_POST['id'];
	if($id==1)
	{
		require_once("clases/Paciente.php");
		require_once("clases/AlergiaPaciente.php");
	
		//variables POST
		$run = $_POST['run'];
		$nombre = utf8_decode($_POST['nombre']);
		$apellidop = utf8_decode($_POST['apellidop']);
		$apellidom = utf8_decode($_POST['apellidom']);
		$telefono = $_POST['telefono'];
		$celular = $_POST['celular'];
		$fechanac = $_POST['fechanac'];
		$direccion = utf8_decode($_POST['direccion']);
		$sexo = $_POST['sexo'];
		$prevision = $_POST['prevision'];
		$email = $_POST['correo'];
		$ocupacion = utf8_decode($_POST['ocupacion']);
		$derivadopor = utf8_decode($_POST['derivadopor']);
		$primeracita="";
		$alergia=$_POST['alergia'];
			
		$paciente = new Paciente(0,$run, $nombre, $apellidop, $apellidom, $direccion, $telefono, $email, $fechanac, $primeracita, $sexo, $celular, $prevision, $ocupacion, $derivadopor,$alergia);
		$idPaciente=$paciente->insertar();
		
		$cantAlergia=$_POST['cantalergia'];
	
		for($i=0;$i<$cantAlergia;$i++)
		{
			$idAlergia=$_POST['alergia'.$i];
			$comentario = $_POST['comentario'.$i];
			$alergiaPaciente = new AlergiaPaciente($idPaciente, $idAlergia, $comentario);
			$alergiaPaciente->insertar();
		}
		echo "OK&".$idPaciente;
	}
	else
		if($id==2) //modificar datos del paciente
		{
			require_once("clases/Paciente.php");
			$run = $_POST['run'];
			$nombre = utf8_decode($_POST['nombre']);
			$apellidop = utf8_decode($_POST['apellidop']);
			$apellidom = utf8_decode($_POST['apellidom']);
			$telefono = $_POST['telefono'];
			$celular = $_POST['celular'];
			$fechanac = $_POST['fechanac'];
			$direccion = utf8_decode($_POST['direccion']);
			$sexo = $_POST['sexo'];
			$prevision = $_POST['prevision'];
			$email = $_POST['correo'];
			$ocupacion = utf8_decode($_POST['ocupacion']);
			$derivadopor = utf8_decode($_POST['derivadopor']);
			$primeracita=$_POST['primeracita'];
			$idPaciente=$_POST['idPaciente'];
			$alergia=$_POST['alergia'];
			
			$paciente=Paciente::obtenerPorId($idPaciente);
			$paciente->Nombre = $nombre;
			$paciente->ApellidoP=$apellidop;
			$paciente->ApellidoM = $apellidom;
			$paciente->Telefono=$telefono;
			$paciente->Celular = $celular;
			$paciente->FechaNac=$fechanac;
			$paciente->Direccion = $direccion;
			$paciente->Sexo=$sexo;
			$paciente->Prevision = $prevision;
			$paciente->Email=$email;
			$paciente->Ocupacion = $ocupacion;
			$paciente->DerivadoPor=$derivadopor;
			$paciente->Alergia=$alergia;
						
			
			
			if($paciente->modificar())
				echo "OK";
			else
				echo "No se pudo actualizar paciente. Intente mas tarde";
			
		}
		else
			echo "No se pudo guardar el paciente";
}
else
{
$rut = $_GET['rut'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Paciente :: Ingresar</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" media="screen" />

<script type="text/javascript" src="scripts/funcionesPaciente.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
</head>
<body>




	<div id="formContenedor">
    <div id="banner2">
    
<form id="formulario">
			<div id="transparencia">
				<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
			</div>
			<p align="center">SAMED FICHA PACIENTE</p>
<table width="668">
				<tr>
				  <td height="25">                
	    <tbody>
					<tr>
					  <th colspan="3">&nbsp;</th>
					  <td>&nbsp;</td>
	    </tr>
					<tr>
						<th height="36" colspan="3">ANTECEDENTES PERSONALES</th>
						<td><img src="imagenes/ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, 'Ayuda','')"></td>
					</tr>
					<tr>
						<td width="110" class="label" onmouseover="muestraAyuda(event, 'Run','')">Run</td>
						<td width="520" class="campo"><input name="run" type="text" class="inputNormal" id="run" value="<?php echo $rut; ?>"></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Nombre','')">Nombre</td>
						<td class="campo"><input class="inputNormal" type="text" id="nombre" name="nombre" size="30" /></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'ApellidoP','')">Apellido Paterno</td>
						<td class="campo"><input class="inputNormal" type="text" id="apellidop" name="apellidop" size="30"></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'ApellidoM','')">Apellido Materno</td>
						<td class="campo"><input class="inputNormal" type="text" id="apellidom" name="apellidom" size="30"></td>
					</tr>
					<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'Prevision','')">Prevision</td>
							<td class="campo"><select name="prevision" class="inputNormal" id="prevision">
									<option value="">Seleccione</option>
									<option value="Banmedica">Banmedica</option>
									<option value="Colmena">Colmena</option>	
									<option value="Consalud">Consalud</option>
									<option value="Fonasa">Fonasa</option>
									<option value="Cruz Blanca">Cruz Blanca</option>			
									<option value="Masvida">Masvida</option>
									<option value="Particular">Particular</option>
									<option value="Vida tres">Vida tres</option>
									<option value="Otro">Otro</option>
									</select>							</td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Telefono','')">Telefono</td>
						<td class="campo"><input class="inputNormal" type="text" id="codigoC" name="codigoC" size="2" maxlength="3" />-<input class="inputNormal" type="text" id="numeroC" name="numeroC" size="8" maxlength="7"/></td>
					</tr>
					
					
						<tr>						</tr>
						
						
						
						
						
						<tr>
							<td></td>
							<td colspan="2">
								<table id="alergias" style="display:none">
									<tbody>
										<?php
										require_once("clases/Alergia.php");
										$alergias = Alergia::listarAlergias();
										$maxIdAlergias = 0;
										echo"<tr>";
										for($j=0;$j<count($alergias);$j++)
										{
											$nombreAlergia = $alergias[$j]->NombreAlergia;
											$idAlergia = $alergias[$j]->IdAlergia;
											$descripcion = $alergias[$j]->Descripcion;
											if($idAlergia > $maxIdAlergias)
											{
												settype($idAlergia,"integer");
												$maxIdAlergias = $idAlergia;
											}
											?>
								  </tr>
												<tr>
												<td valign="top" align="left"><?php echo $nombreAlergia ?></td>
												<td valign="top"><input type="checkbox" value="<?php echo $idAlergia ?>" name="alergia" />[<a href="javascript:cambiaEstado('<?php echo $idAlergia ?>')" title="Ver descripcion">+</a>]</td>
											<td>
												<table id="<?php echo $idAlergia ?>" style="display:none">
													<tr>
														<td valign="top">Comentario</td>
														<td><textarea name="comentario"> </textarea></td>
													</tr>
												</table>											</td>							
										<?php	
										}
										echo"</tr>";
										?>
									</tbody>
								</table>							</td>			
						</tr>
			  </tbody>
	  </table>
				
<input type="hidden" name="cantAlergias" id="cantAlergias" value="<?php echo $maxIdAlergias;?>" />
				<div>
					<button id="botonEnviar" type="button" onClick="validaFormCorto()">Enviar</button>
					<button type="reset">Borrar</button>
				</div>
	  </form>
      </div>
</div>
		<div id="mensajesAyuda">
			<div id="ayudaTitulo"></div>
			<div id="ayudaTexto"></div>
		</div>
</body>
</html><?php }?>
