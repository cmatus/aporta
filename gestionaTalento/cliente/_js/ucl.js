function uclSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
    "nombre": $("#txtDefinicion").val()
  }
	return datos;
}

function uclLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='editar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td><td>" + this.definicion + "</td></tr>");
	});
}

function uclLimpiar(uclTipo) {
	$("#txtDefinicion").val("");
	$("#txtID").val("");
	ajaxGet(urlApi + "/perfil");
	if(uclTipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function uclAgregar() {
	uclLimpiar(true);
}

function uclListar() {
	ajaxGet(urlApi + "/ucl", uclLlenaTabla);
}

function uclEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
	$("#txtDefinicion").val($(oFila).find("td")[2].innerHTML);
}

function uclRegistrar() {
	var datos = uclSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/ucl/" + datos.id, datos, uclListar);
	} else {
		ajaxPost(urlApi + "/ucl", datos, uclListar);
	}
	uclAgregar();
}

function uclEliminar() {
	var datos = uclSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/ucl/" + datos.id, uclListar);
		uclAgregar();
	}
}

function uclCargar() {
	$("#divContenido").load("ucl.html", function() {
		uclListar();
		uclLimpiar(true);
		$(".titulo").html("ucl");
		$("nav.desplegable").css("left", "-200px");
	});
}
