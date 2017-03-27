function actividadClaveSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
  }
	return datos;
}

function actividadClaveLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='editar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td></tr>");
	});
}

function actividadClaveLimpiar(actividadClaveTipo) {
	$("#txtID").val("");
	ajaxGet(urlApi + "/actividadClave");
	if(actividadClaveTipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function actividadClaveAgregar() {
	actividadClaveLimpiar(true);
}

function actividadClaveListar() {
	ajaxGet(urlApi + "/actividadClave", actividadClaveLlenaTabla);
}

function actividadClaveEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
	$("#txtDefinicion").val($(oFila).find("td")[2].innerHTML);
}

function actividadClaveRegistrar() {
	var datos = actividadClaveSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/actividadClave/" + datos.id, datos, actividadClaveListar);
	} else {
		ajaxPost(urlApi + "/actividadClave", datos, actividadClaveListar);
	}
	actividadClaveAgregar();
}

function actividadClaveEliminar() {
	var datos = actividadClaveSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/actividadClave/" + datos.id, actividadClaveListar);
		actividadClaveAgregar();
	}
}

function actividadClaveCargar() {
	$("#divContenido").load("actividadClave.html", function() {
		actividadClaveListar();
		actividadClaveLimpiar(true);
		$(".titulo").html("actividadClave");
		$("nav.desplegable").css("left", "-200px");
	});
}
