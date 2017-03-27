function competenciaConductualSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
    "definicion": $("#txtDefinicion").val()
  }
	return datos;
}

function competenciaConductualLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='competenciaConductualEditar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td><td>" + this.definicion + "</td></tr>");
	});
}

function competenciaConductualLimpiar(competenciaConductualTipo) {
	$("#txtDefinicion").val("");
	$("#txtID").val("");
	if(competenciaConductualTipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function competenciaConductualAgregar() {
	competenciaConductualLimpiar(true);
}

function competenciaConductualListar() {
	ajaxGet(urlApi + "/competenciaConductual", competenciaConductualLlenaTabla);
}

function competenciaConductualEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
	$("#txtDefinicion").val($(oFila).find("td")[2].innerHTML);
}

function competenciaConductualRegistrar() {
	var datos = competenciaConductualSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/competenciaConductual/" + datos.id, datos, competenciaConductualListar);
	} else {
		ajaxPost(urlApi + "/competenciaConductual", datos, competenciaConductualListar);
	}
	competenciaConductualAgregar();
}

function competenciaConductualEliminar() {
	var datos = competenciaConductualSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/competenciaConductual/" + datos.id, competenciaConductualListar);
		competenciaConductualAgregar();
	}
}

function competenciaConductualCargar() {
	$("#divContenido").load("competenciaConductual.html", function() {
		competenciaConductualListar();
		competenciaConductualLimpiar(true);
		$(".titulo").html("Competencia Conductual");
		$("nav.desplegable").css("left", "-200px");
	});
}
