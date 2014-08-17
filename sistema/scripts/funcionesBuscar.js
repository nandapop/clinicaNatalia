var tabsId=new Array();
tabsId['diagnostico']='diagnostico';
tabsId['prescripcion']='prescripcion';
// Declaro el ID del DIV que actuará como contenedor de los datos recibidos
var contenedor ='tabContenido';

onload=function () 
{
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo");
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	form=document.getElementById("formulario");
	urlDestino="buscarPaciente.php";
	
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
	ayuda["Sexo"] = "Seleccione sexo.";
	ayuda["Prevision"] = "Ingrese prevision del paciente";
	ayuda["AlergiaA"] = "Click en + para ver lista de alergias.";
	ayuda["Alergia"] = "Ingrese alergias del paciente, separadas por coma";
	ayuda["Ayuda"] = "Posicione el cursor sobre los nombres de los datos para conocer ayuda.";
	ayuda["ProximaVisita"] = "Fecha de la próxima visita";
	ayuda["UltimaVisita"] = "Fecha de la última visita realizada";
	preCarga("imagenes/ok.gif", "imagenes/loading.gif", "imagenes/error.gif");
	document.formulario.dato.focus();
}

/*function cambiarEstados(liden, iden)
{
	var lihtml = document.getElementById(liden);
	var elhtml = document.getElementById(iden);
	if (elhtml.style.display == 'block')
	{
		lihtml.style.display = 'none';
		elhtml.style.display = 'none';
	}
	else
	{
		elhtml.style.display = 'block';
		lihtml.style.display = 'block';
		lihtml.style.background = 'transparent';
		lihtml.style.border = 'none';
	}
}*/

function cambiarTipoBusqueda(radio)
{
	var rutBuscar = document.getElementById("rutBuscar");
	var nomApeBuscar = document.getElementById("nomApeBuscar");
	var completoBuscar = document.getElementById("completoBuscar");
		
	
	if (radio.value = "normal" && radio.checked == true)
	{
		rutBuscar.style.display = '';
		nomApeBuscar.style.display = '';
		completoBuscar.style.display = '';
	}
	else if (radio.value = "fecha")
	{
		rutBuscar.style.display = '';
		nomApeBuscar.style.display = 'none';
		completoBuscar.style.display = 'none';
	
	}
	/*else if (radio.value = "patologia")
	{
		rutBuscar.style.display = 'block';
	
	}
	*/
}

function buscarPac(form)
{
	errorBusqueda=0;
	var dato=eliminaEspacios(form.dato.value);
	
	var buscarPor;
	for(i=0;i<3;i++)
	{
		if(form.buscar[i].checked==true)
		{
			buscarPor=form.buscar[i].value;
			break;
		}
	}	
	if(!validaLongitud(dato, 0, 4,50))
	{
		campoError(form.dato);
		errorBusqueda=1;
	}
	
	if(errorBusqueda==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Ingrese datos a buscar.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		if(buscarPor=="rut")
			id=1;
		else
			if(buscarPor=="nombre")
				id=2;
			else
				if(buscarPor=="apellido")
					id=3;
				else
				{
					var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Busqueda erronea, vuelva a intentarlo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					muestraMensaje(texto);
					return false;
				}
		var texto="<img src='imagenes/loading.gif' alt='Buscando'><br>Buscando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id="+id+"&dato="+dato;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{

			if (ajax.readyState==4)
			{
				alert("aca");
				var respuesta=ajax.responseText;
				var array_respuesta = respuesta.split("&");
				ocultaMensaje();
				var id=array_respuesta[0];
				
				if(id==2)
				{
					var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Demasiados pacientes encontrados con esa busqueda.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					muestraMensaje(texto);
				}
				else
					if(id==0)
					{
						var texto="<img src='imagenes/error.gif' alt='Error'><br><br>No se encontro paciente.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
					muestraMensaje(texto);
					}
				else
				{
					form.idPaciente.value=array_respuesta[1];
					form.run.value=array_respuesta[2];
					form.nombre.value=array_respuesta[3];
					form.apellidop.value=array_respuesta[4];
					form.apellidom.value=array_respuesta[5];
					form.direccion.value=array_respuesta[6];
					telefono =array_respuesta[7].split("-");
					form.codigoC.value=telefono[0];
					form.numeroC.value=telefono[1];
					form.email.value=array_respuesta[8];
					fechanac=array_respuesta[9].split("-");
					dia=fechanac[2].split(" ");
					if(dia==00)
					{
						form.dia.value="";
						form.mes.value="";
						form.ano.value="";
					}
					else
					{
						form.dia.value=dia[0];
						form.mes.value=fechanac[1];
						form.ano.value=fechanac[0];
					}
					celular=array_respuesta[12].split("-");
					form.codigoCel.value=celular[0];
					form.numeroCel.value=celular[1]+array_respuesta[12];
					form.primeracita.value=array_respuesta[10];
					form.sexo.value=array_respuesta[11];
					form.prevision.value=array_respuesta[13];
					form.derivadopor.value=array_respuesta[15];
					form.ocupacion.value=array_respuesta[14];
					cambiaEstado('buscar');
					cambiaEstado('encontrado');
				}
			}
		}
	}
}

