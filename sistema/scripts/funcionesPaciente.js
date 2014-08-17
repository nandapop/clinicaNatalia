// JavaScript Document
// Variables para setear

onload=function () 
{
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo");
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	form=document.getElementById("formulario");
	urlDestino="ingresarPaciente.php";
	urlDestino2="ingresarPacienteCorto.php";
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Run"] = "Ingresa el Run con el siguiente formato: 123456789-0";
	ayuda["Nombre"] = "Ingresa nombre. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["ApellidoP"] = "Ingresa apellido paterno. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["ApellidoM"] = "Ingresa apellido materno. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["Telefono"] = "Ingresa telefono de contacto. Formato: 32 - 2222222. OBLIGATORIO";
	ayuda["Celular"] = "Ingresa celular de contacto. Formato: 09 - 1234567";
	ayuda["FechaNac"] = "Ingrese fecha de nacimiento con el siguiente formato: dd/mm/aaaa. OBLIGATORIO.";
	ayuda["Edad"] = "Automático. No necesita ingreso.";
	ayuda["Direccion"] = "Ingresa direccion del paciente.";
	ayuda["Correo"] = "Ingresa un e-mail válido.";
	ayuda["Ocupacion"] = "Ingresa ocupacion del paciente.";
	ayuda["DerivadoPor"] = "Ingresa nombre del doctor.";
	ayuda["PrimeraConsulta"] = "Se registra automaticamente en la primera consulta.";
	ayuda["Sexo"]="Seleccione sexo.";
	ayuda["Prevision"]="Ingrese prevision del paciente";
	ayuda["AlergiaA"] = "Click en + para ver lista de alergias.";
	ayuda["Alergia"]="Ingrese alergias del paciente, separadas por coma";
	ayuda["Ayuda"]="Posicione el cursor sobre los nombres de los datos para conocer ayuda.";
	
	preCarga("imagenes/ok.gif", "imagenes/loading.gif", "imagenes/error.gif");
}

//calcular la edad de una persona
//recibe la fecha como un string en formato español
//devuelve un entero con la edad. Devuelve false en caso de que la fecha sea incorrecta o mayor que el dia actual
function CalcularEdad(){
    //calculo la fecha de hoy
	if(!(form.dia.value!="" && form.mes.value!="" && form.ano.value!=""))
		return false;
	

	errorFecha=0;
    hoy=new Date();
    //alert(hoy)

    //calculo la fecha que recibo
    //La descompongo en un array
    /*var array_fecha = fecha.split("/");
    //si el array no tiene tres partes, la fecha es incorrecta
    if (array_fecha.length!=3)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: El formato de fecha es dd/mm/aaaa.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}*/

    //compruebo que los ano, mes, dia son correctos
    var ano=eliminaEspacios(form.ano.value);
    
    if (isNaN(ano))
	{
		errorFecha=1;
		campoError(form.ano);
	}
	if(ano<1900)
	{
		errorFecha=1;
		campoError(form.ano);
	}

    var mes=eliminaEspacios(form.mes.value);
    if (isNaN(mes))
	{
		errorFecha=1;
		campoError(form.mes);
	}
	else if(mes>12)
	{
		errorFecha=1;
		campoError(form.mes);
	}
	else if(mes<1)
	{
		errorFecha=1;
		campoError(form.mes);
	}

    var dia=eliminaEspacios(form.dia.value);
    if (isNaN(dia))
	{
		errorFecha=1;
		campoError(form.dia);
	}
	else if(dia>31)
	{
		errorFecha=1;
		campoError(form.dia);
	}
	else if(dia<0)
	{
		errorFecha=1;
		campoError(form.dia);
	}
	else if(mes==2 && dia>29)
	{
		errorFecha=1;
		campoError(form.dia);
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
	limpiaForm(20);
	error=0;
	var run=eliminaEspacios(form.run.value);
	var nombre=eliminaEspacios(form.nombre.value);
	var apellidop=eliminaEspacios(form.apellidop.value);
	var apellidom=eliminaEspacios(form.apellidom.value);
	
	var codigoC=eliminaEspacios(form.codigoC.value);
	var numeroC=eliminaEspacios(form.numeroC.value);
	var telefono = codigoC+"-"+numeroC
	
	var codigoCel=eliminaEspacios(form.codigoCel.value);
	var numeroCel=eliminaEspacios(form.numeroCel.value);	
	var celular=codigoCel+"-"+numeroCel;
	
	var dia=eliminaEspacios(form.dia.value);
	var mes=eliminaEspacios(form.mes.value);
	var ano=eliminaEspacios(form.ano.value);
	var fechanac=dia+"/"+mes+"/"+ano;
	
	var diaCita = eliminaEspacios(form.diaPrimeraCita.value);
	var mesCita = eliminaEspacios(form.mesPrimeraCita.value);
	var anoCita = eliminaEspacios(form.anoPrimeraCita.value);
	var fechaPrimeraCita = anoCita + "-" + mesCita + "-" + diaCita;
	
	var direccion=eliminaEspacios(form.direccion.value);
	var correo=eliminaEspacios(form.email.value);
	var ocupacion=eliminaEspacios(form.ocupacion.value);
	var derivadopor=eliminaEspacios(form.derivadopor.value);
	var sexo=form.sexo.value;
	var prevision=eliminaEspacios(form.prevision.value);
	var alergia=eliminaEspacios(form.alergiaa.value);
	var seguroSalud=form.seguroSalud.value;
	var cantAlergias=form.cantAlergias.value;
	
	var controlAlergias = document.getElementsByName('alergia');
	
	var controlComentario = document.getElementsByName('comentario');
	var comentario=new Array();
	var alergias=new Array();
	alergiasTickeadas=0;
	for(i=0;i<controlAlergias.length;i=i+1)
	{
		if(controlAlergias[i].checked)
		{
			alergias[alergiasTickeadas]=controlAlergias[i].value;
			comentario[alergiasTickeadas]=controlComentario[i].value;
			alergiasTickeadas=alergiasTickeadas+1;
		}
	}
	if(!validaLongitud(run, 0, 7, 10)) campoError(form.run);
	if(!validaLongitud(nombre, 0, 2, 50)) campoError(form.nombre); 
	if(!validaLongitud(apellidop, 0, 2, 50)) campoError(form.apellidop);
	if(!validaLongitud(apellidom, 1, 2, 50)) campoError(form.apellidom);
	
	if(!validaLongitud(codigoC, 0, 1, 4)) campoError(form.codigoC);
	if(!validaLongitud(numeroC, 0, 5, 8)) campoError(form.numeroC);
	
	if(!validaLongitud(codigoCel, 1, 0, 3)) campoError(form.codigoCel);
	if(!validaLongitud(numeroCel, 1, 6, 9)) campoError(form.numeroCel);
	
	if(!validaLongitud(dia, 1, 1, 2)) campoError(form.dia);
	if(!validaLongitud(mes, 1, 1, 2)) campoError(form.mes);
	if(!validaLongitud(ano, 1, 3, 5)) campoError(form.ano);
	
	if(!validaLongitud(diaCita, 1, 1, 2)) campoError(form.diaPrimeraCita);
	if(!validaLongitud(mesCita, 1, 1, 2)) campoError(form.mesPrimeraCita);
	if(!validaLongitud(anoCita, 1, 3, 5)) campoError(form.anoPrimeraCita);
	
	if(!validaLongitud(direccion, 1, 8, 255)) campoError(form.direccion);
	if(correo!="")
		if(!validaCorreo(correo)) campoError(form.email);
	
	if(prevision=="") campoError(form.prevision);
	if(!validaLongitud(ocupacion, 1, 1, 100)) campoError(form.ocupacion);
	if(!validaLongitud(derivadopor, 1, 1, 100)) campoError(form.derivadopor);
		
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
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
		var texto = "id=1&run="+run+"&nombre="+nombre+"&apellidop="+apellidop+"&apellidom="+apellidom+"&telefono="+telefono+"&celular="+celular+"&fechanac="+fechanac+"&fechaPrimeraCita="+fechaPrimeraCita+"&direccion="+direccion+"&correo="+correo+"&ocupacion="+ocupacion+"&derivadopor="+derivadopor+"&sexo="+sexo+"&prevision="+prevision+"&cantalergia="+alergiasTickeadas+"&alergia="+alergia+"&seguroSalud="+seguroSalud;
		
		for(j=0;j<alergiasTickeadas;j++)
			texto = texto + "&alergia" + j + "=" + alergias[j] + "&comentario" + j + "=" + comentario[j];
			
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				respuesta_array = respuesta.split("&");
				if(respuesta_array[0]=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Paciente guardado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					form.reset();
				}
				else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}
	}
}

