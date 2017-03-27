function indicadorSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
  }
	return datos;
}

function indicadorLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='indicadorEditar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td></tr>");
	});
}

function indicadorLimpiar(indicadorTipo) {
	$("#txtID").val("");
	if(indicadorTipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function indicadorAgregar() {
	indicadorLimpiar(true);
}

function indicadorListar() {
	ajaxGet(urlApi + "/indicador", indicadorLlenaTabla);
}

function indicadorEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
}

function indicadorRegistrar() {
	var datos = indicadorSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/indicador/" + datos.id, datos, indicadorListar);
	} else {
		ajaxPost(urlApi + "/indicador", datos, indicadorListar);
	}
	indicadorAgregar();
}

function indicadorEliminar() {
	var datos = indicadorSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/indicador/" + datos.id, indicadorListar);
		indicadorAgregar();
	}
}

function indicadorCargar() {
	$("#divContenido").load("indicador.html", function() {
		indicadorListar();
		indicadorLimpiar(true);
		$(".titulo").html("Indicador");
		$("nav.desplegable").css("left", "-200px");
	});
}
