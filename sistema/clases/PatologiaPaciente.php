<?php
include_once("scripts/conexion.php");

class PatologiaPaciente
{
	private $idPatologia;
	private $idPaciente;
	
	const TABLA = "patologiapaciente";
	const TODOS_CAMPOS = "id_pk_fk, idPac_pk_fk";
	
	public function __construct($idPatologia="", $idPaciente="")
	{
		$this->idPaciente=$idPaciente;
		$this->idPatologia=$idPatologia;
	}
	
	public function insertar()
	{
		$values = "'$this->idPatologia', '$this->idPaciente'";
		$bd = new Conexion();
		$parametros = array("table" => PatologiaPaciente::TABLA, "fields" => PatologiaPaciente::TODOS_CAMPOS, "values" => "$values");
		$bd->insert($parametros);
	}
	
	public function existe()
	{
		$bd = new Conexion();
		$parametros = array("table"=>PatologiaPaciente::TABLA,"fields"=>"*","where"=>"idPac_pk_fk='$this->idPaciente' AND id_pk_fk='$this->idPatologia'");
		$filas=$bd->select($parametros);
		if($filas!=0)
			return true;
		else
			return false;
	}
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table"=>PatologiaPaciente::TABLA,"where"=>"idPac_pk_fk='$this->idPaciente' AND id_pk_fk='$this->idPatologia'");
		return $bd->delete($parametros);
	}
	
	public function listarPatologiaPaciente($idPaciente)
	{
		$bd = new Conexion();
		$parametros = array("table"=>PatologiaPaciente::TABLA,"fields" => "*", "where" => "idPac_pk_fk = '$idPaciente'");
		$filas = $bd->select($parametros);
		$patologiaPac = array();
		foreach($filas as $fila)
		{
			$patologiaPac[] = new PatologiaPaciente($fila->id_pk_fk, $fila->idPac_pk_fk);
		}
		return $patologiaPac;
	}
	
	//Obtener los pacientes a partir de una patologia
	public function listarPorIdPatologia($idPatologia)
	{
		$bd = new Conexion();
		$parametros = array("table"=>PatologiaPaciente::TABLA,"fields" => "*", "where" => "id_pk_fk = '$idPatologia'");
		$filas = $bd->select($parametros);
		$patologiaPac = array();
		foreach($filas as $fila)
		{
			$patologiaPac[] = new PatologiaPaciente($fila->id_pk_fk, $fila->idPac_pk_fk);
		}
		return $patologiaPac;
	}
	
	public function listarTodasPatologiasPacientes()
	{
		$bd = new Conexion();
		$parametros = array("table" => PatologiaPaciente::TABLA, "fields" => PatologiaPaciente::TODOS_CAMPOS);
		$filas = $bd->select($parametros);
		$listarTodasPatologiasPacientes = array();
		foreach($filas as $fila)
			{
				$listarTodasPatologiasPacientes[] = new PatologiaPaciente($fila->id_pk_fk, $fila->idPac_pk_fk);
			}
		return $listarTodasPatologiasPacientes;
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
    {
        $functionName  = "get".$attr;
        return $this->$functionName();
    }
	
	private function getId()
	{
		return $this->idPatologia;
	}
	
	private function getIdPaciente()
	{
		return $this->idPaciente;
	}
	
}