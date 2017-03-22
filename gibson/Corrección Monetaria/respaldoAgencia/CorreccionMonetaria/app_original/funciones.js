// JavaScript Document

function redondear(cantidad, decimales){
    var cantidad = parseFloat(cantidad);
    var decimales = parseFloat(decimales);
    decimales = (!decimales ? 2 : decimales);
    return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
}

function ValidaFecha(myfield,e){
	
	var keycode;
	
	if(window.event){
		keycode = window.event.keyCode;
	} else{
		if(e){
			keycode = e.which;
		} else{
			return true;
		}
	}
	if(((keycode>47)&&(keycode<58))||(keycode==8)||(keycode==13)){
		if(myfield.value.length==2||myfield.value.length==5){
			myfield.value = myfield.value + "/";
		}
		return true;
	} else{
		return false;
	}

}

function VerificaNumero(iCode){
    if(iCode.keyCode<47||iCode.keyCode>57){
        iCode.returnValue = false;
    }
}

function KeyCheck(myfield,e){
	
	var keycode;
	
	if(window.event){
		keycode = window.event.keyCode;
	} else{
		if(e){
			keycode = e.which;
		} else{
			return true;
		}
	}
	if(((keycode>47)&&(keycode<58))||(keycode==8)||(keycode==46)||(keycode==13)){
		if(myfield.value.indexOf('.')!=-1&&keycode==46){
			return false;
		} else{
			return true;
		}
	} else{
		if(keycode==44){			
			if(myfield.value.indexOf('.')!=-1){
				return false;
			} else{
				window.event.keyCode=46;
				return true;
			}
		} else{
			return false;
		}
	}

}

function checkdate(objName){

	var datefield = objName;
	
	lsFec = datefield.value;
	if (chkdate(objName) == false){
		alert("Fecha Invalida");
		datefield.value=""
		datefield.focus();
		return false;
	}else{
	    if(lsFec.length<10&&lsFec.length>0){
    		alert("Fecha Invalida");
    		datefield.value=""
    		datefield.focus();
    		return false;
    	} else{
    	   return true;
        }
	}
	
}

function chkdate(objName){

	var strDatestyle = "US"; //United States date style
	var booFound     = false;
	var datefield    = objName;
	
	var strSeparatorArray = new Array("-"," ","/",".");
	var strMonthArray     = new Array(12);
	var strDayArray       = new Array(9);
	
	var strDate;
	var strDateArray;
	var strDay;
	var strMonth;
	var strYear;
	var intday;
	var intMonth;
	var intYear;	
	var intElementNr;
	
	var err = 0;

	strMonthArray[0]  = "01";
	strMonthArray[1]  = "02";
	strMonthArray[2]  = "03";
	strMonthArray[3]  = "04";
	strMonthArray[4]  = "05";
	strMonthArray[5]  = "06";
	strMonthArray[6]  = "07";
	strMonthArray[7]  = "08";
	strMonthArray[8]  = "09";
	strMonthArray[9]  = "10";
	strMonthArray[10] = "11";
	strMonthArray[11] = "12";

	strDate = datefield.value;

	strDayArray[0] = "01";
	strDayArray[1] = "02";
	strDayArray[2] = "03";
	strDayArray[3] = "04";
	strDayArray[4] = "05";
	strDayArray[5] = "06";
	strDayArray[6] = "07";
	strDayArray[7] = "08";
	strDayArray[8] = "09";

	if (strDate.length < 1) {
		return true;
	}

	for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {

		if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
			strDateArray = strDate.split(strSeparatorArray[intElementNr]);
			if (strDateArray.length != 3) {
				err = 1;
				return false;
			} else {
				strDay = strDateArray[0];
				strMonth = strDateArray[1];
				strYear = strDateArray[2];
			}
			booFound = true;
	   }
	   
	}

	if (booFound == false) {
		if (strDate.length>5) {
			strDay = strDate.substr(0, 2);
			strMonth = strDate.substr(2, 2);
			strYear = strDate.substr(4);
		} else {
			return false
		}
	}

	if (strYear.length == 2) {
		strYear = '20' + strYear;
	}

	intday = parseInt(strDay, 10);

	if (isNaN(intday)) {
		err = 2;
		return false;
	}

	intMonth = parseInt(strMonth, 10);

	if (isNaN(intMonth)) {
		for (i = 0;i<12;i++) {
			if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
				intMonth = i+1;
				strMonth = strMonthArray[i];
				i = 12;
			}
		}
		if (isNaN(intMonth)) {
			err = 3;
			return false;
		}
	}

	intYear = parseInt(strYear, 10);

	if (isNaN(intYear)) {
		err = 4;
		return false;
	}

	if (intMonth>12 || intMonth<1) {
		err = 5;
		return false;
	}

	if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
		err = 6;
		return false;
	}

	if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
		err = 7;
		return false;
	}

	if (intMonth == 2) {
		if (intday < 1) {
			err = 8;
			return false;
		}
		if (LeapYear(intYear) == true) {
			if (intday > 29) {
				err = 9;
				return false;
			}
		} else {
			if (intday > 28) {
				err = 10;
				return false;
			}
		}
	}

	if (intday < 10) {
		strDay = strDayArray[intday-1]
	} else {
		strDay = intday
	}

	return true;
	
}

