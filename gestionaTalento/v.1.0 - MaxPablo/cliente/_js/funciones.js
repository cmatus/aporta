$( document ).ready(function() {
	$("#divMenu").click(function() { 
		$("nav.desplegable").css("left", ($("nav.desplegable").css("left") == "0px" ? "-150px" : "0px"));
	});
	$("#divOpciones").click(function() { 
		$("aside.desplegable").css("height", ($("aside.desplegable").css("height") == "0px" ? "90px" : "0px"));
	});
});