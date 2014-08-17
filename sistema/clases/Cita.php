<?php

include_once("scripts/conexion.php");

class Cita
{
	private $idCita;			// int
	private $idPaciente;		// int
	private $estado;			// int
	private $fechaCita;			// datetime
	private $tipoCita;			// int
	private $diagnosticoCita;	// text
	private $horaLlegada;		// datetime
	private $pagado;  			// varchar
	private $atencion;			// int
	private $consulta;			// int

	//atencion: 1 ->Salima
	//atencion: 2 ->Dra Fuentes
	//atencion: 3 ->Otro
	
	//tipoCita: 1 ->Consulta
	//tipoCita: 2 ->Pabellon
	//tipoCita: 3 ->Skin
	
	//consulta: 0 ->Valparaíso
	//consulta: 1 ->Viña del mar
	//consulta: -1 ->Agregado desde historial
	//Constantes para asignar nombre de tablas y campos de ellas.
	
	const TABLA = 'cita';
	const CLAVE_PRIMARIA = 'idCita_pk';
	const CAMPOS_TABLA = 'idCita_pk, idPac_fk, estado, fechaCita, tipoCita, diagnosticoCita, horaLlegada, pagado, atencion, consulta';
	const CAMPOS_NOID = 'idPac_fk, estado, fechaCita, tipoCita, diagnosticoCita, horaLlegada, pagado, atencion, consulta';
	
	
	// Constructor escribimos las clases ;D
	public function __construct($idCita = 0, $idPaciente = 0, $estado = 0, $fechaCita = "", $tipoCita = 0, $diagnosticoCita = "", $horaLlegada = "", $pagado = "", $atencion = 0, $consulta = 0)
	{
		$this->idCita = $idCita;
		$this->idPaciente = $idPaciente;
		$this->estado = $estado;
		$this->fechaCita = $fechaCita;
		$this->tipoCita = $tipoCita;
		$this->diagnosticoCita = $diagnosticoCita;
		$this->horaLlegada = $horaLlegada;
		$this->pagado = $pagado;
		$this->atencion = $atencion;
		$this->consulta = $consulta;
	}
	
