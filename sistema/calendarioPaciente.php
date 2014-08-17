<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/Paciente.php");
include_once("clases/Cita.php");
$id=$_POST['id'];
if($id==1)
{
	$dato=$_POST['rut'];
	$pacientes = Paciente::buscarPacienteRut($dato);
	if(count($pacientes)!=1)
		echo "0";
	else
	{
		if($pacientes[0]->Nombre=="" || $pacientes[0]->Telefono=="" || $pacientes[0]->Run=="" || $pacientes[0]->Email=="" || $pacientes[0]->ApellidoP=="" || $pacientes[0]->ApellidoM=="" || $pacientes[0]->Direccion=="" || $pacientes[0]->FechaNac=="" || $pacientes[0]->Sexo=="" || $pacientes[0]->Prevision=="" || $pacientes[0]->Ocupacion=="" )
			$envio="1.1";
		else
			$envio="1.0";
			
		echo "$envio&".$pacientes[0]->Nombre."&".$pacientes[0]->ApellidoP." ".$pacientes[0]->ApellidoM."&".$pacientes[0]->Telefono."&".$pacientes[0]->Prevision."&".$pacientes[0]->IdPaciente;
	}
}
else
	if($id==2)
	{
		$idPaciente=$_POST['idPaciente'];
		$fechaCita=$_POST['fechaCita'];
		$tipoCita=$_POST['tipoCita'];
		$pagado=$_POST['pagado'];
		$atencion = 1;
		$consulta=$_POST['consulta'];
		$equipo=$_POST['equipo'];
		$procedimiento=$_POST['procedimiento'];
		$cita=new Cita(0,$idPaciente,0,$fechaCita,$tipoCita,"","",$pagado,$atencion,$consulta,$equipo,$procedimiento);
		$idCita = $cita->insertar();
		if($idCita==-1)
			echo "0";
		else
			echo "1";
	}
	else
		if($id==3)
			{
				$idCita=$_POST['idCita'];
				$codigo=$_POST['codigo'];
				$retorno = Cita::cambiarEstado($idCita, $codigo);
				/*$timezone  = -2; //(GMT -6:00 ->Santiago)
				$hora=gmdate("Y-m-d H:i:s", time() + 3600*($timezone+date("I")));*/
				$hora = date("Y-m-d H:i:s"); 
				list($ano,$mes,$resto)=split("-",$hora); 
				list($dia, $horas)=split(" ",$resto); 
				list($hora,$min,$seg)=split(":",$horas); 
				
				

				$hora -= 4;
				if($hora>23)
					$hora=$hora-24;
				//echo $hora;
				$horaLlegada = "$ano-$mes-$dia $hora:$min:$seg";
				
				 
				if($codigo==2)
					$retorno = Cita::cambiarHoraLlegada($idCita, $horaLlegada);
				
				echo $retorno;
			}
		else
			if($id==4)//ACtualizar cita, pagado
			{
				$idCita=$_POST['idCita'];
				$pagado=$_POST['pagado'];
				$procedimiento=$_POST['procedimiento'];
				$retorno=Cita::actualizarPago($idCita, $pagado, $procedimiento);
				echo $retorno;
			}
			else
				if($id==5)
				{
					$idCita=$_POST['idCita'];
					$value= Cita::eliminarCita($idCita);
					echo $value;
				}


?>