function LeapYear(intYear) {

	if (intYear % 100 == 0) {
		if (intYear % 400 == 0) { return true; }
		} else {
		if ((intYear % 4) == 0) { return true; }
	}
	return false;
	
}

function TrimRight( str ) {
var resultStr = "";
var i = 0;
// Return immediately if an invalid value was passed in
if (str+"" == "undefined" || str == null) 
return null;
// Make sure the argument is a string
str += "";

if (str.length == 0) 
resultStr = "";
else {
// Loop through string starting at the end as long as there
// are spaces.
i = str.length - 1;
while ((i >= 0) && (str.charAt(i) == " "))
i--;

// When the loop is done, we're sitting at the last non-space char,
// so return that char plus all previous chars of the string.
resultStr = str.substring(0, i + 1);
}

return resultStr; 
}

function TrimLeft( str ) {
var resultStr = "";
var i = len = 0;
// Return immediately if an invalid value was passed in
if (str+"" == "undefined" || str == null) 
return null;
// Make sure the argument is a string
str += "";
if (str.length == 0) 
resultStr = "";
else { 
// Loop through string starting at the beginning as long as there
// are spaces.
// len = str.length - 1;
len = str.length;

while ((i <= len) && (str.charAt(i) == " "))
i++;
// When the loop is done, we're sitting at the first non-space char,
// so return that char plus the remaining chars of the string.
resultStr = str.substring(i, len);
}
return resultStr;
}



function Trim(str){
    var resultStr = "";
    resultStr = TrimLeft(str);
    resultStr = TrimRight(resultStr);
    return resultStr;
}

function getSelected(opt) {
    
    var selected = new Array();
    var index = 0;
    
    for (var intLoop = 0; intLoop < opt.length; intLoop++) {
        if((opt[intLoop].selected)||(opt[intLoop].checked)){
            index = selected.length;
            selected[index] = new Object;
            selected[index].value = opt[intLoop].value;
            selected[index].text  = opt[intLoop].text;
        }
    }
    return selected;
    
}

function findPosX(iObj){
	var curleft = 0;
	if (iObj.offsetParent)
	{
		while (iObj.offsetParent)
		{
			curleft += iObj.offsetLeft
			iObj = iObj.offsetParent;
		}
	}
	else if (iObj.x)
		curleft += iObj.x;
	return curleft;
}

function findPosY(iObj){
	var curtop = 0;
	if (iObj.offsetParent)
	{
		while (iObj.offsetParent)
		{
			curtop += iObj.offsetTop
			iObj = iObj.offsetParent;
		}
	}
	else if (iObj.y)
		curtop += iObj.y;
	return curtop;
}