function calculoEdad()
{
	var dia = eliminaEspacios(form.dia.value);
	var mes = eliminaEspacios(form.mes.value);
	var ano = eliminaEspacios(form.ano.value);
	var fechanac = ano + "-" + mes + "-" + dia;
	form.edad.value = calEdadFicha(fechanac);
}

function calEdadFicha(fecha){
    hoy=new Date();
    array_fechaCompleta = fecha.split(" ");
	array_fecha = array_fechaCompleta[0].split("-");
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

function guardarCambios()
{
	var run = eliminaEspacios(form.run.value);
	var nombre = eliminaEspacios(form.nombre.value);
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
	var fechanac=ano+"-"+mes+"-"+dia;
	
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
	
	var alergia=eliminaEspacios(form.alergia.value);
	
	var seguroSalud=form.seguroSalud.value;
	
	var idPaciente=form.idPaciente.value;
	var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
	/*
	var texto = "run="+run+"<br>nombre="+nombre+"<br>apellidop="+apellidop+"<br>apellidom="+apellidom+"<br>telefono="+telefono+"<br>celular="+celular+"<br>fechanac="+fechanac+"<br>direccion="+direccion+"<br>correo="+correo+"<br>ocupacion="+ocupacion+"<br>derivadopor="+derivadopor+"<br>alergia=<br><br><img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button  style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
muestraMensaje(texto);*/
	
	var ajax=nuevoAjax();
	ajax.open("POST","ingresarPaciente.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var texto = "id=2&run="+run+"&nombre="+nombre+"&apellidop="+apellidop+"&apellidom="+apellidom+"&telefono="+telefono+"&celular="+celular+"&fechanac="+fechanac+"&fechaPrimeraCita="+fechaPrimeraCita+"&direccion="+direccion+"&correo="+correo+"&ocupacion="+ocupacion+"&derivadopor="+derivadopor+"&sexo="+sexo+"&prevision="+prevision+"&idPaciente="+idPaciente+"&alergia="+alergia+"&seguroSalud="+seguroSalud;	
	ajax.send(texto);
	
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			if(respuesta=="OK")
			{
				var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Paciente actualizado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				form.edad.value = calEdadFicha(fechanac);
			}
			else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
			
			muestraMensaje(texto);
		}
	}
}

/*****************/
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
	ajax.open("POST", "tabsAgregarFicha.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	if (seccion == 'diagnostico')
	{
		var idPaciente = document.getElementById('idPaciente').value;
		var fecha=document.getElementById('fecha').value;
		var texto = "seccion="+seccion+"&idPaciente="+idPaciente+"&fecha="+fecha;
		ajax.send(texto);
	}	
	else if (seccion == 'prescripcion')
	{
		var idPaciente = document.getElementById('idPaciente').value;
		var fecha=document.getElementById('fecha').value;
		var texto = "seccion="+seccion+"&idPaciente="+idPaciente+"&fecha="+fecha;
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
}

function guardarPrescripcion()
{
	var form = document.getElementById("ingresarPrescripcion");
//	var medicamento = form.medicamento.value;
	var indicaciones = form.indicaciones.value;
	var idPaciente = form.idPaciente.value;
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor = document.getElementById("listadoDiagnosticosViejos");
	tabContenedor.innerHTML = '<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "agregarPrescripcion.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "indicaciones=" + indicaciones + "&idPaciente=" + idPaciente;
	form.indicaciones.value = "";
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedor.innerHTML = ajax.responseText;
		}
	}
}

