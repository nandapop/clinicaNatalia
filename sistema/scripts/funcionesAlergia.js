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
	urlDestino="ingresarAlergia.php";
	
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Nombre"] = "Ingrese nombre de la alergia. OBLIGATORIO";
	ayuda["Descripcion"] = "Ingresa descripcion. De 4 a 500 caracteres.";	
	preCarga("imagenes/ok.gif", "imagenes/loading.gif", "imagenes/error.gif");
}

function validaForm()
{
	limpiaForm(2);
	error=0;
	var nombreAlergia=eliminaEspacios(form.nombrealergia.value);
	var descripcion=eliminaEspacios(form.descripcion.value);
	if(!validaLongitud(nombreAlergia, 0, 4, 30)) campoError(form.nombrealergia);
	if(!validaLongitud(descripcion, 1, 4, 500)) camporError(form.descripcion);
	
	if(error==1)
	{
		var texto="<img src='imagenes/error.gif' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		var texto="<img src='imagenes/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br>";
		muestraMensaje(texto);
		var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var texto = "id=1&nombrealergia="+nombreAlergia+"&descripcion="+descripcion;
		
		ajax.send(texto);
		
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					var texto="<img src='imagenes/ok.gif' alt='Ok'><br>Alergia guardada con exito.<br><br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				}
				else var texto="<img src='imagenes/error.gif'><br><br>Error: "+respuesta+".<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}
	}
}
