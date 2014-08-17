<?php
$privilegiosPagina = 1;
include("seguridad.php");
include_once("clases/RecetaFrecuente.php");
$texto = $_GET["texto"];

header('Content-type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";

$recetas = RecetaFrecuente::obtenerRecetasAutocompletar($texto);
?>
<datos>
<?php
foreach($recetas as $receta)
{
	echo "<receta>" . $receta->Receta . "</receta>";
}
?>
</datos>