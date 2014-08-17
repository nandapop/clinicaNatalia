// Declaro un array en el cual los indices son los ID's de los DIVS que funcionan como pestaña y los valores son los identificadores de las secciones a cargar
var tabsId=new Array();
tabsId['diagnostico']='diagnostico';
tabsId['prescripcion']='prescripcion';
tabsId['examenes']='examenes';
tabsId['historial']='historial';
// Declaro el ID del DIV que actuará como contenedor de los datos recibidos
var contenedor ='tabContenido';

var IE = navigator.appName.toLowerCase().indexOf("microsoft") > -1;
var Mozilla = navigator.appName.toLowerCase().indexOf("netscape") > -1;

var textoAnt = "";
var posicionListaFilling = 0;

var estanPegando = false;

var datos = new Array();

function nuevoAjax()
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

function cargaContenido()
{
	/* Recorro las pestañas para dejar en estado "apagado" a todas menos la que se ha clickeado. Teniendo en cuenta que solo puede haber una pestaña "encendida"
	a la vez resultaría mas óptimo hacer un while hasta encontrar a esa pestaña, cambiarle el estilo y luego salir, pero, creanme, se complicaría un poco el
	ejemplo y no es mi intención complicarlos */
	for(key in tabsId)
	{
		// Obtengo el elemento
		elemento=document.getElementById(key);
		// Si es la pestaña activa
		if(elemento.className=='tabOn')
		{
			// Cambio el estado de la pestaña a inactivo 
			elemento.className='tabOff';
		}
	}
	// Cambio el estado de la pestaña que se ha clickeado a activo
	this.className='tabOn';
	
	/* De aqui hacia abajo se tratatan la petición y recepción de datos */
	
	// Obtengo el identificador vinculado con el ID del elemento HTML que referencia a la sección a cargar
	seccion=tabsId[this.id];
	
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "tabsFichaPacienteProceso.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	if (seccion == 'diagnostico')
	{
		var idCita = document.getElementById('idCita').value;
		var texto = "seccion="+seccion+"&idCita="+idCita;
		ajax.send(texto);
	}	
	else if (seccion == 'prescripcion')
	{
		var idCita = document.getElementById('idCita').value;
		var texto = "seccion="+seccion+"&idCita="+idCita;
		ajax.send(texto);
	}
	else if(seccion == 'historial')
	{
		var idPaciente = document.getElementById('idPaciente').value;
		var texto = "seccion="+seccion+"&idPaciente="+idPaciente;
		ajax.send(texto);
	}
	else if (seccion == 'examenes')
	{
		var idCita = document.getElementById('idCita').value;
		var texto = "seccion="+seccion+"&idCita="+idCita;
		ajax.send(texto);
	}
	else
	{
		ajax.send('seccion='+seccion);
	}
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState==4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedor.innerHTML=ajax.responseText;
			if (seccion == 'diagnostico')
			{
				var form = document.getElementById("ingresarDiagnostico");
				form.diagnostico.focus();
			}	
			else if (seccion == 'prescripcion')
			{
				var form = document.getElementById("ingresarPrescripcion");
				form.indicaciones.focus();
			}
		}
	}
}

function mouseSobre()
{
	// Si el evento no se produjo en la pestaña seleccionada...
	if(this.className!='tabOn')
	{
		// Cambio el color de fondo de la pestaña
		this.className='tabHover';
	}
}

function mouseFuera()
{
	// Si el evento no se produjo en la pestaña seleccionada...
	if(this.className!='tabOn')
	{
		// Cambio el color de fondo de la pestaña
		this.className='tabOff';
	}
}

function tab()
{
	for(key in tabsId)
	{
		// Voy obteniendo los ID's de los elementos declarados en el array que representan a las pestañas
		elemento=document.getElementById(key);
		// Asigno que al hacer click en una pestaña se llame a la funcion cargaContenido
		elemento.onclick=cargaContenido;
		/* El cambio de estilo es en 2 funciones diferentes debido a la incompatibilidad del string de backgroundColor devuelto por Mozilla e IE.
		Se podría pasar de rgb(xxx, xxx, xxx) a formato #xxxxxx pero complicaría innecesariamente el ejemplo */
		elemento.onmouseover=mouseSobre;
		elemento.onmouseout=mouseFuera;
	}
	// Obtengo la capa contenedora de datos
	tabContenedor=document.getElementById(contenedor);
	
	HTMLElement.prototype.click = function() 
	{
		var evt = this.ownerDocument.createEvent('MouseEvents');
		evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
		this.dispatchEvent(evt);
	}
	var form = document.getElementById("ingresarDiagnostico");
	form.diagnostico.focus();
}

