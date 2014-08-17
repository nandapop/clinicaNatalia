<?php
include_once("scripts/conexion.php");

class tipoEx
{
	private $idTipo;
	private $nombre;
	private $descripcion;
	private $estado;	
	
	const TABLA = 'tipoex';
	const CLAVE_PRIMARIA = 'idTipo_pk';
	const TODOS_CAMPOS = 'idTipo_pk, nombre, descripcion, estado';
	const CAMPOS_NOID = 'nombre, descripcion, estado';
	
	
	function __construct($idTipo, $nombre, $descripcion, $estado)
	{
		$this->idTipo=$idTipo;
		$this->nombre=$nombre;
		$this->descripcion=$descripcion;
		$this->estado=$estado;
	}
	
	static public function buscarPorNombre($nombre)
	{
		$bd = new Conexion();
		$parametros = array ("table" => tipoEx::TABLA, "fields" => TODOS_CAMPOS, "where" => "nombre ='".$nombre."'");
		$filas = $bd->select($parametros);
		echo $filas;
		return count($filas);
	}
	
	static public function listarPorEstado($estado)
	{
		$bd = new Conexion();
		$parametros = array("table" => tipoEx::TABLA, "fields" => tipoEx::TODOS_CAMPOS, "where" => "estado = '".$estado."'");
		$filas = $bd->select($parametros);
		$tipoExamenes = array();
		foreach($filas as $fila)
		{
			$tipoExamenes[] = new tipoEx($fila->idTipo_pk, $fila->nombre, $fila->descripcion, $fila->estado);
		}
		return $tipoExamenes;
	}
	
	static public function listarPorEstadoDescripcion($estado, $descripcion)
	{
		$bd = new Conexion();
		$parametros = array("table" => tipoEx::TABLA, "fields" => tipoEx::TODOS_CAMPOS, "where" => "estado = '".$estado."'" . " and descripcion = '" . $descripcion . "'");
		$filas = $bd->select($parametros);
		$tipoExamenes = array();
		foreach($filas as $fila)
		{
			$tipoExamenes[] = new tipoEx($fila->idTipo_pk, $fila->nombre, $fila->descripcion, $fila->estado);
		}
		return $tipoExamenes;
	}
	
	static public function listarDescripciones($estado)
	{
		$bd = new Conexion();
		$parametros = array("table" => tipoEx::TABLA, "fields" => tipoEx::TODOS_CAMPOS, "where" => "estado = '".$estado."'", "group_by" =>  "descripcion");
		$filas = $bd->select($parametros);
		$tipoExamenes = array();
		foreach($filas as $fila)
		{
			$tipoExamenes[] = new tipoEx($fila->idTipo_pk, $fila->nombre, $fila->descripcion, $fila->estado);
		}
		return $tipoExamenes;
	}
	
	static public function listarTodasDescripciones()
	{
		$bd = new Conexion();
		$parametros = array("table" => tipoEx::TABLA, "fields" => tipoEx::TODOS_CAMPOS);
		$filas = $bd->select($parametros);
		$listarTodasDescripciones = array();
		foreach ($filas as $fila)
		{
			$listarTodasDescripciones[] = new tipoEx($fila->idTipo_pk, $fila->nombre, $fila->descripcion, $fila->estado);
		}
		return $listarTodasDescripciones;
	}
	
	public function eliminar($id)
	{
	 $bd = new Conexion();
	 $parametros = array("table"=> tipoEx::TABLA, "values"=> "estado = 'inactivo'", "where"=> "idTipo_pk = '".$id."'");
	 $filas = $bd->update($parametros);
	 return $filas;
	//	 if ($filas != 0)
	// 	echo "Se ha eliminado el examen de id = $id";
	}
	public function insertar($nombre, $descripcion, $estado)
	{
		$bd = new Conexion();
		$parametros = array("table"=>tipoEx::TABLA, "fields" => tipoEx::CAMPOS_NOID, "values"=> "'" .$nombre. "','" .$descripcion. "','" .$estado. "'");
		$filas = $bd->insert($parametros);
		return $filas;
		//if ($filas != -1)
	 	//	echo "Se ha insertado un examen";
	}
	
	static public function obtenerExamenPorId($idTipo)
	{
		$bd = new Conexion();
		$parametros = array("table" => tipoEx::TABLA, "fields" => tipoEx::TODOS_CAMPOS, "where" => "idTipo_pk = $idTipo", "limit" => 1);
		$filas = $bd->select($parametros);
		$examenId = new tipoEx($filas[0]->idTipo_pk, $filas[0]->nombre, $filas[0]->descripcion, $filas[0]->estado);
		return $examenId;
	}
	
	public function __get($attr)
    {
        $functionName  = "get".$attr;
        return $this->$functionName();
    }
	
	private function getNombre()
	{
		return $this->nombre;
	}
	private function getDescripcion()
	{
		return $this->descripcion;
	}
	private function getIdTipo()
	{
		return $this->idTipo;
	}
	private function getEstado()
	{
		return $this->estado;
	}
}

?>