<?php
$privilegiosPagina = 2;
include("seguridad.php");
include_once("clases/exLab.php");
$idCita = $_POST["idCita"];
$idTipos = $_POST["idTipos"];
$idTiposNoTickeados = $_POST["idTiposNoTickeados"];
$cantInsertados = 0;
$cantErrores = 0;
if(count($idTipos) != 0)
{
	foreach($idTipos as $idTipo)
	{
		$examenLab = new exLab($idCita, $idTipo, "");
		if (!$examenLab->comprobarExamenGuardado())
		{
			$examenLab->insertar();
		}
	}
}

if(count($idTiposNoTickeados) != 0)
{
	foreach($idTiposNoTickeados as $idTipoNoTickeado)
	{
		$examenLab = new exLab($idCita, $idTipoNoTickeado, "");
		if ($examenLab->comprobarExamenGuardado())
		{
			$examenLab->eliminar();
		}
	}
}
echo "Examenes actualizado";
?>