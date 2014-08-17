<?php
include_once("scripts/conexion.php");
class Paciente
{
	private $idPaciente;
	private $run;
	private $nombre;
	private $apellidoP;
	private $apellidoM;
	private $direccion;
	private $telefono;
	private $email;
	private $fechaNac;
	private $fechaPrimeraCita;
	private $sexo;
	private $celular;
	private $prevision;
	private $ocupacion;
	private $derivadoPor;
	private $alergia;
	private $seguroSalud;
	
	const TABLA = 'paciente';
	const CLAVE_PRIMARIA = 'idPac_pk';
	const CAMPOS_TABLA = 'idPac_pk, run, apellidoP, apellidoM, nombre, direccion, telefono, email, fechaNac, fechaPrimeraCita, sexo, celular, prevision, ocupacion, derivadoPor, alergia, seguroSalud';
	
	
	public function __construct($idPaciente=0,$run="",$nombre="",$apellidoP="",$apellidoM="",$direccion="",$telefono="",$email="",$fechaNac="",$fechaPrimeraCita="",$sexo="",$celular="",$prevision="",$ocupacion="",$derivadoPor="",$alergia="",$seguroSalud=0)
	{
		$this->idPaciente=$idPaciente;
		$this->run=$run;
		$this->nombre=$nombre;
		$this->apellidoP=$apellidoP;
		$this->apellidoM=$apellidoM;
		$this->direccion=$direccion;
		$this->telefono=$telefono;
		$this->email=$email;
		$this->fechaNac=$fechaNac;
		$this->fechaPrimeraCita=$fechaPrimeraCita;
		$this->sexo=$sexo;
		$this->celular=$celular;
		$this->prevision=$prevision;
		$this->ocupacion=$ocupacion;
		$this->derivadoPor=$derivadoPor;
		$this->alergia=$alergia;
		$this->seguroSalud=$seguroSalud;
    }
	
	public function cambiarFormatoFecha()
	{
		list( $dia, $mes, $anno ) = split("/",$this->fechaNac);
		$this->setFechaNac($anno."-".$mes."-".$dia);
	}
	
	public function insertar()
	{
		$this->cambiarFormatoFecha();
		$values = "'$this->run', '$this->nombre', '$this->apellidoP',";
		$values .= "'$this->apellidoM', '$this->direccion', '$this->telefono',";
		$values .= "'$this->email', '$this->fechaNac', '$this->fechaPrimeraCita',";
		$values .= "'$this->sexo', '$this->celular', '$this->prevision',";
		$values .= "'$this->ocupacion', '$this->derivadoPor', '$this->alergia', '$this->seguroSalud'";
		$bd = new Conexion();
		$parametros = array("table" => Paciente::TABLA, "fields" => "run, nombre, apellidop, apellidom, direccion, telefono, email, fechaNac, fechaPrimeraCita, sexo, celular, prevision, ocupacion, derivadoPor, alergia, seguroSalud", "values" => "$values");
		$this->idPaciente = $bd->insert($parametros);
		return $this->idPaciente;
	}
	
