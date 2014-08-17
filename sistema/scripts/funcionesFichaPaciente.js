// JavaScript Document

function actualizarPaciente(formDP)
{
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	
	var idPaciente = document.getElementById('idPaciente').value;
	var run = eliminaEspacios(formDP.run.value);
	var sexo=formDP.sexo.value;
	var nombre = eliminaEspacios(formDP.nombre.value);
	var apellidos = eliminaEspacios(formDP.apellidoPM.value).split(",");
	
	var apellidop = eliminaEspacios(apellidos[0]);
	var apellidom = eliminaEspacios(apellidos[1]);
	
	var telefono = eliminaEspacios(formDP.telefono.value);
	var celular = eliminaEspacios(formDP.celular.value);	
	
	var direccion = eliminaEspacios(formDP.direccion.value);
	var ocupacion = eliminaEspacios(formDP.ocupacion.value);

	var fechanacCompleta = eliminaEspacios(formDP.fechanac.value).split(",");
	var fechanacSlash = fechanacCompleta[0].split("/");
	var fechanac = fechanacSlash[2]+"-"+fechanacSlash[1]+"-"+fechanacSlash[0];
	
	var correo=eliminaEspacios(formDP.email.value);
	var derivadopor=eliminaEspacios(formDP.derivadopor.value);
	var prevision=eliminaEspacios(formDP.prevision.value);
	var alergia=eliminaEspacios(formDP.alergia.value);
	var seguroSalud=eliminaEspacios(formDP.seguroSalud.value);
	
	var fechaPrimeraCitaS = eliminaEspacios(formDP.primeracita.value).split("/");
	var fechaPrimeraCita = fechaPrimeraCitaS[2]+"-"+fechaPrimeraCitaS[1]+"-"+fechaPrimeraCitaS[0];
	

	var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
	muestraMensaje(texto);
	/*
	var texto = "run="+run+"<br>nombre="+nombre+"<br>apellidop="+apellidop+"<br>apellidom="+apellidom+"<br>telefono="+telefono+"<br>celular="+celular+"<br>fechanac="+fechanac+"<br>direccion="+direccion+"<br>correo="+correo+"<br>ocupacion="+ocupacion+"<br>derivadopor="+derivadopor+"<br>alergia="+alergia+"<br>prevision="+prevision+"<br>fechaPrimeraCita="+fechaPrimeraCita+"<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button  style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
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
			}
			else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
			
			muestraMensaje(texto);
		}
	}
}


function imprimirFicha()
{
	idPaciente = document.getElementById('idPaciente').value;
	window.open('imprimirFicha.php?idPaciente='+idPaciente,'mywin4','width=800,height=600,top=0,left=0,menubar=no,menubar=no,scrollbars=yes,status=no,toolbar=no,location=no,directories=no,resizable=yes');
	parent.opener=top;
}
/*
function imprimirFicha(formPF)
{
	var idPaciente = eliminaEspacios(formPF.idPaciente.value);
}*/