function borrarPrescripcion(i)
{
	tabContenedor = document.getElementById("listadoDiagnosticosViejos");
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "quitarPrescripcion.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "i=" + i;
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

function guardarDiagnostico()
{
	var form = document.getElementById("ingresarDiagnostico");
	var idPaciente = form.idPaciente.value;
	var diagnostico = form.diagnostico.value;
	var fecha = form.fecha.value;
	if(fecha == "")
	{
		return false;
	}
	form.diagnostico.value = "";
	form.fecha.value = "";
	tabContenedor = document.getElementById("listadoDiagnosticosViejos");
	// Coloco un mensaje mientras se reciben los datos
	tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "ingresarDiagnosticoViejo.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idPaciente=" + idPaciente + "&diagnostico=" + diagnostico + "&fecha=" + fecha;
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

// Para solo mostrar uno a la vez objetivo se muestra y otro se oculta.
function cambiaEstadoUnico(objetivo, otro)
{	
	var form = document.getElementById("ingresarDiagnostico");
	var idPaciente = form.idPaciente.value;
	
	tabContenedor = document.getElementById("historialDiv");
	// Coloco un mensaje mientras se reciben los datos
	// tabContenedor.innerHTML='<img src="imagenes/loading.gif" /> Cargando, por favor espere...';
	
	// Creo el objeto AJAX y envio la petición por POST (para evitar cacheos de datos)
	var ajax=nuevoAjax();
	ajax.open("POST", "verHistorial.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idPaciente=" + idPaciente;
	ajax.send(texto);
	
	
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState == 4)
		{
			// Al recibir la respuesta coloco directamente el HTML en la capa contenedora
			tabContenedor.innerHTML=ajax.responseText;
			var objhtml = document.getElementById(objetivo);
			var otrhtml = document.getElementById(otro);
			if (objhtml.style.display == 'block')
			{
				objhtml.style.display = 'none';
			}
			else
			{
				objhtml.style.display = 'block';
				otrhtml.style.display = 'none';
			}
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

function eliminarCita(idCita)
{
	var agree = confirm("¿Realmente desea eliminar la cita? ");
	if (agree)
	{
		var form = document.getElementById("ingresarDiagnostico");
		var idPaciente = form.idPaciente.value;
		tabContenedor = document.getElementById("historialDiv");
		var ajax=nuevoAjax();
		ajax.open("POST", "eliminarCita.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
		var texto = "idPaciente=" + idPaciente + "&idCita=" + idCita;
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
}

function modificarFechaCitaVieja(idCita)
{
	var nombreFormulario = "frmModificarFechaCitaVieja" + idCita;
	var form = document.getElementById(nombreFormulario);
	var dia = form.diaCitaVieja.value;
	var mes = form.mesCitaVieja.value;
	var ano = form.anoCitaVieja.value;
	var fecha = ano + "-" + mes + "-" + dia;
	tabContenedor = document.getElementById("historialDiv");
	var ajax=nuevoAjax();
	ajax.open("POST", "modificarFechaCitaVieja.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	var texto = "idCita=" + idCita + "&fecha=" + fecha;
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

function imprimirFicha()
{
	idPaciente = document.getElementById('idPaciente').value;
	window.open('imprimirFicha.php?idPaciente='+idPaciente,'mywin4','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=yes');
	parent.opener=top;
}

function eliminarPaciente(idPaciente){
	var texto = "idpaciente="+idPaciente;
	var ajax = nuevoAjax();
	ajax.open("POST", "eliminarPaciente.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			if(respuesta=="OK")
			{
				var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Paciente eliminado con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='recargarPagina()' type='button'>Ok</button>";
			}
			else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='recargarPagina()' type='button'>Ok</button>";
			
			muestraMensaje(texto);
		}
	}
}

function recargarPagina()
{
	location.href='buscar.php';
}