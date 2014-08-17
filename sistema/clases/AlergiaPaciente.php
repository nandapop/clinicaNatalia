<?php

include_once("scripts/conexion.php");
class AlergiaPaciente
{
	private $idAlergia;
	private $idPaciente;
	private $comentario;
	
	const TABLA = "alergiapaciente";
	const TODOS_CAMPOS = "idAlergia_pk_fk, idPac_pk_fk, comentarios";
	
	public function __construct($idPaciente="", $idAlergia="", $comentario="")
	{
		$this->idPaciente=$idPaciente;
		$this->idAlergia=$idAlergia;
		$this->comentario=$comentario;
	}
	
	public function insertar()
	{
		$values = "'$this->idAlergia', '$this->idPaciente', '$this->comentario'";
		$bd = new Conexion();
		$parametros = array("table" => AlergiaPaciente::TABLA, "fields" => AlergiaPaciente::TODOS_CAMPOS, "values" => "$values");
		$bd->insert($parametros);
	}
	
	public function existe()
	{
		$bd = new Conexion();
		$parametros = array("table"=>AlergiaPaciente::TABLA,"fields"=>"*","where"=>"idPac_pk_fk='$this->idPaciente' AND idAlergia_pk_fk='$this->idAlergia'");
		$filas=$bd->select($parametros);
		if($filas!=0)
			return true;
		else
			return false;
	}
	
	public function actualizar()
	{
		$bd = new Conexion();
		$parametros = array("table"=>AlergiaPaciente::TABLA,"values"=>"comentarios='$this->comentario'","where"=>"idPac_pk_fk='$this->idPaciente' AND idAlergia_pk_fk='$this->idAlergia'");
		return $bd->update($parametros);

	}
	
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table"=>AlergiaPaciente::TABLA,"where"=>"idPac_pk_fk='$this->idPaciente' AND idAlergia_pk_fk='$this->idAlergia'");
		return $bd->delete($parametros);
	}
	
	public function listarAlergiaPaciente($idPaciente)
	{
		$bd = new Conexion();
		$parametros = array("table"=>AlergiaPaciente::TABLA,"fields" => "*", "where" => "idPac_pk_fk = '$idPaciente'");
		$filas = $bd->select($parametros);
		$alergiaPac = array();
		foreach($filas as $fila)
		{
			$alergiaPac[] = new AlergiaPaciente($fila->idPac_pk_fk, $fila->idAlergia_pk_fk, $fila->comentarios);
		}
		return $alergiaPac;
	}
	
	public function listarTodasAlergiasPacientes()
	{
		$bd = new Conexion();
		$parametros = array("table" => AlergiaPaciente::TABLA, "fields" => AlergiaPaciente::TODOS_CAMPOS);
		$filas = $bd->select($parametros);
		$listarTodasAlergias = array();
		foreach($filas as $fila)
			{
				$listarTodasAlergias[] = new AlergiaPaciente($fila->idPac_pk_fk, $fila->idAlergia_pk_fk, $fila->comentarios);  
			}
		return $listarTodasAlergias;
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
	
	private function getIdPaciente()
	{
		return $this->idPaciente;
	}
	
	private function getComentario()
	{
		return $this->comentario;
	}
	
}