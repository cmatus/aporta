<<<<<<< HEAD
function personaSerializar() {
=======
<<<<<<< HEAD
function personaSerializar() {
=======
function serializar() {
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
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

<<<<<<< HEAD
function personaLlenaTabla(oData) {
=======
<<<<<<< HEAD
function personaLlenaTabla(oData) {
=======
function llenaTabla(oData) {
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	$("#tabData tr.item").remove();
	$(oData).each(function() {
		$("#tabData").append("<tr class='item' style='cursor:pointer' onclick='personaEditar(this)'><td>" + this.id + "</td><td>" + this.rut + "</td><td><input type='hidden' value='" + this.nombre + "@" + this.apellido_paterno + "@" + this.apellido_materno + "'>" + this.nombre + " " + this.apellido_paterno + " " + this.apellido_materno + "</td><td>" + this.correo + "</td><td>" + this.perfil_id + "</td></tr>");
	});
}

<<<<<<< HEAD
function personaLlenaCombo(oData) {
=======
<<<<<<< HEAD
function personaLlenaCombo(oData) {
=======
function llenaCombo(oData) {
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	$("#cmbPerfil option").remove();
	$("#cmbPerfil").append("<option value=''>:: Seleccione Perfil ::</option>");
	$(oData).each(function() {
		$("#cmbPerfil").append("<option value='" + this.id + "'>" + this.nombre + "</option>");
<<<<<<< HEAD
	});
}

function personaLimpiar(personaTipo) {
=======
<<<<<<< HEAD
	});
}

function personaLimpiar(tipo) {
=======
	});	
}

function limpiar(tipo) {
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	$("#txtNombre").val("");
	$("#txtApellidoPaterno").val("");
	$("#txtApellidoMaterno").val("");
	$("#txtCorreo").val("");
	$("#cmbPerfil").val("");
	$("#txtID").val("");
<<<<<<< HEAD
	ajaxGet(urlApi + "/perfil", personaLlenaCombo);
	if(personaTipo) {
=======
<<<<<<< HEAD
	ajaxGet(urlApi + "/perfil", personaLlenaCombo);
=======
	ajaxGet(urlApi + "/perfil", llenaCombo);
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
	if(tipo) {
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
		$("#txtRut").val("");
		$("#txtRut").focus();
	}
}

<<<<<<< HEAD
function personaAgregar() {
	personaLimpiar(true);
=======
<<<<<<< HEAD
function personaAgregar() {
	limpiar(true);
}

function personaListar() {
	ajaxGet(urlApi + "/persona", personaLlenaTabla);
}

function personaEditar(oFila) {
=======
function agregar() {
	limpiar(true);
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
}

function personaListar() {
	ajaxGet(urlApi + "/persona", personaLlenaTabla);

}

<<<<<<< HEAD
function personaEditar(oFila) {
=======
function editar(oFila) {
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	$("#txtID").val($(oFila).find("td")[0].innerHTML);
	$("#txtRut").val($(oFila).find("td")[1].innerHTML);
	$("#txtNombre").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[0]);
	$("#txtApellidoPaterno").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[1]);
	$("#txtApellidoMaterno").val($($(oFila).find("td")[2]).find("input")[0].value.split("@")[2]);
	$("#txtCorreo").val($(oFila).find("td")[3].innerHTML);
	$("#cmbPerfil").val($(oFila).find("td")[4].innerHTML);
}

<<<<<<< HEAD
function personaRegistrar() {
	var datos = personaSerializar();
=======
<<<<<<< HEAD
function personaRegistrar() {
	var datos = personaSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/persona/" + datos.id, datos, personaListar);
	} else {
		ajaxPost(urlApi + "/persona", datos, personaListar);
=======
function registrar() {
	var datos = serializar();
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	if(parseInt(datos.id) > 0) {
		ajaxPut(urlApi + "/persona/" + datos.id, datos, personaListar);
	} else {
<<<<<<< HEAD
		ajaxPost(urlApi + "/persona", datos, personaListar);
=======
		ajaxPost(urlApi + "/persona", datos, listar);
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	}
	personaAgregar();
}

<<<<<<< HEAD
function personaEliminar() {
	var datos = personaSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/persona/" + datos.id, personaListar);
		personaAgregar();
=======
<<<<<<< HEAD
function personaEliminar() {
	var datos = personaSerializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/persona/" + datos.id, personaListar);
=======
function eliminar() {
	var datos = serializar();
	if(parseInt(datos.id) > 0) {
		ajaxDelete(urlApi + "/persona/" + datos.id, listar);
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
		agregar();
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
	}
}

function personaCargar() {
<<<<<<< HEAD
	$("#divContenido").load("persona.html", function() {
		personaListar();
		personaLimpiar(true);
=======
<<<<<<< HEAD
	$("#divContenido").load("persona.html", function() {
		personaListar();
		personaLimpiar(true);
		$(".titulo").html("Persona");
		$("nav.desplegable").css("left", "-200px");
	});
}
=======
	$("#divContenido").load("persona.html", function() { 
		listar(); 
		limpiar(true);
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
		$(".titulo").html("Persona");
		$("nav.desplegable").css("left", "-200px");
	});
}
<<<<<<< HEAD

/* Empresa */

function personaEmpresaMostrar() { // Solicita a la API las empresas (todas)
	ajaxGet(urlApi + "/empresa", personaEmpresaLlenaLista);
}

function personaEmpresaLlenaLista(oData) { // Despliega lAs empresas solicitadas a la API
$("#ulEmpresa ul").remove();
	$(oData).each(function() {
		$("#ulEmpresa").append("<li><input type='checkbox' id='" + this.id + "'>" + this.razon_social + " </li>");
	});
}

function personaEmpresaAsignar() {
	// Selecciona todos los checkbox "checkeados" que estén dentro de "ulEmpresa"
	var jsonEmpresas = [];
	$("#ulEmpresa").find("input[type='checkbox']:checked").each(function () {
		jsonEmpresas.push($(this).attr("id"))
	});
	if(jsonEmpresas.length > 0) {
		for(var x = 0; x < jsonEmpresas.length; x++) {
			datos = { 'empresaId': jsonEmpresas[x] }
			ajaxPost(urlApi + "/persona/" + $("#txtID").val(), datos);
		}
	}
}

function personaEmpresaAsignarOK() {

}
=======
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