function validaFormCorto()
{
	limpiaForm(5);
	error=0;
	var run=eliminaEspacios(form.run.value);
	var nombre=eliminaEspacios(form.nombre.value);
	var apellidop=eliminaEspacios(form.apellidop.value);
	var apellidom=eliminaEspacios(form.apellidom.value);
	
	var codigoC=eliminaEspacios(form.codigoC.value);
	var numeroC=eliminaEspacios(form.numeroC.value);
	var telefono = codigoC+"-"+numeroC
	var prevision=eliminaEspacios(form.prevision.value);

	if(!validaLongitud(run, 0, 7, 10)) campoError(form.run);
	if(!validaLongitud(nombre, 0, 2, 50)) campoError(form.nombre); 
	if(!validaLongitud(apellidop, 0, 2, 50)) campoError(form.apellidop);
	if(!validaLongitud(apellidom, 1, 2, 50)) campoError(form.apellidom);
	
	if(!validaLongitud(codigoC, 0, 1, 4)) campoError(form.codigoC);
	if(!validaLongitud(numeroC, 0, 5, 8)) campoError(form.numeroC);
	
	if(prevision=="") campoError(form.prevision);
	
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
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
		ajax.open("POST", urlDestino2, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=1&run="+run+"&nombre="+nombre+"&apellidop="+apellidop+"&apellidom="+apellidom+"&telefono="+telefono+"&prevision="+prevision;
			
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				respuesta_array = respuesta.split("&");
				if(respuesta_array[0]=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Paciente guardado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					muestraMensaje(texto);
				        window.opener.buscarRut(window.opener.formularioID);
					window.close();	
				}
				else 
				{
					var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					muestraMensaje(texto);
				}
			}
		}
	}
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

function calEdadFicha(fecha){
    hoy=new Date();
    array_fechaCompleta = fecha.split(" ");
	array_fecha = array_fechaCompleta.split("-");
	ano=array_fecha[0];
	mes=array_fecha[1];
	dia=array_fecha[2];
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
	
	return edad;
} 