function guardarDiagnostico()
{
	var form = document.getElementById("ingresarDiagnostico");
	var idCita = form.idCita.value;
	var diagnostico = escape(form.diagnostico.value);
	diagnostico = diagnostico.replace(/\+/g,"%2B");
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "ingresarDiagnostico.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idCita=" + idCita + "&diagnostico=" + diagnostico;
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedor.innerHTML=ajax.responseText;
		}
	}

}

function guardarPrescripcion()
{
	textoAnt = "";
	var form = document.getElementById("ingresarPrescripcion");
	var idCita = form.idCita.value;
	//var medicamento = form.medicamento.value;
	var indicaciones = escape(form.indicaciones.value);
	indicaciones = indicaciones.replace(/\+/g,"%2B");
	var idReceta = form.idReceta.value;
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	if(idReceta == 0)
	{
		ajax.open("POST", "ingresarPrescripcion.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
		//var texto = "idCita=" + idCita + "&medicamento=" + medicamento + "&indicaciones=" + indicaciones;
		var texto = "idCita=" + idCita + "&indicaciones=" + indicaciones;
		ajax.send(texto);
		
		
		ajax.onreadystatechange=function()
		{
			if(ajax.readyState == 4)
			{
				// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
				//tabContenedor.innerHTML=ajax.responseText;
				elemento = document.getElementById('prescripcion');
				elemento.click();
			}
		}
	}
	else
	{
		ajax.open("POST", "editarPrescripcion.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
		//var texto = "idCita=" + idCita + "&medicamento=" + medicamento + "&indicaciones=" + indicaciones;
		var texto = "idReceta=" + idReceta + "&indicaciones=" + indicaciones;
		ajax.send(texto);
		
		
		ajax.onreadystatechange=function()
		{
			if(ajax.readyState == 4)
			{
				// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
				//tabContenedor.innerHTML=ajax.responseText;
				elemento = document.getElementById('prescripcion');
				elemento.click();
			}
		}
	}
}

function borrarPrescripcion(idCita, idReceta)
{	
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "borrarPrescripcion.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idCita=" + idCita + "&idReceta=" + idReceta;
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			//tabContenedor.innerHTML=ajax.responseText;
			elemento=document.getElementById('prescripcion');
			elemento.click();
		}
	}
}

function editarPrescripcion(idReceta, indicaciones)
{	
	var form = document.getElementById("ingresarPrescripcion");
	form.indicaciones.value = URLDecode(indicaciones);
	form.idReceta.value = idReceta;
	form.btnCancelar.style.display = 'block';
}

function cancelarEdicion()
{
	var form = document.getElementById("ingresarPrescripcion");
	form.indicaciones.value = "";
	form.idReceta.value = 0;
	form.btnCancelar.style.display = 'none';
}

function eliminarCita(idCita)
{
	var agree = confirm("¿Realmente desea eliminar la cita? ");
	if (agree)
	{
		var idPaciente = document.getElementById('idPaciente').value;
		// Coloco un mensaje mientras se reciben los datos
		tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
		var ajax=nuevoAjax();
		ajax.open("POST", "eliminarCita.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
		var texto = "idPaciente=" + idPaciente + "&idCita=" + idCita;
		ajax.send(texto);
	
	
		ajax.onreadystatechange=function()
		{
			if(ajax.readyState == 4)
			{
				elemento=document.getElementById('historial');
				elemento.click();
			}
		}
	}	
}

function guardarExamen()
{
	var form = document.getElementById("ingresarExamen");
	var idCita = form.idCita.value;
	var examenes = document.getElementsByName("examen");
	var cantExamenes = form.cantExamenes.value;
	var idTipoExamenes = new Array();
	var idTiposNoTickeados = new Array();
	var cantExamenesTickeados = 0;
	var cantExamanesNoTickeados = 0;
	for (i = 0; i < cantExamenes; i++)
	{
		if (examenes[i].checked )
		{
			idTipoExamenes[cantExamenesTickeados] = examenes[i].value;
			cantExamenesTickeados++;
		}
		else
		{
			idTiposNoTickeados[cantExamanesNoTickeados] = examenes[i].value;
			cantExamanesNoTickeados++;	
		}
	}
	
	// Coloco un mensaje mientras se reciben los datos
	// tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "guardarExamen.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idCita=" + idCita;
	
	for(i = 0; i < cantExamenesTickeados; i++)
	{
		texto = texto + "&idTipos[]=" + idTipoExamenes[i];
	}
	
	for(i = 0; i < cantExamanesNoTickeados; i++)
	{
		texto = texto + "&idTiposNoTickeados[]=" + idTiposNoTickeados[i];
	}

	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			var formImprimir = document.getElementById("formImprimirExamenes");
			formImprimir.submit();
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedor.innerHTML=ajax.responseText;
		}
	}
}

