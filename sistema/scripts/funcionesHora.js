// JavaScript Document
var formularioID;
onload=function() 
{
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo");
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	urlDestino="calendarioPaciente.php";
	
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Run"] = "Ingresa el Run con el siguiente formato: 123456789-0";
	ayuda["Nombre"] = "Ingresa nombre. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["ApellidoP"] = "Ingresa apellido paterno. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["Telefono"] = "Ingresa telefono de contacto. Formato: 32 - 2222222. OBLIGATORIO";
	ayuda["Sexo"]="Seleccione sexo.";
	ayuda["Prevision"]="Ingrese prevision del paciente";
	ayuda["Ayuda"]="Posicione el cursor sobre los nombres de los datos para conocer ayuda.";
	ocultaMensajeCarga();
}

function ocultaMensajeCarga(){

document.getElementById('mensaje_carga').style.display = "none";

}

function editarForm(formE)
{
	formE.pagado.disabled=false;
}

function actualizarCita(formA)
{
	var idCita=formA.idCita.value;
	var pagado=formA.pagado.value;
	if(idCita=="" || pagado=="")
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: datos incorrectos.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
		return false;
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST",urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//id=2 Guardar Cita
		var texto="id=4&idCita="+idCita+"&pagado="+pagado;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				ocultaMensaje();
				var respuesta=ajax.responseText;
				if(respuesta==1)
				{
					formA.pagado.disabled=true;
				}
				else
					alert("Cambios no fueron realizados!");
			}
		}
	}
}

function confirmarHora(formC, codigo)
{
	var IdCita = formC.idCita.value;
	if(IdCita!="")
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST",urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//id=2 Guardar Cita
		var texto="id=3&idCita="+IdCita+"&codigo="+codigo;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				ocultaMensaje();
				if(respuesta==1)
				{
					Recargar();
				}
			}		
		}
	}
}

function eliminaEspacios(cadena)
{
	// Funcion equivalente a trim en PHP
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}

function guardarCita(formG, consulta)
{
	error=0;
	limpiaCamposForm(formG, 10)
	var idPaciente = eliminaEspacios(formG.idPac.value);
	var rut = eliminaEspacios(formG.rut.value);
	var nombre = eliminaEspacios(formG.nombre.value);
	var apellidop = eliminaEspacios(formG.apellidop.value);
	var telefono = eliminaEspacios(formG.telefono.value);
	var prevision = eliminaEspacios(formG.prevision.value);
	//var atencion = eliminaEspacios(formG.atencion.value)
	var box = eliminaEspacios(formG.box.value);
	var pagado = eliminaEspacios(formG.pagado.value);
	var fecha = eliminaEspacios(formG.fechaHora.value);
	
	if(!validaLongitud(rut,0,1,10)) campoError(formG.rut);
	if(!validaLongitud(nombre,0,1,100)) campoError(formG.nombre);
	if(!validaLongitud(apellidop,0,1,100)) campoError(formG.apellidop);
	if(!validaLongitud(telefono,0,1,20)) campoError(formG.telefono);
	if(!validaLongitud(prevision,0,1,100)) campoError(formG.prevision);
	//if(atencion=="") campoError(formG.atencion);
	if(box=="") campoError(formG.box);
	if(!validaLongitud(pagado,0,1,100)) campoError(formG.pagado);
	if(error!=0)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: Campos en rojo incorrectos. Seleccione opcion segun corresponda.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
		return false;
	}
	
	if(idPaciente=="")
	{
		//creamos nuevo paciente
		var texto = "id=1&run="+rut+"&nombre="+nombre+"&apellidop="+apellidop+"&apellidom=&telefono="+telefono+"&celular=&fechanac=&direccion=&correo=&ocupacion=&derivadopor=&sexo=&prevision="+prevision+"&cantalergia="		
		var ajax=nuevoAjax();
		ajax.open("POST","ingresarPaciente.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				respuesta_array=respuesta.split("&");
				if(respuesta_array[0]!="OK")
				{
					return false;
				}
				else
				{
					formG.idPac.value=respuesta_array[1];
					idPaciente=respuesta_array[1];
				}
			}
		}
	}
	//se agrega solo la cita
	var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
	var ajax=nuevoAjax();
	ajax.open("POST",urlDestino, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	//id=2 Guardar Cita
	var texto="id=2&idPaciente="+idPaciente+"&fechaCita="+fecha+"&tipoCita="+box+"&pagado="+pagado+"&consulta="+consulta;
	//var texto="id=2&idPaciente="+idPaciente+"&fechaCita="+fecha+"&pagado="+pagado+"&atencion="+atencion+"&consulta="+consulta;
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			array_fecha=fecha.split(" ");
			ocultaMensaje();
			var texto="";
			if(respuesta==1)
			{
				alert("Hora pedida para el dia "+array_fecha[0]+" a las "+array_fecha[1]+" a nombre de "+nombre+" "+apellidop);
				formG.reset();
				Recargar();
			}
			else
				alert("Hora no guardada. Intente Nuevamente.");
		}
	}
}

