function perfilSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
		"objetivo": $("#txtObjetivo").val(),
		"reporta": $("#txtReporta").val(),
		"tareas": $("#txtTareas").val()
	}
	return datos;
}

function perfilLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='perfilEditar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td><td>" + this.objetivo + "</td><td>" + this.reporta + "</td><td>" + this.tareas + "</td></tr>");
	});
}

function perfilLimpiar(tipo) {
	$("#txtObjetivo").val("");
	$("#txtReporta").val("");
	$("#txtTareas").val("");
	$("#txtID").val("");
	if(tipo) {
		$("#txtNombre").val("");
		$("#txtNombre").focus();
	}
}

function perfilAgregar() {
	perfilLimpiar(true);
}

function perfilListar() {
	ajaxGet(urlApi + "/perfil", perfilLlenaTabla);
}

function perfilEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtNombre").val($(oFila).find("td")[1].innerHTML);
  $("#txtObjetivo").val($(oFila).find("td")[2].innerHTML);
	$("#txtReporta").val($(oFila).find("td")[3].innerHTML);
	$("#txtTareas").val($(oFila).find("td")[4].innerHTML);
}

function perfilRegistrar() {
	var datos = perfilSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/perfil/" + datos.id, datos, perfilListar);
	} else {
		ajaxPost(urlApi + "/perfil", datos, perfilListar);
	}
	perfilAgregar();
}

function perfilEliminar() {
	var datos = perfilSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/perfil/" + datos.id, perfilListar);
		perfilAgregar();
	}
}

function perfilCargar() {
	$("#divContenido").load("perfil.html", function() {
		perfilListar();
		perfilLimpiar(true);
		$(".titulo").html("Perfil");
		$("nav.desplegable").css("left", "-200px");
	});
}
