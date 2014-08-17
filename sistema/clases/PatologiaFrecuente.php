<?php
include_once("scripts/conexion.php");

class PatologiaFrecuente
{
	private $patologia; //text
	private $id;

	const TABLA = 'patologias';
	const CLAVE_PRIMARIA = 'id_pk';
	const CAMPOS_TABLA = 'id_pk, patologia';
	const CAMPOS_NOID = 'patologia';
	
	// Constructor escribimos las clases ;D
	public function __construct($id = 0, $patologia = "")
	{
		$this->id = $id;
		$this->patologia = $patologia;
	}
	
	public function insertar()
	{
		$values = "'$this->patologia'";
		$bd = new Conexion();
		$parametros = array("table" => PatologiaFrecuente::TABLA, "fields" => PatologiaFrecuente::CAMPOS_NOID, "values" => "$values");
		$this->id = $bd->insert($parametros);
		return $this->id;
	}	
	
	static public function listar()
	{
		$bd = new Conexion();
		$parametros = array("table" => PatologiaFrecuente::TABLA, "fields" => PatologiaFrecuente::CAMPOS_TABLA, "order_by" => "patologia ASC");
		$filas = $bd->select($parametros);
		$patologia = array();
		foreach($filas as $fila)
		{
			$patologia[] = new PatologiaFrecuente($fila->id_pk, $fila->patologia);
		}
		return $patologia;
	}	
		
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => PatologiaFrecuente::TABLA, "where" => "id_pk = $this->id", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	static public function obtener($id)
	{
		$bd = new Conexion();
		$parametros = array("table" => PatologiaFrecuente::TABLA, "fields" => PatologiaFrecuente::CAMPOS_TABLA, "where" => "id_pk = $id", "limit" => 1);
		$filas = $bd->select($parametros);
		$patologia = new PatologiaFrecuente($filas[0]->id_pk, $filas[0]->patologia);
		return $patologia;
	}
	
	static public function obtenerPatologiaAutocompletar($texto)
	{
		$bd = new Conexion();
		$parametros = array("table" => PatologiaFrecuente::TABLA, "fields" => "patologia", "where" => ("patologia LIKE '$texto"."%'"), "order_by" => "patologia asc");
		$filas = $bd->selectDistinct($parametros);
		$patologia = array();
		foreach($filas as $fila)
		{
			$patologia[] = new PatologiaFrecuente(0, $fila->patologia);
		}
		return $patologia;
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getPatologia()
	{
		return $this->patologia;
	}
	
	private function getId()
	{
		return $this->id;
	}
	
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setPatologia($propValue)
	{
		$this->patologia = $propValue;
	}
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "patologia = '$this->patologia'";
		$parametros = array("table" => PatologiaFrecuente::TABLA, "values" => "$values", "where" => "id_pk = '$this->id'", "limit" => 1);
		$value=$bd->update($parametros);
		return $values." ".$this->id;
	}
}
?>