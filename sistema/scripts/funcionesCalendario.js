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
	urlDestino="calendarioCitas.php";
	urlBusqueda="buscarPaciente.php";
	
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Ayuda"]="Click en '+' para agregar pacientes en esos horarios.";
	
	preCarga("imagenes/ok.gif", "imagenes/loading.gif", "imagenes/error.gif");
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
	var dia=eliminaEspacios(form.dia.value);
	var mes=eliminaEspacios(form.mes.value);
	var ano=eliminaEspacios(form.ano.value);
	
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
		fecha=dia+"/"+mes+"/"+ano;		
		var texto="<img src='imagenes/loading.gif' alt='Buscando'><br>Buscando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST", urlBusqueda, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id="+id+"&dato="+dato+"&fecha="+fecha;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				var array_respuesta = respuesta.split("&");
				var id=array_respuesta[0];
				
				if(id==0)
				{
					var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Paciente No encontrado.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button><button type='button' onclick=\"nuevoPaciente('"+fecha+"')\" style='width:100px; height:18px; font-size:10px;'>Nuevo Paciente</button>";
					muestraMensaje(texto);
				}
				else
				{
					muestraMensaje(respuesta);
				}
			}
		}
	}
}

function nuevoPaciente(fecha)
{
	var texto="<form><p>Paciente Nuevo</p><br /><table align=\"center\"><tr><td class=\"label\">Nombre</td><td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"nombre\"  /></td></tr><tr><td class=\"label\">Apellidos</td><td class=\"campo\"><input type=\"text\" class=\"inputNormal\" name=\"apellidos\" /></td><td></td></tr><tr><td class=\"label\">Telefono</td><td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"telefono\" /></td></tr><tr><td class=\"label\">Prevision</td><td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"prevision\" /></td></tr><tr><td class=\"label\">Rut</td><td class=\"campo\" colspan=\"2\"><input class=\"inputNormal\" type=\"text\" name=\"rut\" /></td></tr><tr><th class=\"label\">Consulta</th><th class=\"label\">Pabellon Sally</th><th class=\"label\">Pabellon Sandra</th></tr><tr><td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"1\" checked=\"ckecked\" /></td><td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"2\" /></td><td class=\"campo\"><input class=\"inputNormal\" type=\"radio\" name=\"atencion\" value=\"3\" /></td></tr><tr><td width=\"50%\"><b>Fecha:</b>"+fecha+"</td><td width=\"50%\"><b>Hora:</b> 	<select name=\"hora\" style=\"width: 50px;\"><option value=\"9\">9</option><option value=\"10\">10</option><option value=\"11\">11</option><option value=\"12\">12</option><option value=\"13\">13</option><option value=\"14\">14</option><option value=\"15\">15</option><option value=\"16\">16</option><option value=\"17\">17</option><option value=\"18\">18</option><option value=\"19\">19</option><option value=\"20\">20</option></select>:<select name=\"minutos\" style=\"width: 50px;\"><option value=\"00\">00</option><option value=\"10\">10</option><option value=\"20\">20</option><option value=\"30\">30</option><option value=\"40\">40</option><option value=\"50\">50</option></select></td></tr>								<tr><td><input type=\"hidden\" name=\"fecha\" value=\""+fecha+"\" /><!--<button type=\"button\" onclick=\"ocultaMensaje()\">Buscar Otro</button>--></td><td><button type=\"button\" onclick=\"guardarCitaSinPac(this.form)\">Aceptar</button></td><td><button type=\"button\" onclick=\"cancelarPac(this.form)\">Cancelar</button></td></tr></table></form>";
			muestraMensaje(texto);
}

function guardarCitaSinPac(formXX)
{
	alert("entro nuevo");
}

function cancelarPac(form)
{
	form.reset();
	ocultaMensaje();
}

function buscarIdPac(formB)
{
	totalPac = formB.totalPac.value;
	dato=0;
	for(i=0;i<totalPac;i++)
	{
		if(formB.pac[i].checked==true)
		{
			dato=formB.pac[i].value;
			break;
		}
	}
	fecha=formB.fecha.value;
	if(dato==0)
	{
		var texto="<img src=\"imagenes/error.gif\" alt=\"error\" align=\"center\" /><br />Debe seleccionar un paciente.<br /><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Buscando'><br>Buscando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST", urlBusqueda, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=4&dato="+dato+"&fecha="+fecha;
		ajax.send(texto);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				var array_respuesta = respuesta.split("&");
				var id=array_respuesta[0];
				if(id==0)
				{
					var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Paciente No encontrado.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button><button type='button' onclick='nuevoPaciente()' style='width:100px; height:18px; font-size:10px;'>Nuevo Paciente</button>";
					muestraMensaje(texto);
				}
				else
				{
					muestraMensaje(respuesta);
				}
			}
		}
	}
}


function guardarCita(formX)
{
	error=0;
	
	var idPaciente=formX.idPaciente.value;
	var fecha=formX.fecha.value;
	var tipoCita;
	for(i=0;i<3;i++)
		if(formX.atencion[i].checked==true)
		{
			tipoCita=formX.atencion[i].value;
			break;
		}
	var hora=formX.hora.value;
	var minutos=formX.minutos.value;
	var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
	
	var ajax=nuevoAjax();
	ajax.open("POST", "guardarCita.php", true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var texto = "idPaciente="+idPaciente+"&fecha="+fecha+"&hora="+hora+"&minutos="+minutos+"&tipoCita="+tipoCita;
	ajax.send(texto);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			var respuesta=ajax.responseText;
			muestraMensaje(respuesta);
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
