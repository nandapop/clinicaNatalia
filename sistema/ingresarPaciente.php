<?php
$privilegiosPagina = 1;
include("seguridad.php");

if($_POST)
{
	//si id==1 se guarda en la bd, de lo contrario se muestra el formulario de ingreso
	$id = $_POST['id'];
	if($id == 1)
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
		$prevision = utf8_decode($_POST['prevision']);
		$email = utf8_decode($_POST['correo']);
		$ocupacion = utf8_decode($_POST['ocupacion']);
		$derivadopor = utf8_decode($_POST['derivadopor']);
		$fechaPrimeraCita = $_POST['fechaPrimeraCita'];
		$alergia = utf8_decode($_POST['alergia']);
		$seguroSalud = utf8_decode($_POST['seguroSalud']);
			
		$paciente = new Paciente(0,$run, $nombre, $apellidop, $apellidom, $direccion, $telefono, $email, $fechanac, $fechaPrimeraCita, $sexo, $celular, $prevision, $ocupacion, $derivadopor,$alergia, $seguroSalud);
		$idPaciente=$paciente->insertar();
		
		$cantAlergia=$_POST['cantalergia'];
	
		for($i=0;$i<$cantAlergia;$i++)
		{
			$idAlergia=$_POST['alergia'.$i];
			$comentario=$_POST['comentario'.$i];
			$alergiaPaciente = new AlergiaPaciente($idPaciente, $idAlergia, $comentario);
			$alergiaPaciente->insertar();
		}
		echo "OK&".$idPaciente;
	}
	else if($id==2) //modificar datos del paciente
	{
		require_once("clases/Paciente.php");
		$run = $_POST['run'];
		$nombre = utf8_decode($_POST['nombre']);
		$apellidop = utf8_decode($_POST['apellidop']);
		$apellidom = utf8_decode($_POST['apellidom']);
		$telefono = $_POST['telefono'];
		$celular=$_POST['celular'];
		$fechanac=$_POST['fechanac'];
		$direccion = utf8_decode($_POST['direccion']);
		$sexo = $_POST['sexo'];
		$prevision = utf8_decode($_POST['prevision']);
		$email = utf8_decode($_POST['correo']);
		$ocupacion = utf8_decode($_POST['ocupacion']);
		$derivadopor = utf8_decode($_POST['derivadopor']);
		$fechaPrimeraCita= $_POST['fechaPrimeraCita'];
		$idPaciente = $_POST['idPaciente'];
		$alergia = utf8_decode($_POST['alergia']);
		$seguroSalud = utf8_decode($_POST['seguroSalud']);
		
		$paciente=Paciente::obtenerPorId($idPaciente);
		$paciente->Run = $run;
		$paciente->Nombre = $nombre;
		$paciente->ApellidoP=$apellidop;
		$paciente->ApellidoM = $apellidom;
		$paciente->Telefono=$telefono;
		$paciente->Celular = $celular;
		$paciente->FechaNac=$fechanac;
		$paciente->fechaPrimeraCita = $fechaPrimeraCita;
		$paciente->Direccion = $direccion;
		$paciente->Sexo=$sexo;
		$paciente->Prevision = $prevision;
		$paciente->Email=$email;
		$paciente->Ocupacion = $ocupacion;
		$paciente->DerivadoPor=$derivadopor;
		$paciente->Alergia=$alergia;
		$paciente->SeguroSalud=$seguroSalud;
			
		if($paciente->modificar())
		{
			echo "OK";
		}
		else
		{
			echo "No se pudo actualizar paciente. Intente mas tarde";
		}
	}
	else // Esto no debería pasar :D
	{
		echo "No se pudo guardar el paciente";
	}
}
else
{?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<title>Paciente :: Ingresar</title>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css">
<link rel="stylesheet" type="text/css" href="estilos/estilo_index.css" media="screen" />

<script type="text/javascript" src="scripts/funcionesPaciente.js"></script>
<script type="text/javascript" src="scripts/funcionesAjax.js"></script>
</head>
<body>
	<div id="formContenedor">
        <div id="banner3">

		<form id="formulario">
			<div id="transparencia">
				<div id="transparenciaMensaje">aaaaaaaaaaaa</div>
			</div>
			<p align="center">&nbsp;</p>
			<p align="center">SAMED FICHA PACIENTE</p>
			<table width="668">
				<td height="37"><tbody>
					<tr>
						<th colspan="3">ANTECEDENTES PERSONALES</th>
						<td><img src="imagenes/ayuda.gif" alt="Ayuda" onmouseover="muestraAyuda(event, 'Ayuda','')"></td>
					</tr>
					<tr>
						<td width="110" class="label" onmouseover="muestraAyuda(event, 'Run','')">Run</td>
						<td width="520" class="campo"><input class="inputNormal" id="run" name="run" type="text"></td>
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
									</select>
					  </td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Telefono','')">Telefono</td>
						<td class="campo"><input class="inputNormal" type="text" id="codigoC" name="codigoC" size="2" maxlength="3" value="032" />-<input class="inputNormal" type="text" id="numeroC" name="numeroC" size="8" maxlength="7"/></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Sexo','')">Sexo</td>
						<td class="campo"><select name="sexo" class="inputNormal" id="sexo">
										<option value="">Seleccione</option>
										<option value="M">Masculino</option>
										<option value="F">Femenino</option>
										</select></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'Celular','')">Celular</td>
						<td class="campo"><input class="inputNormal" type="text" id="codigoCel" name="codigoCel" size="2" maxlength="2" value="09" />-<input class="inputNormal" type="text" id="numeroCel" name="numeroCel" size="8" maxlength="8" /></td>
					</tr>
					<tr>
						<td class="label" onmouseover="muestraAyuda(event, 'FechaNac','')">Fecha Nacimiento</td>
						<td class="campo"><input class="inputNormal" type="text" id="dia" name="dia" size="1" maxlength="2" onChange="CalcularEdad()" />/<input class="inputNormal" type="text" id="mes" name="mes" size="1" maxlength="2" onChange="CalcularEdad()" />/<input class="inputNormal" type="text" id="ano" name="ano" size="5.1" maxlength="4" onChange="CalcularEdad()" /></td>
				  </tr>
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'Edad','')">Edad</td>
							<td class="campo"><input disabled="disabled" class="inputNormal" type="text" id="edad" size="4"/></td>
						</tr>
						<tr>
							<td class="label"  onmouseover="muestraAyuda(event, 'Direccion','')">Direccion</td>
						  <td class="campo"><input class="inputNormal" type="text" id="direccion" name="direccion" size="70" /></td>
						</tr>
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'Correo','')">Email</td>
							<td class="campo"><input class="inputNormal" type="text" id="email" name="email" size="50" value="no@tiene.cl"/></td>
						</tr>
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'Ocupacion','')">Ocupaci&oacute;n</td>
							<td class="campo"><input class="inputNormal" type="text" id="ocupacion" name="ocupacion" /></td>
						</tr>
						
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'DerivadoPor','')">Derivado por</td>
							<td class="campo"><input class="inputNormal" type="text" id="derivadopor" name="derivadopor" size="40" /></td>
						</tr>
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'PrimeraConsulta','')">Primera Cita</td>
							<td class="campo"><input class="inputNormal" type="text" id="diaPrimeraCita" name="diaPrimeraCita" size="1" maxlength="2"/>/<input class="inputNormal" type="text" id="mesPrimeraCita" name="mesPrimeraCita" size="1" maxlength="2"/>/<input class="inputNormal" type="text" id="anoPrimeraCita" name="anoPrimeraCita" size="5.1" maxlength="4"/></td>
						</tr>
						<tr>
							<td class="label" onMouseOver="muestraAyuda(event,'Alergia','')">Alergias</td>
							<td class="campo"><input class="inputNormal" type="text" id="alergiaa" name="alergiaa" value="No" /></td>
						</tr>
						<tr>
							<td class="label">Seguro de Salud</td>
							<td class="campo"><select name="seguroSalud" id="seguroSalud" class="inputNormal" >
									<option value="0" >Sin información</option>
									<option value="1">Sí</option>
									<option value="2">No</option>
								</select></td>
						</tr>
						<tr>
							<td class="label" onmouseover="muestraAyuda(event, 'AlergiaA','')">Ant. Morbidos</td>
							<td class="campo">[<a href="javascript:cambiaEstado('alergias')" title="Ver Alergias">+</a>]							</td>
						</tr>
						<tr>
							<td></td>
							<td colspan="2">
								<table id="alergias" style="display:none">
									<tbody>
										<?php
										require_once("clases/Alergia.php");
										$alergias = Alergia::listarAlergias();
										$maxIdAlergias = count($alergias);
										echo"<tr>";
										for($j=0;$j<count($alergias);$j++)
										{
											$nombreAlergia = $alergias[$j]->NombreAlergia;
											$idAlergia = $alergias[$j]->IdAlergia;
											$descripcion = $alergias[$j]->Descripcion;
											?>
								  </tr>
												<tr>
												<td valign="top" align="left"><?php echo $nombreAlergia ?></td>
												<td valign="top"><input type="checkbox" value="<?php echo $idAlergia ?>" name="alergia" id="alergia" />[<a href="javascript:cambiaEstado('<?php echo $idAlergia ?>')" title="Ver descripcion">+</a>]</td>
											<td>
												<table id="<?php echo $idAlergia ?>" style="display:none">
													<tr>
														<td valign="top">Comentario</td>
														<td><textarea name="comentario"> </textarea></td>
													</tr>
												</table>
											</td>							
										<?php	
										}
										echo"</tr>";
										?>
									</tbody>
								</table>
							</td>			
						</tr>
			  </tbody>
		  </table>
				
						<input type="hidden" name="cantAlergias" id="cantAlergias" value="<?php echo $maxIdAlergias;?>" />
				<div>
					<button id="botonEnviar" type="button" onClick="validaForm()">Enviar</button>
					<button type="reset">Borrar</button>
				</div>
	  </form>
</div>
		<div id="mensajesAyuda">
			<div id="ayudaTitulo"></div>
			<div id="ayudaTexto"></div>
		</div>
  </div>      
</body>
</html>
<?php }?>