function targetopener(mylink, closeme, closeonly, idCita)
{
	if (!window.focus)
	{
		return true;
	}
	// Siempre en ventana nueva
	window.open(mylink.href, "ventanaabierta", "toolbar=1, location=1, directories=1, status=1, menubar=1, scrollbars=1, resizable=1")
	
	// Ventana nueva si no hay pero el opener se pierde :S
	/*
	if(!window.opener)
	{
		window.open(mylink.href)
		actualizarCita(idCita);
	}
	else if (!closeonly)
	{
		window.opener.focus();
		window.opener.location.href = mylink.href;
		actualizarCita(idCita);
	}
	if (closeme)
	{
		window.close();
	}
	*/
	return false;
}

function guardarMorbidos(formMorbidos)
{
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	var cantAlergias=formMorbidos.cantAlergias.value;
	var idPaciente=formMorbidos.idPaciente.value;
	var controlAlergia = document.getElementsByName('alergia');
	var controlComentario = document.getElementsByName('comentario');
	var comentarios=new Array();
	var alergias=new Array();
	var masAlergias=0;
	for(i=0;i<cantAlergias;i=i+1)
	{
		if(controlAlergia[i].checked)
		{
			alergias[masAlergias]=controlAlergia[i].value;
			comentarios[masAlergias]=controlComentario[i].value;
			masAlergias=masAlergias+1;
		}
	}
	var texto="idPaciente="+idPaciente+"&cantalergia="+masAlergias;
	for(j=0;j<masAlergias;j++)
		texto = texto + "&alergia" + j + "=" + alergias[j] + "&comentario" + j + "=" + comentarios[j];
		
	var ajax=nuevoAjax();
	ajax.open("POST", "actualizarAntMorbidos.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	muestraMensaje(texto);
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			respuesta_array = respuesta.split("&");
			if(respuesta_array[0]=="OK")
			{
				var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Antecedentes guardados con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
			}
			else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";

			muestraMensaje(texto);
		}
	}
}

function guardarPatologias(formPatologias)
{
	divTransparente = document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	var cantPatologia = formPatologias.cantPatologia.value;
	var idPaciente = formPatologias.idPaciente.value;
	var controlPatologia = document.getElementsByName('idPatologia');
	var patologias = new Array();
	var masPatologias = 0;
	for(i= 0;i < cantPatologia; i++)
	{
		if(controlPatologia[i].checked)
		{
			patologias[masPatologias]=controlPatologia[i].value;
			masPatologias=masPatologias+1;
		}
	}
	var texto="idPaciente="+idPaciente+"&cantPatologia="+masPatologias;
	for(j=0;j<masPatologias;j++)
		texto = texto + "&idPatologia" + j + "=" + patologias[j];
		
	var ajax=nuevoAjax();
	ajax.open("POST", "actualizarPatologias.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	muestraMensaje(texto);
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			respuesta_array = respuesta.split("&");
			if(respuesta_array[0]=="OK")
			{
				var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Antecedentes guardados con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
			}
			else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";

			muestraMensaje(texto);
		}
	}
}

