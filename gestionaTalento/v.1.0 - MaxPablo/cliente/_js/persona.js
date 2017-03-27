function personaSerializar() {
	var datos = {
		"id": $("#txtID").val(),
		"rut": $("#txtRut").val(),
		"nombre": $("#txtNombre").val(),
		"apellidoPaterno": $("#txtApellidoPaterno").val(),
		"apellidoMaterno": $("#txtApellidoMaterno").val(),
		"correo": $("#txtCorreo").val(),
		"perfilId": $("#cmbPerfil").val()
	}
	return datos;
}

function personaLlenaTabla(oData) {
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='editar(this)'><td>" + this.id + "</td><td>" + this.rut + "</td><td><input type='hidden' value='" + this.nombre + "@" + this.apellido_paterno + "@" + this.apellido_materno + "'>" + this.nombre + " " + this.apellido_paterno + " " + this.apellido_materno + "</td><td>" + this.correo + "</td><td>" + this.perfil_id + "</td></tr>");
	});
}

function personaLlenaCombo(oData) {
	$("#cmbPerfil option").remove();
	$("#cmbPerfil").append("<option value=''>:: Seleccione Perfil ::</option>");
	$(oData).each(function() {
		$("#cmbPerfil").append("<option value='" + this.id + "'>" + this.nombre + "</option>");
	});
}

function personaLimpiar(tipo) {
	$("#txtNombre").val("");
	$("#txtApellidoPaterno").val("");
	$("#txtApellidoMaterno").val("");
	$("#txtCorreo").val("");
	$("#cmbPerfil").val("");
	$("#txtID").val("");
	ajaxGet(urlApi + "/perfil", personaLlenaCombo);
	if(tipo) {
		$("#txtRut").val("");
		$("#txtRut").focus();
	}
}

function personaAgregar() {
	limpiar(true);
}

function personaListar() {
	ajaxGet(urlApi + "/persona", personaLlenaTabla);
}

function personaEditar(oFila) {
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtRut").val($(oFila).find("td")[1].innerHTML);
	$("#txtNombre").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[0]);
	$("#txtApellidoPaterno").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[1]);
	$("#txtApellidoMaterno").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[2]);
	$("#txtCorreo").val($(oFila).find("td")[3].innerHTML);
	$("#cmbPerfil").val($(oFila).find("td")[4].innerHTML);
}

function personaRegistrar() {
	var datos = personaSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/persona/" + datos.id, datos, personaListar);
	} else {
		ajaxPost(urlApi + "/persona", datos, personaListar);
	}
	agregar();
}

function personaEliminar() {
	var datos = personaSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/persona/" + datos.id, personaListar);
		agregar();
	}
}

function personaCargar() {
	$("#divContenido").load("persona.html", function() {
		personaListar();
		personaLimpiar(true);
		$(".titulo").html("Persona");
		$("nav.desplegable").css("left", "-200px");
	});
}
