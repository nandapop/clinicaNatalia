<?php
include_once("scripts/conexion.php");

class RecetaFrecuente
{
	private $receta; //text
	private $id;

	const TABLA = 'recetaFrecuente';
	const CLAVE_PRIMARIA = 'id_pk';
	const CAMPOS_TABLA = 'id_pk, receta';
	const CAMPOS_NOID = 'receta';
	
	// Constructor escribimos las clases ;D
	public function __construct($id = 0, $receta = "")
	{
		$this->id = $id;
		$this->receta = $receta;
	}
	
	public function insertar()
	{
		$values = "'$this->receta'";
		$bd = new Conexion();
		$parametros = array("table" => RecetaFrecuente::TABLA, "fields" => RecetaFrecuente::CAMPOS_NOID, "values" => "$values");
		$this->id = $bd->insert($parametros);
		return $this->id;
	}	
	
	static public function listar()
	{
		$bd = new Conexion();
		$parametros = array("table" => RecetaFrecuente::TABLA, "fields" => RecetaFrecuente::CAMPOS_TABLA, "order_by" => "receta ASC");
		$filas = $bd->select($parametros);
		$recetas = array();
		foreach($filas as $fila)
		{
			$recetas[] = new RecetaFrecuente($fila->id_pk, $fila->receta);
		}
		return $recetas;
	}	
		
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => RecetaFrecuente::TABLA, "where" => "id_pk = $this->id", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	static public function obtener($id)
	{
		$bd = new Conexion();
		$parametros = array("table" => RecetaFrecuente::TABLA, "fields" => RecetaFrecuente::CAMPOS_TABLA, "where" => "id_pk = $id", "limit" => 1);
		$filas = $bd->select($parametros);
		$receta = new RecetaFrecuente($filas[0]->id_pk, $filas[0]->receta);
		return $receta;
	}
	
	static public function obtenerRecetasAutocompletar($texto)
	{
		$bd = new Conexion();
		$parametros = array("table" => RecetaFrecuente::TABLA, "fields" => "receta", "where" => ("receta LIKE '$texto"."%'"), "order_by" => "receta asc");
		$filas = $bd->selectDistinct($parametros);
		$recetas = array();
		foreach($filas as $fila)
		{
			$recetas[] = new RecetaFrecuente(0, $fila->receta);
		}
		return $recetas;
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getReceta()
	{
		return $this->receta;
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
	
	private function setReceta($propValue)
	{
		$this->receta = $propValue;
	}
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "receta = '$this->receta'";
		$parametros = array("table" => RecetaFrecuente::TABLA, "values" => "$values", "where" => "id_pk = '$this->id'", "limit" => 1);
		$value=$bd->update($parametros);
		return $values." ".$this->id;
	}
}
?>