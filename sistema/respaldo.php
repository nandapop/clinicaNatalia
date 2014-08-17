<?php
header('Content-type: application/txt');
header('Content-Disposition: attachment; filename="respaldo.txt"');
include_once("scripts/conexion.php");
require_once("clases/Paciente.php");
require_once("clases/Cita.php");
require_once("clases/Receta.php");
require_once("clases/AlergiaPaciente.php");
require_once("clases/Alergia.php");
//listado y guardando pacientes a un arreglo, despues guardarlo a un archivo мм
$pacientes = Paciente::listarPacientes();

foreach($pacientes as $paciente)
{
	echo "$paciente->IdPaciente".",";
	echo "$paciente->Run".",";
	echo "$paciente->Nombre".",";
	echo "$paciente->ApellidoP".",";
	echo "$paciente->ApellidoM".",";
	echo "$paciente->Direccion".",";
	echo "$paciente->Telefono".",";
	echo "$paciente->Email".",";
	echo "$paciente->FechaNac".",";
	echo "$paciente->FechaPrimeraCita".",";
	echo "$paciente->Sexo".",";
	echo "$paciente->Celular".",";
	echo "$paciente->Prevision".",";
	echo "$paciente->Ocupacion".",";
	echo "$paciente->DerivadoPor".",";
	echo "$paciente->Alergia";
	echo "|";
}
echo "--endoftable--";
$citas = Cita::listar();
foreach ($citas as $cita)
{
	echo "$cita->IdCita".",";
	echo "$cita->IdPaciente".",";
	echo "$cita->Estado".",";
	echo "$cita->FechaCita".",";
	echo "$cita->TipoCita".",";
	echo "$cita->DiagnosticoCita".",";
	echo "$cita->HoraLlegada".",";
	echo "$cita->Pagado".",";
	echo "$cita->Atencion".",";
	echo "|";
}
echo "--endoftable--";
$recetas = Receta::listarRecetas();
foreach($recetas as $receta)
{   
	echo "$receta->IdReceta".",";
	echo "$receta->Indicaciones".",";
	echo "$receta->IdCita".",";
	echo "|";
}
echo "--endoftable--";
$Alergias = Alergia::listarAlergias();
foreach($Alergias as $Alergia)
{
	echo "$Alergia->IdAlergia".",";
	echo "$Alergia->NombreAlergia".",";
	echo "$Alergia->Descripcion".",";
	echo "|";
}
echo "--endoftable--";
$AlergiaPacientes = AlergiaPaciente::listarTodasAlergiasPacientes();
foreach ($AlergiaPacientes as $AlergiaPaciente)
{
	echo "$AlergiaPaciente->IdAlergia".",";
	echo "$AlergiaPaciente->IdPaciente".",";
	echo "$AlergiaPaciente->Comentario".",";
	echo "|";
} 
echo "--endoftable--";
$tiposEx = tipoEx::listarTodasDescripciones();
foreach($tiposEx as $tipoEx)
{
	echo "$tipoEx->Nombre".",";
	echo "$tipoEx->Descripcion".",";
	echo "$tipoEx->IdTipo".",";
	echo "$tipoEx->Estado".",";
	echo "|";
}
echo "--endoftable--";
?>