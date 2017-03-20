<?php
    
    require('excel/reader.php');
    require('excel/spreadsheet.php');

    $array = [];
    $Reader = new SpreadsheetReader('example.xlsx');
    foreach ($Reader as $row)
    {
    	$fila = [
    		"Cliente" => $row[0],
    		"FecAcep" => $row[1],
    		"Item" => $row[2],
    		"Despacho" => $row[3],
    		"Referencia" => $row[4],
    		"Mercancia" => $row[5],
    		"PartArancel" => $row[6],
    		"ValorCIF" => $row[7],
    		"Arancel" => $row[8],
    		"CIP" => $row[9],
    		"ValorFlete" => $row[10],
    		"ValorSeguro" => $row[11],
    		"TotDerecho_US" => $row[12],
    		"IVA_US" => $row[13],
    		"FacturaCliente" => $row[14],
    		"CantidadDin" => $row[15]
    	];
    	array_push($array, $fila);
    }
    echo json_encode($array);
    /*
	$array = [];
	array_push($array, ["valor1" => 1, "valor2" => "Dos"]);
	echo json_encode($array);
	*/
?>