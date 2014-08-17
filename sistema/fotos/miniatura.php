<?php 

function CargarJpeg($nombreimg)
{
	$im = @imagecreatefromjpeg($nombreimg); /* Intento de apertura */
	if (!$im)
	{ 
		/* Comprobar si ha fallado */
		$im  = imagecreate(150, 30); /* Crear una imagen en blanco */
		$bgc = imagecolorallocate($im, 255, 255, 255);
		$tc  = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
		/* Mostrar un mensaje de error */
		imagestring($im, 1, 5, 5, "Error cargando $nombreimg", $tc);
	}
	return $im;
}

$ruta = $_GET["ruta"];
$fuente = CargarJpeg($ruta);
$imgAncho = imagesx($fuente);
$imgAlto = imagesy($fuente);
$proporcion = ($imgAncho > $imgAlto)?100/$imgAncho:100/$imgAlto;
$ancho = $imgAncho * $proporcion;
$alto = $imgAlto * $proporcion;

$imagen = imagecreatetruecolor($ancho,$alto);

ImageCopyResized($imagen,$fuente,0,0,0,0,$ancho,$alto,$imgAncho,$imgAlto);

Header("Content-type: image/jpeg ");
imageJpeg($imagen);
?> 