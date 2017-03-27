function criterioSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
  }
	return datos;
}

function criterioLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='criterioEditar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td></tr>");
	});
}

function criterioLimpiar(criterioTipo) {
	$("#txtID").val("");
	if(criterioTipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function criterioAgregar() {
	criterioLimpiar(true);
}

function criterioListar() {
	ajaxGet(urlApi + "/criterio", criterioLlenaTabla);
}

function criterioEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
}

function criterioRegistrar() {
	var datos = criterioSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/criterio/" + datos.id, datos, criterioListar);
	} else {
		ajaxPost(urlApi + "/criterio", datos, criterioListar);
	}
	criterioAgregar();
}

function criterioEliminar() {
	var datos = criterioSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/criterio/" + datos.id, criterioListar);
		criterioAgregar();
	}
}

function criterioCargar() {
	$("#divContenido").load("criterio.html", function() {
		criterioListar();
		criterioLimpiar(true);
		$(".titulo").html("Criterio");
		$("nav.desplegable").css("left", "-200px");
	});
}
