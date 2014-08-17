
// Declaro un array en el cual los indices son los ID's de los DIVS que funcionan como pestaña y los valores son los identificadores de las secciones a cargar
var tabsIdDiag=new Array();
tabsIdDiag['diag']='seccion1';
tabsIdDiag['foto']='seccion2';
tabsIdDiag['pres']='seccion3';
tabsIdDiag['exam']='seccion4';
tabsIdDiag['parc']='seccion5';
// Declaro el ID del DIV que actuará como contenedor de los datos recibidos
var contenedorDiag='tabContenidoDiag';

function nuevoAjaxDiag()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

function cargaContenidoDiag()
{
	/* Recorro las pestañas para dejar en estado "apagado" a todas menos la que se ha clickeado. Teniendo en cuenta que solo puede haber una pestaña "encendida"
	a la vez resultaría mas óptimo hacer un while hasta encontrar a esa pestaña, cambiarle el estilo y luego salir, pero, creanme, se complicaría un poco el
	ejemplo y no es mi intención complicarlos */
	for(key in tabsIdDiag)
	{
		// Obtengo el elemento
		elemento=document.getElementById(key);
		// Si es la pestaña activa
		if(elemento.className=='tabOnDiag')
		{
			// Cambio el estado de la pestaña a inactivo 
			elemento.className='tabOffDiag';
		}
	}
	// Cambio el estado de la pestaña que se ha clickeado a activo
	this.className='tabOnDiag';
	
	/* De aqui hacia abajo se tratatan la petición y recepción de datos */
	
	// Obtengo el identificador vinculado con el ID del elemento HTML que referencia a la sección a cargar
	seccion=tabsIdDiag[this.id];
	
	// Coloco un mensaje mientras se reciben los datos
	tabContenedorDiag.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjaxDiag();
	ajax.open("POST", "scripts/tabsDiagnosticoFichaPacienteProceso.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send('seccion='+seccion);
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState==4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedorDiag.innerHTML=ajax.responseText;
		}
	}
}

function mouseSobreDiag()
{
	// Si el evento no se produjo en la pestaña seleccionada...
	if(this.className!='tabOnDiag')
	{
		// Cambio el color de fondo de la pestaña
		this.className='tabHoverDiag';
	}
}

function mouseFueraDiag()
{
	// Si el evento no se produjo en la pestaña seleccionada...
	if(this.className!='tabOnDiag')
	{
		// Cambio el color de fondo de la pestaña
		this.className='tabOffDiag';
	}
}

function tabDiag()
{
	for(key in tabsIdDiag)
	{
		// Voy obteniendo los ID's de los elementos declarados en el array que representan a las pestañas
		elemento=document.getElementById(key);
		// Asigno que al hacer click en una pestaña se llame a la funcion cargaContenido
		elemento.onclick=cargaContenidoDiag;
		 //El cambio de estilo es en 2 funciones diferentes debido a la incompatibilidad del string de backgroundColor devuelto por Mozilla e IE.
		//Se podría pasar de rgb(xxx, xxx, xxx) a formato #xxxxxx pero complicaría innecesariamente el ejemplo 
		elemento.onmouseover=mouseSobreDiag;
		elemento.onmouseout=mouseFueraDiag;
	}
	// Obtengo la capa contenedora de datos
	tabContenedorDiag=document.getElementById(contenedorDiag);
}