	// Retorna todos los Pacientes que existen en un arreglo
	static public function listarPacientes()
	{
		$bd = new Conexion();
		$parametros = array("table" => Paciente::TABLA, "fields" => Paciente::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{			
																																	 												 
			$pacientes[] = new Paciente($fila->idPac_pk, $fila->run, $fila->nombre, $fila->apellidoP, $fila->apellidoM, $fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	// Retorna un paciente especifico
	public function buscarPaciente($nombre,$apellidop)
	{
		$parametros = array("table" => Paciente::TABLA, "fields" => "*", "where" => "nombre LIKE '%$nombre%' AND apellidop LIKE '%$apellidop%'");
		$bd = new Conexion();
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{
			$pacientes[] = new Paciente($fila->idPac_pk,$fila->run,$fila->nombre,$fila->apellidoP, $fila->apellidoM,$fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	
	public function buscarPacienteCompleto($nombre,$apellidop, $apellidom)
	{
		$parametros = array("table" => Paciente::TABLA, "fields" => "*", "where" => "nombre LIKE '%$nombre%' AND apellidop LIKE '%$apellidop%' AND apellidom LIKE '%$apellidom%'");
		$bd = new Conexion();
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{
			$pacientes[] = new Paciente($fila->idPac_pk,$fila->run,$fila->nombre,$fila->apellidoP, $fila->apellidoM,$fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	
	public function buscarPacienteNombre($nombre)
	{
		$parametros = array("table" => Paciente::TABLA, "fields" => "*", "where" => "nombre LIKE '%$nombre%'");
		$bd = new Conexion();
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{
			$pacientes[] = new Paciente($fila->idPac_pk,$fila->run,$fila->nombre,$fila->apellidoP, $fila->apellidoM,$fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	
	public function eliminarPacienteSinDatos()
	{
		$bd = new Conexion();
		$parametros = array("table" => Paciente::TABLA, "where" => "idPac_pk = $this->idPaciente", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	public function buscarPacienteApellidoP($apellidoP)
	{
		$parametros = array("table" => Paciente::TABLA, "fields" => "*", "where" => "nombre LIKE '%$$apellidoP%'");
		$bd = new Conexion();
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{
			$pacientes[] = new Paciente($fila->idPac_pk,$fila->run,$fila->nombre,$fila->apellidoP, $fila->apellidoM,$fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	
	public function buscarPacienteRut($rut)
	{
		$parametros = array("table" => Paciente::TABLA, "fields" => "*", "where" => "run = '$rut'");
		$bd = new Conexion();
		$filas = $bd->select($parametros);
		$pacientes = array();
		foreach($filas as $fila)
		{
			$pacientes[] = new Paciente($fila->idPac_pk,$fila->run,$fila->nombre,$fila->apellidoP, $fila->apellidoM,$fila->direccion, $fila->telefono, $fila->email, $fila->fechaNac, $fila->fechaPrimeraCita, $fila->sexo, $fila->celular, $fila->prevision, $fila->ocupacion, $fila->derivadoPor, $fila->alergia, $fila->seguroSalud);
		}
		return $pacientes;
	}
	
	static public function obtenerPorId($idPaciente)
	{
		$bd = new Conexion();
		$parametros = array("table" => Paciente::TABLA, "fields" => Paciente::CAMPOS_TABLA, "where" => "idPac_pk = $idPaciente", "limit" => 1);
		$filas = $bd->select($parametros);
		$paciente = new Paciente($filas[0]->idPac_pk,$filas[0]->run, $filas[0]->nombre, $filas[0]->apellidoP, $filas[0]->apellidoM, $filas[0]->direccion, $filas[0]->telefono, $filas[0]->email, $filas[0]->fechaNac, $filas[0]->fechaPrimeraCita, $filas[0]->sexo, $filas[0]->celular, $filas[0]->prevision, $filas[0]->ocupacion, $filas[0]->derivadoPor, $filas[0]->alergia, $filas[0]->seguroSalud);
		return $paciente;
	}
	
	function delete()
	{
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
    {
        $functionName  = "get".$attr;
        return $this->$functionName();
    }
	
	// Funcion que retorna el nombre completo concatenado.
	private function getNombreCompleto()
	{
		return $this->nombre . " " . $this->apellidoP . " " . $this->apellidoM;
	}
	
	private function getRun()
	{
		return $this->run;
	}
	
	private function getAlergia()
	{
		return $this->alergia;
	}
	
	private function getIdPaciente()
	{
		return $this->idPaciente;
	}
	
	private function getNombre()
	{
		return $this->nombre;
	}
	
	private function getApellidoP()
	{
		return $this->apellidoP;
	}
	
	private function getApellidoM()
	{
		return $this->apellidoM;
	}
	
	private function getDireccion()
	{
		return $this->direccion;
	}
	
	private function getTelefono()
	{
		return $this->telefono;
	}
	
	private function getCelular()
	{
		return $this->celular;
	}
	
	private function getEmail()
	{
		return $this->email;
	}
	
	private function getFechaNac()
	{
		return $this->fechaNac;
	}
	
	private function getSexo()
	{
		return $this->sexo;
	}
	
	private function getPrevision()
	{
		return $this->prevision;
	}
	
	private function getOcupacion()
	{
		return $this->ocupacion;
	}
	
	private function getDerivadoPor()
	{
		return $this->derivadoPor;
	}
	
	private function getFechaPrimeraCita()
	{
		return $this->fechaPrimeraCita;
	}
	
	private function getSeguroSalud()
	{
		return $this->seguroSalud;
	}
	
	// Funciones set para dar valores a los atributos.
	
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setRun($propValue)
	{
		$this->run = $propValue;
	}
	
	private function setNombre($propValue)
	{
		$this->nombre = $propValue;
	}
	
	private function setAlergia($propValue)
	{
		$this->alergia = $propValue;
	}
	
	private function setApellidoP($propValue)
	{
		$this->apellidoP = $propValue;
	}
	
	private function setApellidoM($propValue)
	{
		$this->apellidoM = $propValue;
	}
	
	private function setDireccion($propValue)
	{
		$this->direccion = $propValue;
	}
	
	private function setTelefono($propValue)
	{
		$this->telefono = $propValue;
	}
	
	private function setFechaPrimeraCita($propValue)
	{
		$this->fechaPrimeraCita=$propValue;
	}
	
	private function setCelular($propValue)
	{
		$this->celular = $propValue;
	}
	
	private function setEmail($propValue)
	{
		$this->email = $propValue;
	}
	
	private function setFechaNac($propValue)
	{
		$this->fechaNac = $propValue;
	}
	
	private function setSexo($propValue)
	{
		$this->sexo = $propValue;
	}
	
	private function setPrevision($propValue)
	{
		$this->prevision = $propValue;
	}
	
	private function setOcupacion($propValue)
	{
		$this->ocupacion = $propValue;
	}
	
	private function setDerivadoPor($propValue)
	{
		$this->derivadoPor = $propValue;
	}
	
	private function setSeguroSalud($propValue)
	{
		$this->seguroSalud = $propValue;
	}
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "run = '$this->run', nombre = '$this->nombre', apellidoP = '$this->apellidoP',";
		$values .= "apellidoM = '$this->apellidoM', direccion = '$this->direccion', telefono = '$this->telefono',";
		$values .= "email = '$this->email', fechaNac = '$this->fechaNac', fechaPrimeraCita = '$this->fechaPrimeraCita',";
		$values .= "sexo = '$this->sexo', celular = '$this->celular', prevision = '$this->prevision',";
		$values .= "ocupacion = '$this->ocupacion', derivadoPor='$this->derivadoPor', alergia = '$this->alergia', seguroSalud = '$this->seguroSalud'";
		$parametros = array("table" => Paciente::TABLA, "values" => "$values", "where" => "idPac_pk = '$this->idPaciente'", "limit" => 1);
		$value=$bd->update($parametros);
		return $values." ".$this->idPaciente;
	}
}
?>
