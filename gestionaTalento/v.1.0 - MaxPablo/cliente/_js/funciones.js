var urlApi = "http://localhost/aporta/gestionaTalento/v.1.0%20-%20MaxPablo/api/web";

$(document).ready(function() {
	
	$("#divMenu").click(function() { 
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
