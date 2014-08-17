<?php
include_once("scripts/conexion.php");
class Alergia
{
	private $idAlergia;
	private $nombreAlergia;
	private $descripcion;
	
	const TABLA = "alergia";
	const CLAVE_PRIMARIA = "idAlergia_pk";
	
	function __construct($idAlergia=0,$nombreAlergia="", $descripcion="")
	{
		$this->idAlergia=$idAlergia;
		$this->nombreAlergia=$nombreAlergia;
		$this->descripcion=$descripcion;
	}
	
	public function insertar()
	{
		$values = "'$this->nombreAlergia', '$this->descripcion'";
		$bd = new Conexion();
		$parametros = array("table" => Alergia::TABLA, "fields" => "nombreAlergia,descripcion", "values" => "$values");
		$this->idAlergia = $bd->insert($parametros);
		return $this->idAlergia;
	}
	
	public function listarAlergias()
	{
		$bd = new Conexion();
		$parametros = array("table" => Alergia::TABLA, "fields" => "idAlergia_pk,nombreAlergia,descripcion");
		$filas = $bd->select($parametros);
		$alergias = array();
		foreach($filas as $fila)
		{
			$alergias[] = new Alergia($fila->idAlergia_pk, $fila->nombreAlergia, $fila->descripcion);
		}
		return $alergias;
	}
	
	public function obtenerAlergiaId($idAle)
	{
		$bd = new Conexion();
		$parametros = array("table" => Alergia::TABLA, "fields" => "idAlergia_pk,nombreAlergia,descripcion","where"=>"idAlergia_pk='$idAle'");
		$filas = $bd->select($parametros);
		$alergia = new Alergia($filas[0]->idAlergia_pk, $filas[0]->nombreAlergia, $filas[0]->descripcion);
		return $alergia;
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
	
	private function getIdAlergia()
	{
		return $this->idAlergia;
	}
	
	private function getNombreAlergia()
	{
		return $this->nombreAlergia;
	}
	
	private function getDescripcion()
	{
		return $this->descripcion;
	}
	
	// Funciones set para dar valores a los atributos.
	
	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setNombreAlergia($propValue)
	{
		$this->nombreAlergia = $propValue;
	}
	
	private function setDescripcion($propValue)
	{
		$this->descripcion = $propValue;
	}
	
	
}
?>
