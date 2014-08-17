// JavaScript Document
// Variables para setear

onload=function() 
{
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo");
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	form=document.getElementById("formulario");
	urlDestino="administrarUsuarios.php";
	
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Usuario"] = "Ingresa tu nombre de usuario. De 5 a 14 caracteres. OBLIGATORIO";
	ayuda["Nombre"] = "Ingresa nombre. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["ApellidoP"] = "Ingresa apellido paterno. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["ApellidoM"] = "Ingresa apellido materno. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["Clave"] = "Ingresa tu clave. De 4 a 14 caracteres. OBLIGATORIO";
	ayuda["ReingresoClave"] = "Ingresa tu clave nuevamente. OBLIGATORIO";
	ayuda["Categoria"] = "Selecciona categoria";
	ayuda["Ayuda"]="Posicione el cursor sobre los nombres de los datos para conocer ayuda.";
	
	preCarga("imagenes/ok.gif", "imagenes/loading.gif", "imagenes/error.gif");
}

//calcular la edad de una persona
//recibe la fecha como un string en formato español
//devuelve un entero con la edad. Devuelve false en caso de que la fecha sea incorrecta o mayor que el dia actual
function CalcularEdad(fecha){
    //calculo la fecha de hoy
	errorFecha=0;
    hoy=new Date();
    //alert(hoy)

    //calculo la fecha que recibo
    //La descompongo en un array
    var array_fecha = fecha.split("/");
    //si el array no tiene tres partes, la fecha es incorrecta
    if (array_fecha.length!=3)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: El formato de fecha es dd/mm/aaaa.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}

    //compruebo que los ano, mes, dia son correctos
    var ano;
    ano = parseInt(array_fecha[2]);
    if (isNaN(ano))
	{
		errorFecha=1;
	}
	if(ano<1900)
	{
		errorFecha=1;
	}

    var mes;
    mes = parseInt(array_fecha[1]);
    if (isNaN(mes))
	{
		errorFecha=1;
	}
	else if(mes>12)
	{
		errorFecha=1;
	}
	else if(mes<1)
	{
		errorFecha=1;
	}

    var dia;
    dia = parseInt(array_fecha[0]);
    if (isNaN(dia))
	{
		errorFecha=1;
	}
	else if(dia>31)
	{
		errorFecha=1;
	}
	else if(dia<0)
	{
		errorFecha=1;
	}
	else if(mes==2 && dia>29)
	{
		errorFecha=1;
	}
	
	if(errorFecha==1)
	{
				var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: Revise los campos en rojo.<br>El formato de fecha es dd/mm/aaaa.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
		return false;
	}

    /*si el año de la fecha que recibo solo tiene 2 cifras hay que cambiarlo a 4
    if (ano<=99)
       ano +=1900;*/
	   
    //resto los años de las dos fechas
    edad=hoy.getYear() + 1900 - ano - 1; //-1 porque no se si ha cumplido años ya este año
	//si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido

    if (hoy.getMonth() + 1 - mes > 0)
       edad=edad+1;
	else
    //entonces es que eran iguales. miro los dias
    //si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido
    	if (hoy.getUTCDate() - dia >= 0)
       		edad=edad + 1;
	
	form.edad.value=edad;
	return true;
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

