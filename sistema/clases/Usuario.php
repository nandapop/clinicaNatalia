<?php
// el eliminar solo se puede hacer despues de comprobar que no exista citas asociadas al paciente, es decir la ficha debe estar en blanco
include_once("scripts/conexion.php");

class Usuario
{
	private $idUsuario;
	private $nombre;
	private $apellidoPaterno;
	private $apellidoMaterno;
	private $clave;
	private $categoria;
	
	//Constantes para asignar nombre de tablas y campos de ellas.
	
	const TABLA = 'usuario';
	const CLAVE_PRIMARIA = 'idUsuario_pk';
	const CAMPOS_TABLA = 'idUsuario_pk, nombreUsuario, apellidoPaterno, apellidoMaterno, clave, idCat_fk';
	
	
	//Constructor escribimos las clases ;D
	public function __construct($idUsuario, $nombre, $apellidoPaterno, $apellidoMaterno, $clave, $categoria)
	{
		$this->idUsuario = $idUsuario;
		$this->nombre = $nombre;
		$this->apellidoPaterno = $apellidoPaterno;
		$this->apellidoMaterno = $apellidoMaterno;
		$this->clave = $clave;
		$this->categoria = $categoria;
	}
	
	//se debe retornar un booleano (true o false) si es que inserta correctamente o hay error
	public function insertar()
	{
		$categoria = $this->categoria;
		$values = "'$this->idUsuario', '$this->nombre', '$this->apellidoPaterno', '$this->apellidoMaterno', '$this->clave', '$this->categoria'";
		$bd = new Conexion();
		$parametros = array("table" => Usuario::TABLA, "fields" => Usuario::CAMPOS_TABLA, "values" => "$values");
		return $bd->insert_without_inc($parametros);
	}
	
		// Retorna todos los idUsuarios que existen en un arreglo
	static public function listarUsuarios()
	{
		$bd = new Conexion();
		$parametros = array("table" => Usuario::TABLA, "fields" => Usuario::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$usuarios = array();
		foreach($filas as $fila)
		{
			$categoria = Categoria::obtenerPorId($fila->idCat_fk);
			$usuarios[] = new Usuario($fila->idUsuario_pk, $fila->nombreUsuario, $fila->apellidoPaterno, $fila->apellidoMaterno, $fila->clave, $categoria);
		}
		return $usuarios;
	}
	
	// Retorna un usuario especifico
	static public function obtenerPorId($idUsuario)
	{
		$bd = new Conexion();
		$parametros = array("table" => Usuario::TABLA, "fields" => Usuario::CAMPOS_TABLA, "where" => "idUsuario_pk = '$idUsuario'", "limit" => 1);
		$filas = $bd->select($parametros);
		$usuario = array();
		$categoria = Categoria::obtenerPorId($filas[0]->idCat_fk);
		$usuario = new Usuario($filas[0]->idUsuario_pk, $filas[0]->nombreUsuario, $filas[0]->apellidoPaterno, $filas[0]->apellidoMaterno, $filas[0]->clave, $categoria);
		return $usuario;
	}
	
	// Funcion que comprueba si el usuario existe retorna un valor boolean
	static public function existeIdUsuario($idUsuario)
	{
		$bd = new Conexion();
		$parametros = array("table" => Usuario::TABLA, "fields" => Usuario::CAMPOS_TABLA, "where" => "idUsuario_pk = '$idUsuario'", "limit" => 1);
		$filas = $bd->select($parametros);
		if(count($filas) == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	//Funcion que valida la clave del usuario
	public function validaClave($clave)
	{
		if ($this->clave == $clave)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Usuario::TABLA, "where" => "idUsuario_pk = '$this->idUsuario'", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	public function modificar()
	{
		$categoria = $this->categoria;
		$bd = new Conexion();
		$values =  "nombreUsuario = '$this->nombre', apellidoPaterno = '$this->apellidoPaterno', apellidoMaterno = '$this->apellidoMaterno', clave = '$this->clave', idCat_fk = '$categoria->IdCategoria'";
		$parametros = array("table" => Usuario::TABLA, "values" => "$values", "where" => "idUsuario_pk = '$this->idUsuario'", "limit" => 1);
		return $bd->update($parametros);
	}

	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getIdUsuario()
	{
		return $this->idUsuario;
	}
	
	private function getNombre()
	{
		return $this->nombre;
	}
	
	private function getApellidoMaterno()
	{
		return $this->apellidoMaterno;
	}
	
	private function getApellidoPaterno()
	{
		return $this->apellidoPaterno;
	}
	
	private function getCategoria()
	{
		return $this->categoria;
	}
	
	private function getClave()
	{
		return $this->clave;
	}
	private function getNombreCompleto()
	{
		return $this->nombre . " " . $this->apellidoPaterno;
	}
	// Funciones set para dar valores a los atributos.
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setNombre($propValue)
	{
		$this->nombre = $propValue;
	}
	
	private function setApellidoPaterno($propValue)
	{
		$this->apellidoPaterno = $propValue;
	}
	
	private function setApellidoMaterno($propValue)
	{
		$this->apellidoMaterno = $propValue;
	}
	
	private function setClave($propValue)
	{
		$this->clave = $propValue;
	}
	
	private function setCategoria($propValue)
	{
		$this->categoria = $propValue;
	}
}
?>