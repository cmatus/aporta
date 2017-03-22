<head>
    <LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
	<script>
		
		var gsOpcion = new Array;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'REPORTES';
        lsOpcion[1] = 'Libro Existencias';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/LibroExistencias.php';
        gsOpcion[0] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'REPORTES';
        lsOpcion[1] = 'Libro Compras';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/LibroCompras.php';
        gsOpcion[1] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'INCONSISTENCIAS';
        lsOpcion[1] = 'Facturas faltantes';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/FacturasFaltantes.php';
        gsOpcion[2] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'INCONSISTENCIAS';
        lsOpcion[1] = 'Facturas sin embarque';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/FacturasSinEmbarque.php';
        gsOpcion[3] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'CORRECCION';
        lsOpcion[1] = 'Variación Porcentual';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/par_var_porcentual.php';
        gsOpcion[4] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'CORRECCION';
        lsOpcion[1] = 'Saldos iniciales';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/SaldosIniciales.php';
        gsOpcion[5] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'CORRECCION';
        lsOpcion[1] = 'Saldos finales';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/SaldosFinales.php';
        gsOpcion[6] = lsOpcion;
        
        var lsOpcion = new Array;
        lsOpcion[0] = 'CORRECCION';
        lsOpcion[1] = 'Corrección monetaria';
        lsOpcion[2] = '';
        lsOpcion[3] = 'http://www.stein.cl/philips/correccionmonetaria.php';
        gsOpcion[7] = lsOpcion;
        
		function CambiaOpcion(iOpcion){
			document.location.replace(gsOpcion[iOpcion][2] + gsOpcion[iOpcion][3]);
		}
		
		function CambiaColor(iObjeto,iColor){
			if(iColor==1){
				iObjeto.style.backgroundColor = "silver";
			} else{
				iObjeto.style.backgroundColor = "#f3f3f3";
			}
		}
		
		function Test(iEstado,iValor,iCount){
			
			try{
				var DivRef = document.getElementById('PopupDiv');
				var IfrRef = document.getElementById('DivShim');
			} catch(e){
			}
			
			if(iEstado){
				
				var liFilas = 0;
				
				lsHTML = ""
				lsHTML = lsHTML + "<HEAD>";
				lsHTML = lsHTML + "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
				lsHTML = lsHTML + "<LINK REL='stylesheet' TYPE='text/css' HREF='http://ww.stein.cl/sli/SLIStandar/include/estilo.css'>";
				lsHTML = lsHTML + "</HEAD>";
				lsHTML = lsHTML + "<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0>";
				lsHTML = lsHTML + "<table border='1' cellpadding='2' cellspacing='1' style='border-collapse:collapse' width=200 bgcolor='#f3f3f3'>";
				
				for(x=0;x<gsOpcion.length;x++){
					if(gsOpcion[x][0]==iValor){
						lsHTML = lsHTML + "<tr bgcolor='#f3f3f3' style='cursor:hand' onclick='CambiaOpcion(" + x + ")'><td>&nbsp;<b>" + gsOpcion[x][1] + "</b>&nbsp;</td></tr>";
						liFilas++;
					}
				}
				
				lsHTML = lsHTML + "</table>";
				lsHTML = lsHTML + "</body>";
				
				IfrRef.src = ""; //"javascript:" + String.fromCharCode(34) + lsHTML + String.fromCharCode(34) + ";";
				//IfrRef.src = "sli_menu_opcion.php?OPC=" + iValor;
				
				DivRef.style.display = "block";
				IfrRef.style.width = 200;
				IfrRef.style.height = ((liFilas*18)+2);
				IfrRef.style.top = (3 + document.body.scrollTop);
				
				IfrRef.style.left = ((iCount-1)*111)+3;
				IfrRef.style.zIndex = DivRef.style.zIndex - 1;
				IfrRef.style.display = "block";
				
				DivRef.style.top = IfrRef.style.top
				DivRef.style.left = IfrRef.style.left
				
				DivRef.style.width  = IfrRef.style.width;
				DivRef.style.height = IfrRef.style.height;
				
				DivRef.innerHTML = lsHTML;
				
			} else{
				DivRef.style.display = "none";
				IfrRef.style.display = "none";
			}
			
		}
		
	</script>
	<LINK REL="stylesheet" TYPE="text/css" HREF="include/estilo.css">
</head>
<div id="PopupDiv" style="position:absolute; top:10px; left:10px; display:none; z-index:100"></div>
<iframe id="DivShim" src="javascript:'';" scrolling="no" frameborder="0" style="position:absolute; top:0px; left:0px; display:none;"></iframe>
<body leftmargin=5 topmargin=5 rightmargin=5 bottommargin=5 onscroll="Test(false,0,0)" onclick="Test(false,0,0)"background="images/back_fac.jpg" bgproperties="fixed"></body>
