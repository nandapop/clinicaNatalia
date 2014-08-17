<?php
include_once("scripts/conexion.php");
require_once("tipoEx.php");

class exLab extends tipoEx
{
	private $idCita; 	//int
	private $idTipo;	//int
	private $comentario;	//text
	
	//Constantes para asignar nombre de tablas y campos de ellas.
	
	const TABLA = 'exlab';
	const CAMPOS_TABLA = 'idCita_pk_fk, idTipo_pk_fk, comentario';
	
	function __construct($idCita,$idTipo,$comentario)
	{
		$this->idCita = $idCita;
		$this->idTipo =	$idTipo;
		$this->comentario = $comentario;
	}
	
	public function insertar()
	{
		$values = "'$this->idCita', '$this->idTipo', '$this->comentario'";
		$bd = new Conexion();
		$parametros = array("table" => exLab::TABLA, "fields" => exLab::CAMPOS_TABLA, "values" => "$values");
		return $bd->insert_without_inc($parametros);
	}
	
	public function comprobarExamenGuardado()
	{
		$bd = new Conexion();
		$parametros = array("table" => exLab::TABLA,"fields" =>exLab::CAMPOS_TABLA, "where" => "idTipo_pk_fk = $this->idTipo and idCita_pk_fk = $this->idCita", "limit" => 1);
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
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => exLab::TABLA, "where" => "idTipo_pk_fk = $this->idTipo and idCita_pk_fk = $this->idCita", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	static public function obtenerExLabPorIdCita($idCita)
	{
		$bd = new Conexion();
		$parametros = array("table" => exLab::TABLA, "fields" => exLab::CAMPOS_TABLA, "where" => "idCita_pk_fk = $idCita");
		$filas = $bd->select($parametros);
		$examenes = array();
		foreach($filas as $fila)
		{
			$examenes[] = new exLab($fila->idCita_pk_fk, $fila->idTipo_pk_fk, $fila->comentario);
		}
		return $examenes;
	}
	
	static public function listarExLab()
	{
		$bd = new Conexion();
		$parametros = array("table" => exLab::TABLA, "fields" => exLab::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$listarExLaboratorios = array();
		foreach ($filas as $fila)
		{
			$listarExLaboratorios[] = new exLab($fila->idCita_pk_fk, $fila->idTipo_pk_fk, $fila->comentario);
		}
		return $listarExLaboratorios;
	
	}
	
	public function __get($attr)
    {
        $functionName  = "get".$attr;
        return $this->$functionName();
    }
	
	private function getIdTipo()
	{
		return $this->idTipo;
	}
	
	private function getIdCita()
	{
		return $this->idCita;
	}
	
	private function getComentario()
	{
		return $this->comentario;
	}
}
?>