function nuevoAjax()
{ 
	var xmlhttp=false; 
	try 
	{ 
		// No IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest(); } 
	return xmlhttp; 
}

function limpiaForm(cantElementos)
{
	for(i=0; i<=cantElementos; i++)
	{
		form.elements[i].className=claseNormal;
	}
	//document.getElementById("inputComentario").className=claseNormal;
}

function limpiaCamposForm(form, cantElementos)
{
	for(i=0; i<=cantElementos; i++)
	{
		form.elements[i].className=claseNormal;
	}
}

function campoError(campo)
{
	campo.className=claseError;
	error=1;
}

function campoError2(campo)
{
	campo.className=claseError;
	error=2;
}

function ocultaMensaje()
{
	divTransparente.style.display="none";
}

function muestraMensaje(mensaje)
{
	divMensaje.innerHTML=mensaje;
	divTransparente.style.display="block";
}

function eliminaEspacios(cadena)
{
	// Funcion para eliminar espacios delante y detras de cada cadena
	while(cadena.charAt(cadena.length-1)==" ") cadena=cadena.substr(0, cadena.length-1);
	while(cadena.charAt(0)==" ") cadena=cadena.substr(1, cadena.length-1);
	return cadena;
}

function validaLongitud(valor, permiteVacio, minimo, maximo)
{
	var cantCar=valor.length;
	if(valor=="")
	{
		if(permiteVacio) return true;
		else return false;
	}
	else
	{
		if(cantCar>=minimo && cantCar<=maximo) return true;
		else return false;
	}
}

function validaCorreo(valor)
{
	var reg=/(^[a-zA-Z0-9._-]{1,30})@([a-zA-Z0-9.-]{1,30}$)/;
	if(reg.test(valor)) return true;
	else return false;
}

function cambiaEstado(iden)
{
	var elhtml = document.getElementById(iden);
	if (elhtml.style.display == 'block')
		 elhtml.style.display = 'none';
	else
		 elhtml.style.display = 'block';
}

// Mensajes de ayuda

if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
else navegador=1;

function colocaAyuda(event)
{
	if(navegador==0)
	{
		var corX=window.event.clientX+document.documentElement.scrollLeft;
		var corY=window.event.clientY+document.documentElement.scrollTop;
	}
	else
	{
		var corX=event.clientX+window.scrollX;
		var corY=event.clientY+window.scrollY;
	}
	cAyuda.style.top=corY+20+"px";
	cAyuda.style.left=corX+15+"px";
}

function ocultaAyuda()
{
	cAyuda.style.display="none";
	if(navegador==0) 
	{
		document.detachEvent("onmousemove", colocaAyuda);
		document.detachEvent("onmouseout", ocultaAyuda);
	}
	else 
	{
		document.removeEventListener("mousemove", colocaAyuda, true);
		document.removeEventListener("mouseout", ocultaAyuda, true);
	}
}

function preCarga()
{
	imagenes=new Array();
	for(i=0; i<arguments.length; i++)
	{
		imagenes[i]=document.createElement("img");
		imagenes[i].src=arguments[i];
	}
}

function muestraAyuda(event, campo, textos)
{
	colocaAyuda(event);
	
	if(navegador==0) 
	{ 
		document.attachEvent("onmousemove", colocaAyuda); 
		document.attachEvent("onmouseout", ocultaAyuda); 
	}
	else 
	{
		document.addEventListener("mousemove", colocaAyuda, true);
		document.addEventListener("mouseout", ocultaAyuda, true);
	}
	if(textos!="")
	{
		cNombre.innerHTML = campo;
		cTex.innerHTML = textos;
		cAyuda.style.display = "block";
	}
	else
	{
		cNombre.innerHTML = campo;
		cTex.innerHTML = ayuda[campo];
		cAyuda.style.display = "block";
	}
}

function comprobarUsuario(formulario)
{
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	var nombre=document.getElementById('id_usuario').value;
	if(nombre!="")
	{
		var acp = document.getElementById('aceptado');
		var noacp = document.getElementById('no_aceptado');
		acp.style.display = 'none';
		noacp.style.display = 'none';
		
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Consultando. Por favor espere.<br><br>";
		muestraMensaje(texto);			
		var ajax=nuevoAjax();
		ajax.open("POST", "registrarUsuario.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "usuario="+nombre+"&id=4";
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					ocultaMensaje();
					cambiaEstado('aceptado');
					
				}
				else 
				{
					ocultaMensaje();
					cambiaEstado('no_aceptado');
				}
			}
		}
	}
}

function estadoIconos()
{
	var acp = document.getElementById('aceptado');
	var noacp = document.getElementById('no_aceptado');
	acp.style.display = 'none';
	noacp.style.display = 'none';
	document.getElementById('nombre').value="";
	document.getElementById('apellidop').value="";
	document.getElementById('apellidom').value="";
	document.getElementById('id_usuario').value="";	
	document.getElementById('clave').value="";	
	document.getElementById('clave_conf').value="";
}