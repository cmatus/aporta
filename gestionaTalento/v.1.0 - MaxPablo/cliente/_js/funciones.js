<<<<<<< HEAD
var urlApi = "http://138.197.7.205/gt/api/web";

$(document).ready(function() {

	$("#divMenu").click(function() {
=======
<<<<<<< HEAD
var urlApi = "http://138.197.7.205/gt/api/web";

$(document).ready(function() {

	$("#divMenu").click(function() {
=======
var urlApi = "http://localhost/aporta/gestionaTalento/v.1.0%20-%20MaxPablo/api/web";

$(document).ready(function() {
	
	$("#divMenu").click(function() { 
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
		$("nav.desplegable").css("left", ($("nav.desplegable").css("left") == "0px" ? "-200px" : "0px"));
	});
	$("#divOpciones").click(function() {
		$("aside.desplegable").css("height", ($("aside.desplegable").css("height") == "0px" ? "90px" : "0px"));
	});

	$("#accordion > li").click(function(){
		if(false == $(this).next().is(':visible')) {
			$('#accordion > ul').slideUp(300);
		}
		$(this).next().slideToggle(300);
	});
	$('#accordion > ul').hide();
	$('#accordion > ul:eq(0)').show();

<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> 6f3859679924d9573f378cb53ddf2232caf58b67
>>>>>>> 71addec6973524cbcda1680bc04bf31e2eeead96
});

/* Funciones Generales */

function ajaxGet(url, callback) {
	$.get(url).done(function(data){ callback(data); });
}

function ajaxPost(url, datos, callback) {
	$.post(url, datos).done(function(data){ callback(data); });
}

function ajaxPut(url, datos, callback) {
	$.ajax({
		url: url,
		data: datos,
		type: 'PUT',
		success: function(response) {
			//callback(data);
		}
	}).done(function(data){ callback(data); });
}

function ajaxDelete(url, callback) {
	$.ajax({
		url: url,
		type: 'DELETE',
		success: function(response) {
			//callback(data);
		}
	}).done(function(data){ callback(data); });
}