function Recargar()
{
	document.location.reload()
}

function buscarRut(form)
{
	form.nombre.disabled=true;
	form.apellidop.disabled=true;
	form.telefono.disabled=true;
	form.prevision.disabled=true;
	//form.atencion.disabled=true;
	form.box.disabled=true;
	form.pagado.disabled=true;
	form.espera.disabled=true;
	form.aceptar.disabled=true;
	form.cancelar.disabled=true;
	error=0;
	limpiaCamposForm(form,9);
	var rut = eliminaEspacios(form.rut.value);
	if(!validaLongitud(rut, 0, 7, 10)) campoError(form.rut);
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: Ingrese rut correcto.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST",urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//id=1 -> Busqueda por Rut
		var texto="id=1&rut="+rut;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				var array_respuesta = respuesta.split("&");
				var id_sinCorr=array_respuesta[0];
				var id_array=id_sinCorr.split(".");
				ocultaMensaje();
				if(id_array[0]==1)
				{
					form.nombre.value=array_respuesta[1];
					form.apellidop.value=array_respuesta[2];
					form.telefono.value=array_respuesta[3];
					form.prevision.value=array_respuesta[4];
					form.idPac.value=array_respuesta[5];
					//form.atencion.disabled=false;
					form.box.disabled=false;
					form.pagado.disabled=false;
					form.espera.disabled=false;
					form.aceptar.disabled=false;
					if(id_array[1]==1)
						alert("Al paciente le faltan datos en la ficha");
				}
				else
				{
					formularioID=form;
					abrir_guardarPacienteCorto(rut);
				}
			}
		}
	}
}

function abrir_guardarPaciente()
{
	window.open('ingresarPaciente.php','mywin','width=700,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;
}

function abrir_guardarPacienteCorto(rut)
{
	var destino = "ingresarPacienteCorto.php?rut=" + rut;
	pacCorto=window.open(destino,'pacienteCorto','width=700,height=400,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no,dependent=yes');
	parent.opener=top;
}


function abrir_buscar()
{
	window.open('buscar.php','mywin3','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;

}

function abrir_imprimirCalendario(url)
{
	window.open(url,'mywin2','width=700,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=no');
	parent.opener=top;
	
}

function eliminarCita(formE)
{
	var idCita=formE.idCita.value;
	var ajax=nuevoAjax();
	ajax.open("POST",urlDestino, true);
	var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var texto="id=5&idCita="+idCita;
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			ocultaMensaje();
			if(respuesta==0)
				alert("No se puede eliminar cita");
			else
				Recargar();
		}
	}
}
	
function cargaD(form)
{
	var nombre=form.nombre.value;
	var rut=form.rut.value;
	var telefono=form.telefono.value;
	if(nombre=="" && rut=="" && telefono=="")
	{
		alert("ingrese Datos");
		form.rut.focus();
		return false;
	}
	else
	{
		var ajax=nuevoAjax();
		ajax.open("POST","ingreso_sin_recargar_proceso.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto="id=1&nombre="+nombre+"&rut="+rut+"&telefono="+telefono;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				var array_respuesta = respuesta.split("&");
				var id=array_respuesta[0];
				if(id==1)
				{
					form.nombre.value=array_respuesta[1];
					form.telefono.value=array_respuesta[2];
					form.prevision.value="Fonasa";
					form.atendido.value="Salima";
					//form.box.value="Pabellon";
					
				}
				else
				{
					alert("no se encontro");
				}
			}
		}
	}
}
/*
function cargaDatos(idDiv, idInput)
{
	var valorInput=document.getElementById(idInput).value;
	var divError=document.getElementById("error");
	
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
	
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	if(!reg.test(valorInput)) 
	{ 
		// Si hay error muestro el div que contiene el error
		divError.innerHTML="El texto ingresado no es v&aacute;lido"
		divError.style.display="block";
	}
	else
	{
		// Si no hay error oculto el div (por si se mostraba)
		divError.style.display="none";
		mostrandoInput=false;
		document.getElementById(idDiv).innerHTML=valorInput;
		
		// Creo objeto AJAX y envio peticion al servidor
		var ajax=nuevoAjax();
		ajax.open("POST","ingreso_sin_recargar_proceso.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto="dato="+valorInput+"&actualizar="+idInput;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				alert(respuesta);
				var array_respuesta = respuesta.split("&");
				var id=array_respuesta[0];
				if(id==1)
				{
					alert("aqui "+array_respuesta[1]);
				}
			}
		}
	}
}
*/