	// Se debe retornar un booleano (true o false) si es que inserta correctamente o hay error
	public function insertar()
	{
		$values = "'$this->idPaciente', '$this->estado', '$this->fechaCita', '$this->tipoCita', '$this->diagnosticoCita', '$this->horaLlegada', '$this->pagado', '$this->atencion', '$this->consulta'";
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_NOID, "values" => "$values");
		// Así se obtiene el id autoincremental
		$this->idCita = $bd->insert($parametros);
		return $this->idCita;
	}
	
	// Retorna todas las citas que existen en un arreglo. (Esta será la tabla con mayor crecimiento
	// y un listado completo no es práctico más que para pruebas así que esta función no se debería usar).
	static public function listar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA);
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	// ESTADO 0: INICIAL
	// ESTADO 1: NO HA LLEGADO - PERO ESTA CONFIRMADO
	// ESTADO 2: EN SALA
	// ESTADO 3: ATENDIDO
	// ESTADO 4: NO CONTESTA 
	// ESTADO 5: YA FUE AVISADO
	static public function listarPorEstado($estado)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "estado = $estado");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	static public function listarPorFecha($fecha)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "fechaCita = '$fecha'");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	static public function listarRangoFecha($fechaInicial, $fechaFinal, $consulta)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA,"fields" => Cita::CAMPOS_TABLA, "where" => "consulta = '$consulta' and (fechaCita between '$fechaInicial' and '$fechaFinal') order by fechaCita ASC");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	
	}
	
	// Retorna todas las citas para un determinado paciente que tengan el estado solicitado.
	static public function listarPorEstadoyPaciente($estado, $idPaciente)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "estado = $estado and idPac_fk = $idPaciente order by fechaCita desc");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	static public function listarPorIdPaciente($idPaciente)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "idPac_fk = $idPaciente order by fechaCita desc");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	// Retorna la lista con las citas de los pacientes que están esperando en la sala.
	static public function listarCitasEsperando()
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "estado = 2 or estado = 5 and atencion = 1  order by horaLlegada asc");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	/* Funcion para guardar las nuevas fichas!
	public function obtenerCitaIdFecha($idPaciente,$fecha)
	{

	}*/
	
	// Retorna la lista con las citas de los pacientes que están esperando en la sala y que aun no son avisados
	static public function listarNuevasCitasEsperando()
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "estado = 2 order by horaLlegada asc");
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	// Busca una cita a partir del id y la retorna, ojo que no comprueba si existe o no así que solo usar con ids conocidos.
	static public function obtenerPorId($idCita)
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "idCita_pk = $idCita", "limit" => 1);
		$filas = $bd->select($parametros);
		$cita = new Cita($filas[0]->idCita_pk, $filas[0]->idPac_fk, $filas[0]->estado, $filas[0]->fechaCita, $filas[0]->tipoCita, $filas[0]->diagnosticoCita, $filas[0]->horaLlegada, $filas[0]->pagado, $filas[0]->atencion, $filas[0]->consulta);
		return $cita;
	}
	
	//Obtiene la proxima cita del paciente
	static public function obtenerProximaCitaPorPaciente($idPaciente)
	{
		$hora = date("Y-m-d H:i:s");
		list($ano,$mes,$resto)=split("-",$hora); 
		list($dia, $horas)=split(" ",$resto); 
		list($hora,$min,$seg)=split(":",$horas); 
		$hora += 2;
		if($hora > 23)
		{
			$hora = $hora-24;
		}	
		$ahora = "'$ano-$mes-$dia $hora:$min:$seg'";
		
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "idPac_fk = $idPaciente and fechaCita > $ahora order by fechaCita asc limit 1");
	
		$filas = $bd->select($parametros);
		$citas = array();
		foreach($filas as $fila)
		{
			$citas[] = new Cita($fila->idCita_pk, $fila->idPac_fk, $fila->estado, $fila->fechaCita, $fila->tipoCita, $fila->diagnosticoCita, $fila->horaLlegada, $fila->pagado, $fila->atencion, $fila->consulta);
		}
		return $citas;
	}
	
	// Guarda los cambios en la base de datos.
	
	public function modificar()
	{
		$bd = new Conexion();
		$values = "idCita_pk = $this->idCita , idPac_fk = $this->idPaciente, estado = $this->estado, fechaCita = '$this->fechaCita', tipoCita = $this->tipoCita, diagnosticoCita = '$this->diagnosticoCita', horaLlegada = '$this->horaLlegada', pagado = '$this->pagado', atencion = '$this->atencion', consulta = '$this->consulta'";
		$parametros = array("table" => Cita::TABLA, "values" => "$values", "where" => "idCita_pk = $this->idCita", "limit" => 1);
		return $bd->update($parametros);
	}
	
	// Elimina (Cancela) una cita pedida.
	public function eliminar()
	{
		$bd = new Conexion();
		$parametros = array("table" => Cita::TABLA, "where" => "idCita_pk = $this->idCita", "limit" => 1);
		return $bd->delete($parametros);
	}
	
	public function eliminarCita($idCita)
	{
		$CitaaEliminar=Cita::obtenerPorId($idCita);	
		if($CitaaEliminar->diagnosticoCita!="")
			return "0";
		else
		{
			$bd = new Conexion();
			$parametros = array("table" => Cita::TABLA, "where" => "idCita_pk = $idCita", "limit" => 1);
			return $bd->delete($parametros);
		}
	}
	
	
	
	// Cambiar el estado de la cita
	public function cambiarEstado($idCita, $estado)
	{
		$bd=new Conexion();
		$values="estado = '$estado'";
		$parametros=array("table" => Cita::TABLA, "values" => "$values", "where" => "idCita_pk = $idCita");
		
		return $bd->update($parametros);
	}
	
	public function actualizarPago($idCita, $pagado)
	{
		$bd=new Conexion();
		$values= "pagado = '$pagado'";
		$parametros=array("table"=>Cita::TABLA, "values"=>"$values","where"=>"idCita_pk=$idCita");
		
		return $bd->update($parametros);
	}
	
	public function buscarPrimeraCita($idPaciente)
	{
		$bd=new Conexion();
		$parametros = array("table" => Cita::TABLA, "fields" => Cita::CAMPOS_TABLA, "where" => "idPac_fk = $idPaciente","order_by" => "fechaCita ASC", "limit" => 1);
		$filas = $bd->select($parametros);
		$cita = new Cita($filas[0]->idCita_pk, $filas[0]->idPac_fk, $filas[0]->estado, $filas[0]->fechaCita, $filas[0]->tipoCita, $filas[0]->diagnosticoCita, $filas[0]->horaLlegada, $filas[0]->pagado, $filas[0]->atencion, $filas[0]->consulta);
		return $cita;
	}
	
	public function cambiarHoraLlegada($idCita, $hora)
	{
		$bd = new Conexion();
		$values="horaLlegada = '$hora'";
		$parametros = array("table"=>Cita::TABLA, "values"=>"$values", "where"=>"idCita_pk=$idCita");
		
		return $bd->update($parametros);
	}
	
	// Funciones get para obtener los atributos.
	public function __get($attr)
	{
		$functionName  = "get".$attr;
		return $this->$functionName();
	}
	
	private function getIdCita()
	{
		return $this->idCita;
	}
	
	private function getIdPaciente()
	{
		return $this->idPaciente;
	}
	
	private function getEstado()
	{
		return $this->estado;
	}
	
	private function getFechaCita()
	{
		return $this->fechaCita;
	}
	
	private function getSoloFecha()
	{
		list($fecha, $hora) = split(' ', $this->fechaCita);
		return $fecha;
	}
	
	private function getTipoCita()
	{
		return $this->tipoCita;
	}
	
	private function getDiagnosticoCita()
	{
		return $this->diagnosticoCita;
	}
	
	private function getHoraLlegada()
	{
		return $this->horaLlegada;
	}
	
	private function getPagado()
	{
		return $this->pagado;
	}
	
	private function getAtencion()
	{
		return $this->atencion;
	}
	
	private function getConsulta()
	{
		return $this->consulta;
	}
	// Funciones set para dar valores a los atributos.

	public function __set($propName, $propValue)
	{
		$functionName = "set".$propName;
		$this->$functionName($propValue);
	}
	
	private function setEstado($propValue)
	{
		$this->estado = $propValue;
	}
	
	private function setDiagnosticoCita($propValue)
	{
		$this->diagnosticoCita = $propValue;
		// Significa que fue atendido
		$this->estado = 3;
	}
	
	private function setTipoCita($propValue)
	{
		$this->tipoCita = $propValue;
	}
	
	private function setHoraLlegada($propValue)
	{
		$this->horaLlegada = $propValue;
	}
	
	private function setPagado($propValue)
	{
		$this->pagado = $propValue;
	}
	
	private function setAtencion($propValue)
	{
		$this->atencion = $propValue;
	}
	
	private function setFechaCita($propValue)
	{
		$this->fechaCita = $propValue;
	}
}
?>