// ====================================================================
//       URLEncode and URLDecode functions
//
// Copyright Albion Research Ltd. 2002
// http://www.albionresearch.com/
//
// You may copy these functions providing that 
// (a) you leave this copyright notice intact, and 
// (b) if you use these functions on a publicly accessible
//     web site you include a credit somewhere on the web site 
//     with a link back to http://www.albionresearch.com/
//
// If you find or fix any bugs, please let us know at albionresearch.com
//
// SpecialThanks to Neelesh Thakur for being the first to
// report a bug in URLDecode() - now fixed 2003-02-19.8
// And thanks to everyone else who has provided comments and suggestions.
// ====================================================================
function URLEncode(plaintext)
{
	// The Javascript escape and unescape functions do not correspond
	// with what browsers actually do...
	var SAFECHARS = "0123456789" +					// Numeric
					"ABCDEFGHIJKLMNOPQRSTUVWXYZ" +	// Alphabetic
					"abcdefghijklmnopqrstuvwxyz" +
					"-_.!~*'()";					// RFC2396 Mark characters
	var HEX = "0123456789ABCDEF";

	var encoded = "";
	for (var i = 0; i < plaintext.length; i++ ) {
		var ch = plaintext.charAt(i);
	    if (ch == " ") {
		    encoded += "+";				// x-www-urlencoded, rather than %20
		} else if (SAFECHARS.indexOf(ch) != -1) {
		    encoded += ch;
		} else {
		    var charCode = ch.charCodeAt(0);
			if (charCode > 255) {
			    alert( "Unicode Character '" 
                        + ch 
                        + "' cannot be encoded using standard URL encoding.\n" +
				          "(URL encoding only supports 8-bit characters.)\n" +
						  "A space (+) will be substituted." );
				encoded += "+";
			} else {
				encoded += "%";
				encoded += HEX.charAt((charCode >> 4) & 0xF);
				encoded += HEX.charAt(charCode & 0xF);
			}
		}
	} // for

	return encoded;
}

function URLDecode(encoded)
{
   // Replace + with ' '
   // Replace %xx with equivalent character
   // Put [ERROR] in output if %xx is invalid.
   var HEXCHARS = "0123456789ABCDEFabcdef"; 
   var plaintext = "";
   var i = 0;
   while (i < encoded.length) {
       var ch = encoded.charAt(i);
	   if (ch == "+") {
	       plaintext += " ";
		   i++;
	   } else if (ch == "%") {
			if (i < (encoded.length-2) 
					&& HEXCHARS.indexOf(encoded.charAt(i+1)) != -1 
					&& HEXCHARS.indexOf(encoded.charAt(i+2)) != -1 ) {
				plaintext += unescape( encoded.substr(i,3) );
				i += 3;
			} else {
				alert( 'Bad escape combination near ...' + encoded.substr(i) );
				plaintext += "%[ERROR]";
				i++;
			}
		} else {
		   plaintext += ch;
		   i++;
		}
	} // while
   return plaintext;
}

function cargaLista(evt, obj, txt)
{
	ajax = nuevoAjax();
	ajax.open("GET", "obtenerRecetasXml.php?texto="+txt, true);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var datosRespuesta = ajax.responseXML;
			var recetas = datosRespuesta.getElementsByTagName("receta");
			
			var listaRecetas = new Array();
			if (recetas)
			{
				for (var i=0; i < recetas.length; i++)
				{
					listaRecetas[listaRecetas.length] = recetas[i].firstChild.data;
				}
			}
			escribeLista(obj, listaRecetas);
		}
	}
	ajax.send(null);
}

function escribeLista(obj, lista)
{
	var html = "";
	var fill = document.getElementById('lista');
	
	if (lista.length == 0)
	{
		// Si la lista es vacia no la mostramos
		fill.style.display = "none";
	}
	else
	{
		// Creamos una tabla con 
		// todos los elementos encontrados
		fill.style.display = "block";
		var html='<table cellspacing="0" cellpadding="0" border="0" width="100%">';
		for (var i=0; i<lista.length; i++)
		{
			html += '<tr id="tr'+obj.id+i+
				'" '+(posicionListaFilling == i? 
					' class="fill" ': 'class="noFill"')+
				' onmouseover="seleccionaFilling(\'tr'+
				obj.id+'\', '+i+
				')" onmousedown="seleccionaTextoFilling(\'tr'+
				obj.id+'\', '+i+')">';
			html += '<td>'+lista[i]+'</td></tr>';
		}
		html += '</table>';
	}

	// Escribimos la lista
	fill.innerHTML = html;
}


