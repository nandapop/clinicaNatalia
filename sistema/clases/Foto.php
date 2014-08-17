<?php
include_once("scripts/conexion.php");
// Se utiliza el idFoto como nombre para relacionar la fila con el archivo fisico
class Foto
{
	private $idFoto;		// int
	private $idCita;		// int
	private $comentario;	// varchar
	
	const TABLA = 'foto';
	const CLAVE_PRIMARIA = 'idFoto_pk';
	const CAMPOS_TABLA = 'idFoto_pk, idCita_fk, comentarioArchivo';
	const CAMPOS_NOID = 'idCita_fk, comentarioArchivo';
	
	public function __construct($idFoto, $idCita, $comentario)
	{
		$this->idFoto = $idFoto;
		$this->idCita = $idCita;
		$this->comentario = $comentario;
	}
	
	// Se debe retornar un boolean (true o false) si es que se inserta correctamente o no.
	public function insertar()
	{
		$values = "$this->idCita, '$this->comentario'";
		$bd = new Conexion();
		$parametros = array("table" => Foto::TABLA, "fields" => Foto::CAMPOS_NOID, "values" => "$values");
		// Así se obtiene el id autoincremental
		$this->idFoto = $bd->insert($parametros);
		return ($this->idFoto <= 0)?false:true;
	}
	
	// Funcion que retorna un listado con las fotografias de una cita.
	static public function obtenerFotosPorIdcita($idCita)
	{
		$bd = new Conexion();
		$parametros = array("table" => Foto::TABLA, "fields" => Foto::CAMPOS_TABLA, "where" => "idCita_fk = $idCita");
		$filas = $bd->select($parametros);
		$fotos = array();
		foreach($filas as $fila)
		{
			$fotos[] = new Foto($fila->idFoto_pk, $fila->idCita_fk, $fila->comentarioArchivo);
		}
		return $fotos;
	}
	
	static public function listarFotos()
	{
		$bd = new Conexion();
		$parametros = array("table" => Foto::TABLA, "fields" => Foto::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$listarFotos = array();
		foreach ($filas as $fila)
		{
			$listarFotos[] = new Foto($fila->idFoto_pk, $fila->idCita_fk, $fila->comentarioArchivo);
		}
		return $listarFotos;
	
	}
	// Retorna 1 si elimina correctamente 0 en caso contrario.
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Foto::TABLA, "where" => "idFoto_pk = $this->idFoto", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getIdFoto()
	{
		return $this->idFoto;
	}
	
	private function getIdCita()
	{
		return $this->idCita;
	}
	
	private function getDescripcion()
	{
		return $this->comentario;
	}
	
	// Funcion para obtener el src del thumbnail de la foto.
	private function getMiniatura()
	{
		$ruta = "fotos/miniatura.php?ruta=" . $this->idFoto . ".jpg";
		return $ruta;
	}
	
	// Funcion para obtener el src de la imagen.
	private function getImagen()
	{
		return "fotos/" . $this->idFoto . ".jpg";
	}
	// Funciones set para obtener los atributos.
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setIdCita($propValue)
	{
		$this->idCita = $propValue;
	}
	
	private function setDescripcion($propValue)
	{
		$this->comentario = $propValue;
	}
}
?>