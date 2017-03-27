function perfilSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"nombre": $("#txtNombre").val(),
		"objetivo": $("#txtObjetivo").val(),
		"reporta": $("#txtReporta").val(),
<<<<<<< HEAD
		"tareas": $("#txtTareas").val()
=======
		"tareas": $("#txtTareas").val(),
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	}
	return datos;
}

function perfilLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
<<<<<<< HEAD
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='perfilEditar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td><td>" + this.objetivo + "</td><td>" + this.reporta + "</td><td>" + this.tareas + "</td></tr>");
=======
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='editar(this)'><td>" + this.id + "</td><td>" + this.nombre + "</td><td>" + this.objetivo + "</td><td>" + this.reporta + "</td><td>" + this.tareas + "</td></tr>");
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
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
<<<<<<< HEAD
	perfilLimpiar(true);
=======
	limpiar(true);
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
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
<<<<<<< HEAD
	perfilAgregar();
=======
	agregar();
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
}

function perfilEliminar() {
	var datos = perfilSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/perfil/" + datos.id, perfilListar);
<<<<<<< HEAD
		perfilAgregar();
=======
		agregar();
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
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
