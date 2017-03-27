$(document).ready(function(){

	/* Menú principal (Izquierdo) */
	$("#divMenu").click(function(){
		if($("nav.desplegable").css("left") == "0px") {
			$(this).css("transform", "rotate(0deg)");
			$("nav.desplegable").css("left", "-200px")
		} else {
			$(this).css("transform", "rotate(180deg)");
			$("nav.desplegable").css("left", "0px");
		}
	});

	/* Sub Menu (Izquierdo) */
	$("#accordion > li").click(function(){
		if(false == $(this).next().is(":visible")) {
			$("#accordion > ul").slideUp(300);
		}
		$(this).next().slideToggle(300);
	});
	$("#accordion > ul").hide();
	$("#accordion > ul:eq(0)").show();

	/* Menú derecho */
	$("#divOpciones").click(function(){
		if($("aside.desplegable").is(":hidden")) {
			$(this).css("transform", "rotate(360deg)");
		} else {
			$(this).css("transform", "rotate(0deg)");
		}
		$("aside.desplegable").slideToggle(300);
	});
	
})