function inputFilling(evt, obj)
{
	var fill = document.getElementById('lista');

	var elems = datos;
	
	var tecla = "";
	var lista = new Array();
	var res = obj.value;
	var borrar = false;
	
	// Almaceno la tecla pulsada
	if (!IE)
	{
	  tecla = evt.which;
	}
	else
	{
	  tecla = evt.keyCode;
	}
	
	var texto;
	// Si la tecla que pulso es una
	// letra o un espacio, o el intro
	// o la tecla borrar, almaceno lo 
	// que debo buscar
	if (!String.fromCharCode(tecla).match(/(\w|\s)/) && tecla != 8 && tecla != 13)
	{
		texto = textoAnt;
	}
	else
	{
		texto = obj.value;
	}
	
	textoAnt = texto;

	// Si el texto es distinto de vacio
	// o se pulsa ARRIBA o ABAJO
	// hago llamada AJAX para que 
	// me devuelva la lista de palabras
	// que coinciden con lo que hay
	// escrito en la caja
	if (texto != null && texto.length > 3 && texto != "")
	{
		cargaLista(evt, obj, texto);
	}
	
	
	// Según la letra que se pulse
	if (tecla == 37)
	{ // Izquierda
		// No hago nada
	}
	else if (tecla == 38)
	{ // Arriba
		// Subo la posicion en la
		// lista desplegable una posición
		if (posicionListaFilling > 0)
		{
			posicionListaFilling--;
		}
		// Corrijo la posición del scroll
		fill.scrollTop = posicionListaFilling*14;
	}
	else if (tecla == 39)
	{ // Derecha
		// No hago nada
	}
	else if (tecla == 40)
	{ // Abajo
		if (obj.value != "")
		{
			// Si no es la última palabra
			// de la lista
			if (posicionListaFilling < lista.length-1)
			{
				// Corrijo el scroll
				fill.scrollTop = posicionListaFilling*14;
				// Bajo la posición de la lista
				posicionListaFilling++;
			}
		}
	}
	else if (tecla == 8)
	{ // Borrar <-
		// Se sube la lista del todo
		posicionListaFilling = 0;
		// Se permite borrar
		borrar = true;
	}
	else if (tecla == 13)
	{ // Intro
		// Deseleccionamos el texto
		if (obj.createTextRange)
		{
			var r = obj.createTextRange();
			r.moveStart("character", obj.value.length+1);
			r.moveEnd("character", obj.value.length+1);
			r.select();
		}
		else if (obj.setSelectionRange)
		{
			obj.setSelectionRange(obj.value.length+1, obj.value.length+1);
		}
		// Ocultamos la lista
		fill.style.display = "none";
		// Ponemos el puntero de 
		// la lista arriba del todo
		posicionListaFilling = 0;
		// Controlamos el scroll
		fill.scrollTop = 0;
		return true;
	}
	else
	{
		// En otro caso que siga
		// escribiendo
		posicionListaFilling = 0;
		fill.scrollTop = 0;
	}	
	
	// Si no se ha borrado
	if (!borrar)
	{
		if (lista.length != 0)
		{
			// Seleccionamos la parte del texto
			// que corresponde a lo que aparece
			// en la primera posición de la lista
			// menos el texto que realmente hemos
			// escrito
			obj.value = lista[posicionListaFilling];
			if (obj.createTextRange)
			{
				var r = obj.createTextRange();
				r.moveStart("character", texto.length);
				r.moveEnd("character", lista[posicionListaFilling].length);
				r.select();
			}
			else if (obj.setSelectionRange)
			{
				obj.setSelectionRange(texto.length, lista[posicionListaFilling].length);
			}
		}
	}
	return true;
}

// Introduce el texto seleccionado
function setInput(obj, fill)
{
	obj.value = textoAnt;
	fill.style.display = "none";
	posicionListaFilling = 0;
}

function guardarTextoPegado(evt, obj)
{
	if(estanPegando)
	{
		textoAnt = obj.value;
		estanPegando = false;
	}
}

function cambiarEstadoPegando()
{
	estanPegando = true;
}
// Cambia el estilo de
// la palabra seleccionada
// de la lista
function seleccionaFilling(id, n)
{
	document.getElementById(id + n).className = "fill";
	document.getElementById(id + posicionListaFilling).className = "noFill";  	
	posicionListaFilling = n;
}

// Pasa el texto del filling a la caja
function seleccionaTextoFilling(id, n)
{
	textoAnt = document.getElementById(id + n).firstChild.innerHTML;
	posicionListaFilling = 0;
}