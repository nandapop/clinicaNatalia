function verificarPacientes(msgWindow, atencion)
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp = false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp = false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') { xmlhttp = new XMLHttpRequest(); } 

	// Creo el objeto aquí mismo para no chocar con la funcion nuevoAjax si es que está incluida en más de un archivo.
	ajax = xmlhttp;
	
	ajax.open("POST", "pacientesEsperando.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	if(msgWindow && !msgWindow.closed)
	{
		var texto = "accion=1";
	}
	else
	{
		var texto = "accion=2";
	}
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			if(ajax.responseText != "OK")
			{
				actualizarPopUp(msgWindow, atencion);
			}
		}
	}
}

function abrir_guardarPaciente()
{
	window.open('ingresarPaciente.php','mywin','width=700,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;
}

function abrir_buscar()
{
	window.open('buscar.php','mywin3','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;
}

function abrir_buscar_Fecha()
{
	window.open('buscarFecha.php','mywin3','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;

}

function abrir_buscar_Patologia()
{
	window.open('buscarPatologia.php','mywin3','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;

}

function actualizarPopUp(msgWindow, atencion)
{
    if(msgWindow && !msgWindow.closed)
    {
        msgWindow.location.reload(true);
        msgWindow.focus();
        top.location = self.location;
    }
    else
    {
        msgWindow = window.open("pacientesEsperando.php?atencion=1", "displayWindow", "resizable=0, scrollbars=1, menubar=0, toolbar=0, height=300, width=350, left=5, top=5");
        msgWindow.focus();
    }
}

function actualizarCita(idCita)
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp = false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp = false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') { xmlhttp = new XMLHttpRequest(); } 

	// Creo el objeto aquí mismo para no chocar con la funcion nuevoAjax si es que está incluida en más de un archivo.
	ajax = xmlhttp;
	
	ajax.open("POST", "actualizarCitaNoPopUp.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idCita=" + idCita;
	
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		actualizarPopUp();
	}
}
