<?php
include_once("scripts/conexion.php");

class Receta
{
	private $idReceta;	//int
	private $medicamento;	//text
	private $indicaciones;	//text
	private	$idCita;	//int
	
	//Constantes para asignar nombre de tablas y campos de ellas.
	
	const TABLA = 'receta';
	const CLAVE_PRIMARIA = 'idReceta_pk';
	const CAMPOS_TABLA = 'idReceta_pk, medicamento, indicaciones, idCita_fk';
	const CAMPOS_NOID = 'indicaciones, idCita_fk';
	//const CAMPOS_NOID = 'medicamento, indicaciones, idCita_fk';
	function __construct($idReceta, $indicaciones, $idCita)// saque $medicamento
	{
		$this->idReceta = $idReceta;
	//	$this->medicamento = $medicamento;
		$this->indicaciones = $indicaciones;
		$this->idCita = $idCita;
	}
	
		// Se debe retornar un booleano (true o false) si es que inserta correctamente o hay error
	public function insertar()
	{
		//$values = "'$this->medicamento', '$this->indicaciones', $this->idCita";
		$values = "'$this->indicaciones', $this->idCita";
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "fields" => Receta::CAMPOS_NOID, "values" => "$values");
		// Así se obtiene el id autoincremental
		$this->idReceta = $bd->insert($parametros);
		return $this->idReceta;
	}
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "idReceta_pk = $this->idReceta , indicaciones = '$this->indicaciones', idCita_fk = $this->idCita";
		$parametros = array("table" => Receta::TABLA, "values" => "$values", "where" => "idReceta_pk = $this->idReceta", "limit" => 1);
		return $bd->update($parametros);
	}
	
	static public function obtenerRecetaPorId($idReceta)
	{
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "fields" => Receta::CAMPOS_TABLA, "where" => "idReceta_pk = $idReceta", "limit" => 1);
		$filas = $bd->select($parametros);
		$receta = new Receta($filas[0]->idReceta_pk, $filas[0]->indicaciones, $filas[0]->idCita_fk);
		return $receta;
	}
	
	static public function obtenerRecetaPorIdcita($idCita)
	{
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "fields" => Receta::CAMPOS_TABLA, "where" => "idCita_fk = $idCita");
		$filas = $bd->select($parametros);
		$recetas = array();
		foreach($filas as $fila)
		{
			$recetas[] = new Receta($fila->idReceta_pk, $fila->indicaciones, $fila->idCita_fk);
			//$recetas[] = new Receta($fila->idReceta_pk, $fila->medicamento, $fila->indicaciones, $fila->idCita_fk);
		}
		return $recetas;
	}
	
	// Para el autocompletar
	static public function obtenerRecetasAutocompletar($texto)
	{
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "fields" => "indicaciones", "where" => ("indicaciones LIKE '$texto"."%'"), "order_by" => "indicaciones asc");
		$filas = $bd->selectDistinct($parametros);
		$recetas = array();
		foreach($filas as $fila)
		{
			$recetas[] = new Receta(0, $fila->indicaciones, 0);
		}
		return $recetas;
	}
	
	static public function listarRecetas()
	{
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "fields" => Receta::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$TodasRecetas = array();
		foreach($filas as $fila)
		{	
																																	 												 
			$TodasRecetas[] = new Receta($fila->idReceta_pk,$fila->indicaciones, $fila->idCita_fk);
		}
		return $TodasRecetas;
	
	}
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Receta::TABLA, "where" => "idReceta_pk = $this->idReceta and idCita_fk = $this->idCita", "limit" => 1);
		return $bd->delete($parametros);
	
	}
	
		// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getIdReceta()
	{
		return $this->idReceta;
	}
	
	private function getIndicaciones()
	{
		return $this->indicaciones;
	}
	
	private function getIdCita()
	{
		return $this->idCita;
	}
	
	// Funciones set para dar valores a los atributos.

	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setIdReceta($propValue)
	{
		$this->idReceta = $propValue;
	}
	
	private function setIndicaciones($propValue)
	{
		$this->indicaciones = $propValue;
	}
	
	private function setIdCita($propValue)
	{
		$this->idCita = $propValue;
	}
}

?>