function GeneraObjeto(iFun,iPag){
    
	try{
		xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
		new ActiveXObject("Microsoft.XMLHTTP");
	} catch(E){
	    // No se puede
	}
	
	xmlhttp.onreadystatechange = eval(iFun);
	xmlhttp.open("GET", iPag);
	xmlhttp.send(null);
    
}

function UbicaObjeto(iObj,iInto,iTipo){
    
    liCoord_X = findPosX(iInto)
    liCoord_Y = findPosY(iInto)
    
	switch(iTipo){
        case 0:
            iObj.style.left = parseInt(liCoord_X) + parseInt((iInto.offsetWidth-iObj.offsetWidth)/2);
        	iObj.style.top  = parseInt(liCoord_Y) + parseInt((iInto.offsetHeight-iObj.offsetHeight)/2);
        	break;
        case 1: /* Centro */
            iObj.style.left = parseInt(liCoord_X) + parseInt((iInto.clientWidth-iObj.offsetWidth)/2);
        	iObj.style.top  = document.body.scrollTop + parseInt((iInto.clientHeight-iObj.offsetHeight)/2);
        	break;
        case 2: /* Derecha */
            iObj.style.left = parseInt(liCoord_X) + parseInt(iInto.clientWidth) + 1;
        	iObj.style.top  = parseInt(liCoord_Y) + 1;
        	break;
    }
	
}

function Procesando(iTipo,iObj){
    
    liCoord_X = findPosX(iObj)
    liCoord_Y = findPosY(iObj)
    
    var lsHTML = "";
    if(iTipo==1){
        
        lsHTML = "";
        lsHTML = lsHTML + "<table cellpadding=1 cellspacing=0 border='1' style='border-collapse:collapse' bgcolor='white'>";
        lsHTML = lsHTML + "<tr height='60'><td align='center'><table cellpadding=0 cellspacing=0><tr><td>&nbsp;&nbsp;&nbsp;<img src='http://www.stein.cl/sli/slistandar/images/loading_1.gif'>&nbsp;&nbsp;</td><td style='font:bold 8pt tahoma;text-align:left'><b>Procesando....</b>&nbsp;&nbsp;&nbsp;</td></tr></table></td></tr>";
        lsHTML = lsHTML + "</table>";
        
        document.all("overDiv").innerHTML  = lsHTML;
        document.all("overDiv").style.left = parseInt(liCoord_X) + parseInt((iObj.offsetWidth-overDiv.offsetWidth)/2);
        document.all("overDiv").style.top  = parseInt(liCoord_Y) + parseInt((iObj.offsetHeight-overDiv.offsetHeight)/2);
        
    } else{
        overDiv.innerHTML  = "";
    }
	
}

function Procesando_cen(iTipo){
    
    var lsHTML = "";
    if(iTipo==1){
    	lsHTML = "";
    	lsHTML = lsHTML + "<table cellpadding=1 cellspacing=0 border='1' style='border-collapse:collapse' bgcolor='white'>";
    	lsHTML = lsHTML + "<tr height='60'><td align='center'><table cellpadding=0 cellspacing=0><tr><td>&nbsp;&nbsp;&nbsp;<img src='http://www.stein.cl/sli/slistandar/images/loading_1.gif'>&nbsp;&nbsp;</td><td style='font:bold 8pt tahoma;text-align:left'><b>Procesando....</b>&nbsp;&nbsp;&nbsp;</td></tr></table></td></tr>";
    	lsHTML = lsHTML + "</table>";
        overDiv.innerHTML  = lsHTML;
        overDiv.style.left = parseInt((window.innerWidth-overDiv.offsetWidth)/2);
        overDiv.style.top  = parseInt((window.innerHeight-overDiv.offsetHeight)/2);
    } else{
        overDiv.innerHTML = "";
    }
	
}
