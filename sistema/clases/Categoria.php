<?php

include_once("scripts/conexion.php");

class Categoria
{
	private $idCategoria;
	private $nombreCategoria;
	private $descripcion;
	private $privilegios;
	
	//Estas constantes las defino por comodidad, no es obligación que todas las clases
	//estén definidas de la misma forma 
	const TABLA = 'categoriausuario';
	const CLAVE_PRIMARIA = 'idCat_pk';
	const TODOS_CAMPOS = 'idCat_pk, nombreCategoria, descripcion, privilegios';
	const CAMPOS_NOID = 'nombreCategoria, descripcion, privilegios';
	
	//constructor
	
	public function __construct($idCategoria, $nombreCategoria, $descripcion, $privilegios)
	{
		$this->idCategoria = $idCategoria;
		$this->nombreCategoria = $nombreCategoria;
		$this->descripcion = $descripcion;
		$this->privilegios = $privilegios;	
	}
	
	public function insertar()
	{
		$values = "'$this->nombreCategoria', '$this->descripcion', $this->privilegios";
		$bd = new Conexion();
		$parametros = array("table" => Categoria::TABLA, "fields" => Categoria::CAMPOS_NOID, "values" => "$values");
		// Así se obtiene el id autoincremental
		$this->idCategoria = $bd->insert($parametros);
		return $this->idCategoria;
	}
	// Retorna todas las categorias que existen en un arreglo
	static public function listar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Categoria::TABLA, "fields" => Categoria::TODOS_CAMPOS);
		$filas = $bd->select($parametros);
		$categorias = array();
		foreach($filas as $fila)
		{
			$categorias[] = new Categoria($fila->idCat_pk, $fila->nombreCategoria, $fila->descripcion, $fila->privilegios);
		}
		return $categorias;
	}
	
	static public function listarPorPrivilegios($privilegios)
	{
		$bd = new Conexion();
		$parametros = array("table" => Categoria::TABLA, "fields" => Categoria::TODOS_CAMPOS, "where" => "privilegios = $privilegios");
		$filas = $bd->select($parametros);
		$categorias = array();
		foreach($filas as $fila)
		{
			$categorias[] = new Categoria($fila->idCat_pk, $fila->nombreCategoria, $fila->descripcion, $fila->privilegios);
		}
		return $categorias;
	}
	
	// Busca una categoría a partir del id y la retorna, ojo que no comprueba si existe o no así que solo usar con ids conocidos.
	static public function obtenerPorId($idCat)
	{
		$bd = new Conexion();
		$parametros = array("table" => Categoria::TABLA, "fields" => Categoria::TODOS_CAMPOS, "where" => "idCat_pk = $idCat", "limit" => 1);
		$filas = $bd->select($parametros);
		if(count($filas) == 0)
		{
			return false;
		}
		else
		{
			//return true;
			$categoria = new Categoria($filas[0]->idCat_pk, $filas[0]->nombreCategoria, $filas[0]->descripcion, $filas[0]->privilegios);
			return $categoria;
		}
		
	}
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "nombrecategoria = '$this->nombreCategoria', descripcion = '$this->descripcion', privilegios = $this->privilegios";
		$parametros = array("table" => Categoria::TABLA, "values" => "$values", "where" => "idCat_pk = $this->idCategoria", "limit" => 1);
		return $bd->update($parametros);
	}
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Categoria::TABLA, "where" => "idCat_pk = $this->idCategoria", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getIdCategoria()
	{
		return $this->idCategoria;
	}
	
	private function getNombreCategoria()
	{
		return $this->nombreCategoria;
	}
	
	private function getDescripcion()
	{
		return $this->descripcion;
	}
	
	private function getPrivilegios()
	{
		return $this->privilegios;
	}
	
	// Funciones set para dar valores a los atributos.
	
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setNombreCategoria($propValue)
	{
		$this->nombreCategoria = $propValue;
	}
	
	private function setDescripcion($propValue)
	{
		$this->descripcion = $propValue;
	}
	
	private function setPrivilegios($propValue)
	{
		$this->privilegios = $propValue;
	}
}
?>