function validaForm()
{
	limpiaForm(7);
	error=0;
	var idUsuario = eliminaEspacios(form.idUsuario.value);
	var nombre = eliminaEspacios(form.nombre.value);
	var apellidopaterno = eliminaEspacios(form.apellidopaterno.value);
	var apellidomaterno = eliminaEspacios(form.apellidomaterno.value);
	var idCategoria = form.idCategoria.value;
	var clave = eliminaEspacios(form.clave.value);
	var ReingresoClave = eliminaEspacios(form.ReingresoClave.value);
	if(!validaLongitud(idUsuario, false, 5, 14)) campoError(form.idUsuario);
	if(!validaLongitud(nombre, false, 4, 50)) campoError(form.nombre); 
	if(!validaLongitud(apellidopaterno, false, 4, 50)) campoError(form.apellidopaterno);
	if(!validaLongitud(apellidomaterno, false, 4, 50)) campoError(form.apellidomaterno);
	if(!validaLongitud(clave, false, 4,14)) campoError(form.clave);
	if(!validaLongitud(ReingresoClave, false, 4, 14)) campoError(form.ReingresoClave);
	if (clave != ReingresoClave) campoError2(form.clave);
	if (clave != ReingresoClave) campoError2(form.ReingresoClave);
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	if (error==2)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Las claves deben ser iguales<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		/*
		var texto = "run="+run+"<br>nombre="+nombre+"<br>apellidop="+apellidop+"<br>apellidom="+apellidom+"<br>telefono="+telefono+"<br>celular="+celular+"<br>fechanac="+fechanac+"<br>direccion="+direccion+"<br>correo="+correo+"<br>ocupacion="+ocupacion+"<br>derivadopor="+derivadopor+"<br>alergia=<br><br><img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button  style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
	muestraMensaje(texto);*/
		
		var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=1&idUsuario="+idUsuario+"&nombre="+nombre+"&apellidopaterno="+apellidopaterno+"&apellidomaterno="+apellidomaterno+"&clave="+clave+"&idCategoria="+idCategoria;
		
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Usuario guardado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				}
				else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}
	}
}


function eliminarUsuario(idUsuario)
{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Eliminando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=2&idUsuario="+idUsuario;
		
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Usuario eliminado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				}
				else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}
}

function modificarUsuario()
{
	limpiaForm(7);
	error=0;
	var idUsuario = eliminaEspacios(form.idUsuario.value);
	var nombre = eliminaEspacios(form.nombre.value);
	var apellidopaterno = eliminaEspacios(form.apellidopaterno.value);
	var apellidomaterno = eliminaEspacios(form.apellidomaterno.value);
	var idCategoria = form.idCategoria.value;
	var clave = eliminaEspacios(form.clave.value);
	var ReingresoClave = eliminaEspacios(form.ReingresoClave.value);
	if(!validaLongitud(idUsuario, false, 5, 14)) campoError(form.idUsuario);
	if(!validaLongitud(nombre, false, 4, 50)) campoError(form.nombre); 
	if(!validaLongitud(apellidopaterno, false, 4, 50)) campoError(form.apellidopaterno);
	if(!validaLongitud(apellidomaterno, false, 4, 50)) campoError(form.apellidomaterno);
	if(!validaLongitud(clave, true, 4,14)) campoError(form.clave);
	if(!validaLongitud(ReingresoClave, true, 4, 14)) campoError(form.ReingresoClave);
	if (clave != ReingresoClave) campoError2(form.clave);
	if (clave != ReingresoClave) campoError2(form.ReingresoClave);
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	if (error==2)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Las claves deben ser iguales<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		
		var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=3&idUsuario="+idUsuario+"&nombre="+nombre+"&apellidopaterno="+apellidopaterno+"&apellidomaterno="+apellidomaterno+"&clave="+clave+"&idCategoria="+idCategoria;
		
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Usuario modificado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				}
				else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}
	}
}

function llenarFormularioModificar(idUsuario, nombre, apellidoPaterno, apellidoMaterno,idCategoria)
{
	form.idUsuario.value = idUsuario;
	form.nombre.value = nombre;
	form.apellidopaterno.value = apellidoPaterno;
	form.apellidomaterno.value = apellidoMaterno;
	form.idCategoria.value = idCategoria;
	//form.mostrarModificar.value = 
}

function limpiarDatos()
{
	for (var i = 0; i < document.formulario.elements.length; i++)
	{
		if (document.formulario.elements[i].name == "alergia")
			document.formulario.elements[i].checked = false;
		else
			document.formulario.elements[i].value="";
	}
	
	/*var controlAlergia = document.getElementsByName('alergia');
	var controlComentario = document.getElementsByName('comentario');
	for(j=0;j<cantAlergias;j++)
	{
		controlAlergia[j].checked=false;
		controlComentario[j].value="";	
	}*/
}
