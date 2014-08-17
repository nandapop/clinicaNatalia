<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Paciente.php");
$id=$_POST['id'];
$dato=$_POST['dato'];
if($id==1)
	$pacientes = Paciente::buscarPacienteRut($dato);
else
	if($id==2)
		$pacientes = Paciente::buscarPacienteNombre($dato);
	else
		if($id==3)
			{
				list($nombre, $apellido) = split(" ",$dato);
				$pacientes = Paciente::buscarPaciente($nombre, $apellido);
			}
		else
			if($id==4)
				$pacientes = Paciente::obtenerPorId($dato);
	

if(count($pacientes)==0)
{
	echo "0";
}
else
	if(count($pacientes)==1 && $id!=4)
	{
		echo "1&".$pacientes[0]->IdPaciente."&".$pacientes[0]->Run."&".$pacientes[0]->Nombre."&".$pacientes[0]->ApellidoP."&".$pacientes[0]->ApellidoM."&".$pacientes[0]->Direccion."&".$pacientes[0]->Telefono."&".$pacientes[0]->Email."&".$pacientes[0]->FechaNac."&".$pacientes[0]->FechaPrimeraCita."&".$pacientes[0]->Sexo."&".$pacientes[0]->Celular."&".$pacientes[0]->Prevision."&".$pacientes[0]->Ocupacion."&".$pacientes[0]->DerivadoPor;
		/*
		echo "
			<form>
			<p>Paciente Encontrado</p><br />
			<table align=\"center\">
		<tr>
						<td class=\"label\">Nombre</td>
						<td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"nombre\" value=\"".$pacientes[0]->Nombre."\" /></td>
					</tr>
					<tr>
						<td class=\"label\">Apellidos</td>
						<td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"apellidos\" value=\"".$pacientes[0]->ApellidoP." ".$pacientes[0]->ApellidoM."\" /></td>
						<td></td>
					</tr>
					<tr>
						<td class=\"label\">Telefono</td>
						<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"telefono\" disabled=\"disabled\" value=\"".$pacientes[0]->Telefono."\"/></td>
					</tr>
					<tr>
						<td class=\"label\">Prevision</td>
						<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"prevision\" disabled=\"disabled\" value=\"".$pacientes[0]->Prevision."\"/></td>
					</tr>
					<tr>
						<td class=\"label\">Rut</td>
						<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"rut\" disabled=\"disabled\" value=\"".$pacientes[0]->Run."\" /></td>
					</tr>
					<tr>
						<th class=\"label\">Consulta</th>
						<th class=\"label\">Pabellon Sally</th>					
						<th class=\"label\">Pabellon Sandra</th>
					</tr>
					<tr>
						<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"1\" checked=\"ckecked\" /></td>
						<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"2\" /></td>
						<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"3\" /></td>
					</tr>
					<tr>
						<td width=\"50%\"><b>Fecha:</b> ".$fecha."</td>
						<td width=\"50%\"><b>Hora:</b> 	<select name=\"hora\" style=\"width: 50px;\">
										<option value=\"9\">9</option>
										<option value=\"10\">10</option>
										<option value=\"11\">11</option>
										<option value=\"12\">12</option>
										<option value=\"13\">13</option>
										<option value=\"14\">14</option>
										<option value=\"15\">15</option>
										<option value=\"16\">16</option>
										<option value=\"17\">17</option>
										<option value=\"18\">18</option>
										<option value=\"19\">19</option>
										<option value=\"20\">20</option>
									</select>: 
									<select name=\"minutos\" style=\"width: 50px;\">
										<option value=\"00\">00</option>
										<option value=\"10\">10</option>
										<option value=\"20\">20</option>
										<option value=\"30\">30</option>
										<option value=\"40\">40</option>
										<option value=\"50\">50</option>
									</select></td>
					</tr>								
					<tr>
						<td><input type=\"hidden\" name=\"idPaciente\" value=\"".$pacientes[0]->IdPaciente."\" /><input type=\"hidden\" name=\"fecha\" value=\"".$fecha."\" /><!--<button type=\"button\" onclick=\"ocultaMensaje()\">Buscar Otro</button>--></td>
						<td><button type=\"button\" onclick=\"guardarCita(this.form)\">Aceptar</button></td>
						<td><button type=\"button\" onclick=\"cancelarPac(this.form)\">Cancelar</button></td>
					</tr>
				</table>
			</form>";*/
	}
	else
		if(count($pacientes)==1 && $id==4)
		{
			echo "1&".$pacientes->IdPaciente."&".$pacientes->Run."&".$pacientes->Nombre."&".$pacientes->ApellidoP."&".$pacientes->ApellidoM."&".$pacientes->Direccion."&".$pacientes->Telefono."&".$pacientes->Email."&".$pacientes->FechaNac."&".$pacientes->FechaPrimeraCita."&".$pacientes->Sexo."&".$pacientes->Celular."&".$pacientes->Prevision."&".$pacientes->Ocupacion."&".$pacientes->DerivadoPor;
			/*echo $id."
			  
				<form>
				<p><b>Paciente Encontrado</b></p><br />
				<table align=\"center\">
						<tr>
							<td class=\"label\">Nombre</td>
							<td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"nombre\" value=\"".$pacientes->Nombre."\" /></td>
						</tr>
						<tr>
							<td class=\"label\">Apellidos</td>
							<td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"apellidos\" value=\"".$pacientes->ApellidoP." ".$pacientes->ApellidoM."\" /></td>
							<td></td>
						</tr>
						<tr>
							<td class=\"label\">Telefono</td>
							<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"telefono\" disabled=\"disabled\" value=\"".$pacientes->Telefono."\"/></td>
						</tr>
						<tr>
							<td class=\"label\">Prevision</td>
							<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"prevision\" disabled=\"disabled\" value=\"".$pacientes->Prevision."\"/></td>
						</tr>
						<tr>
							<td class=\"label\">Rut</td>
							<td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"rut\" disabled=\"disabled\" value=\"".$pacientes->Run."\" /></td>
						</tr>
						<tr>
							<th class=\"label\">Consulta</th>
							<th class=\"label\">Pabellon Sally</th>					
							<th class=\"label\">Pabellon Sandra</th>
						</tr>
						<tr>
							<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"1\" checked=\"ckecked\" /></td>
							<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"2\" /></td>
							<td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"3\" /></td>
						</tr>
						<tr>
							<td width=\"50%\"><b>Fecha:</b> ".$fecha."</td>
							<td width=\"50%\"><b>Hora:</b> 	<select name=\"hora\" style=\"width: 50px;\">
											<option value=\"9\">9</option>
											<option value=\"10\">10</option>
											<option value=\"11\">11</option>
											<option value=\"12\">12</option>
											<option value=\"13\">13</option>
											<option value=\"14\">14</option>
											<option value=\"15\">15</option>
											<option value=\"16\">16</option>
											<option value=\"17\">17</option>
											<option value=\"18\">18</option>
											<option value=\"19\">19</option>
											<option value=\"20\">20</option>
										</select>: 
										<select name=\"minutos\" style=\"width: 50px;\">
											<option value=\"00\">00</option>
											<option value=\"10\">10</option>
											<option value=\"20\">20</option>
											<option value=\"30\">30</option>
											<option value=\"40\">40</option>
											<option value=\"50\">50</option>
										</select></td>
						</tr>								
						<tr>
							<td><input type=\"hidden\" name=\"idPaciente\" value=\"".$pacientes->IdPaciente."\" /><input type=\"hidden\" name=\"fecha\" value=\"".$fecha."\" /><!--<button type=\"button\" onclick=\"ocultaMensaje()\">Buscar Otro</button>--></td>
							<td><button type=\"button\" onclick=\"guardarCita(this.form)\">Aceptar</button></td>
							<td><button type=\"button\" onclick=\"cancelarPac(this.form)\">Cancelar</button></td>
						</tr>
					</table>
				</form>";*/
		}
		else
		{
			echo "2";
			/*$texto="<form>\n<table>";
			for($j=0;$j<count($pacientes);$j++)
			{
				$texto.= "\n<tr>\n<td><input type=\"radio\" value='".$pacientes[$j]->IdPaciente."' name=\"pac\"></td>\n<td>".$pacientes[$j]->Nombre.", ".$pacientes[$j]->ApellidoP." ".$pacientes[$j]->ApellidoM."</td>\n</tr>\n";
			}
			$texto.="\n</table><input type=\"hidden\" value=\"".count($pacientes)."\" name=\"totalPac\"><input type=\"hidden\" value=\"".$fecha."\" name=\"fecha\"><br /><button type=\"button\" onclick='buscarIdPac(this.form)>Aceptar</button></form>";
			echo $texto;		*/
		}
?>