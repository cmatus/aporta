<?php
	
	$msconnect = mssql_connect("jupiter","sis_comex","comusr");
	$msdb      = mssql_select_db("clientes",$msconnect);
	
	$path  = "d:\\Sites\\FTP\\Philips\\Backup\\in";
	$dir   = opendir($path);
	$lsFil = array();
	
    $liCount = 1;
	while ($elemento = readdir($dir)){
        
		if(strtoupper(substr($elemento,strlen($elemento)-3,strlen($elemento)))=="DAT"&&strtoupper(substr($elemento,0,2))=="XI"){
            $lsFile = fopen($path."\\".$elemento, "r");
			while(!feof($lsFile)){
				
				$lsContenido = fgets($lsFile);				
				if(substr($lsContenido,0,2)=="02"){
					
					$ls_03 = trim(substr($lsContenido,8,10));	// Internal number invoice
					$ls_04 = trim(substr($lsContenido,18,17));	// Number vendor invoice

					//$ls_08 = trim(substr($lsContenido,61,8));
					//$ls_13 = trim(substr($lsContenido,127,3));
					
					$ls_08_1 = trim(substr($lsContenido,45,8));	  // Accounting invoice date
					$ls_13_1 = trim(substr($lsContenido,111,3));  // Currency code
					$ls_14_1 = trim(substr($lsContenido,35,10));  // P/O
					
					$ls_08_2 = trim(substr($lsContenido,53,8));	  // Accounting invoice date
					$ls_13_2 = trim(substr($lsContenido,119,3));  // Currency code
					$ls_14_2 = trim(substr($lsContenido,43,10));  // P/O
					
					$ls_08_3 = trim(substr($lsContenido,54,8));	  // Accounting invoice date
					$ls_13_3 = trim(substr($lsContenido,120,3));  // Currency code
					$ls_14_3 = trim(substr($lsContenido,44,10));  // P/O
					
					$ls_08_4 = trim(substr($lsContenido,55,8));	  // Accounting invoice date
					$ls_13_4 = trim(substr($lsContenido,121,3));  // Currency code
					$ls_14_4 = trim(substr($lsContenido,45,10));  // P/O
					
					$ls_08_5 = trim(substr($lsContenido,61,8));	  // Accounting invoice date
					$ls_13_5 = trim(substr($lsContenido,127,3));  // Currency code
					$ls_14_5 = trim(substr($lsContenido,51,10));  // P/O
					
					$ls_08_6 = trim(substr($lsContenido,62,8));	  // Accounting invoice date
					$ls_13_6 = trim(substr($lsContenido,128,3));  // Currency code
					$ls_14_6 = trim(substr($lsContenido,52,10));  // P/O
					
					$ls_08_7 = trim(substr($lsContenido,63,8));	  // Accounting invoice date
					$ls_13_7 = trim(substr($lsContenido,129,3));  // Currency code
					$ls_14_7 = trim(substr($lsContenido,53,10));  // P/O
					
					$ls_08_8 = trim(substr($lsContenido,64,8));	  // Accounting invoice date
					$ls_13_8 = trim(substr($lsContenido,130,3));  // Currency code
					$ls_14_8 = trim(substr($lsContenido,54,10));  // P/O
					
					if((substr($ls_08_1,0,4)=="2006"||substr($ls_08_1,0,4)=="2007"||substr($ls_08_1,0,4)=="2008")&&strlen(trim($ls_08_1))==8){
                        $ls_08 = $ls_08_1;
                        $ls_13 = $ls_13_1;
                        $ls_14 = $ls_14_1;
                    }
					else if((substr($ls_08_2,0,4)=="2006"||substr($ls_08_2,0,4)=="2007"||substr($ls_08_2,0,4)=="2008")&&strlen(trim($ls_08_2))==8){
                        $ls_08 = $ls_08_2;
                        $ls_13 = $ls_13_2;
                        $ls_14 = $ls_14_2;
                    }
					else if((substr($ls_08_3,0,4)=="2006"||substr($ls_08_3,0,4)=="2007"||substr($ls_08_3,0,4)=="2008")&&strlen(trim($ls_08_3))==8){
                        $ls_08 = $ls_08_3;
                        $ls_13 = $ls_13_3;
                        $ls_14 = $ls_14_3;
                    }
					else if((substr($ls_08_4,0,4)=="2006"||substr($ls_08_4,0,4)=="2007"||substr($ls_08_4,0,4)=="2008")&&strlen(trim($ls_08_4))==8){
                        $ls_08 = $ls_08_4;
                        $ls_13 = $ls_13_4;
                        $ls_14 = $ls_14_4;
                    }
					else if((substr($ls_08_5,0,4)=="2006"||substr($ls_08_5,0,4)=="2007"||substr($ls_08_5,0,4)=="2008")&&strlen(trim($ls_08_5))==8){
                        $ls_08 = $ls_08_5;
                        $ls_13 = $ls_13_5;
                        $ls_14 = $ls_14_5;
                    }
					else if((substr($ls_08_6,0,4)=="2006"||substr($ls_08_6,0,4)=="2007"||substr($ls_08_6,0,4)=="2008")&&strlen(trim($ls_08_6))==8){
                        $ls_08 = $ls_08_6;
                        $ls_13 = $ls_13_6;
                        $ls_14 = $ls_14_6;
                    }
					else if((substr($ls_08_7,0,4)=="2006"||substr($ls_08_7,0,4)=="2007"||substr($ls_08_7,0,4)=="2008")&&strlen(trim($ls_08_7))==8){
                        $ls_08 = $ls_08_7;
                        $ls_13 = $ls_13_7;
                        $ls_14 = $ls_14_7;
                    }
					else if((substr($ls_08_8,0,4)=="2006"||substr($ls_08_8,0,4)=="2007"||substr($ls_08_8,0,4)=="2008")&&strlen(trim($ls_08_8))==8){
                        $ls_08 = $ls_08_8;
                        $ls_13 = $ls_13_8;
                        $ls_14 = $ls_14_8;
                    }
					
					echo $elemento.",".$liCount.",".$ls_03.",".$ls_04.",".$ls_08.",".$ls_14."<br>";
					$liCount++;
					
					if(trim($lsMoneda)==""){
					   $lsMoneda = "0";
                    }
                    /*
                    if(substr($ls_08_1,0,4)=="2006"||substr($ls_08_1,0,4)=="2007"||substr($ls_08_1,0,4)=="2008"){
    					$lsSQL = "SELECT ID_Adu_Moneda FROM SLI..Monedas WHERE ID_Moneda = '".$ls_13_1."'";
    					$msresults = mssql_query($lsSQL);
    					if($row = mssql_fetch_array($msresults)){
    						$lsMoneda = trim($row["ID_Adu_Moneda"]);
    					}
    					if($lsMoneda<>"0"&&strlen($ls_08_1)==8){
        					$lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".$ls_08_1."',id_moneda = ".$lsMoneda." where num_facturainterno = '".$ls_03."'";
        					echo $lsSQL."<br>";
        				}
                    }
                    if(substr($ls_08_2,0,4)=="2006"||substr($ls_08_2,0,4)=="2007"||substr($ls_08_2,0,4)=="2008"){
    					$lsSQL = "SELECT ID_Adu_Moneda FROM SLI..Monedas WHERE ID_Moneda = '".$ls_13_2."'";
    					$msresults = mssql_query($lsSQL);
    					if($row = mssql_fetch_array($msresults)){
    						$lsMoneda = trim($row["ID_Adu_Moneda"]);
    					}
                        if($lsMoneda<>"0"&&strlen($ls_08_2)==8){
        					$lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".$ls_08_2."',id_moneda = ".$lsMoneda." where num_facturainterno = '".$ls_03."'";
        					echo $lsSQL."<br>";
        				}
                    }
                    if(substr($ls_08_3,0,4)=="2006"||substr($ls_08_3,0,4)=="2007"||substr($ls_08_3,0,4)=="2008"){
    					$lsSQL = "SELECT ID_Adu_Moneda FROM SLI..Monedas WHERE ID_Moneda = '".$ls_13_3."'";
    					$msresults = mssql_query($lsSQL);
    					if($row = mssql_fetch_array($msresults)){
    						$lsMoneda = trim($row["ID_Adu_Moneda"]);
    					}
    					if($lsMoneda<>"0"&&strlen($ls_08_3)==8){
        					$lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".$ls_08_3."',id_moneda = ".$lsMoneda." where num_facturainterno = '".$ls_03."'";
        					echo $lsSQL."<br>";
        				}
                    }
                    if(substr($ls_08_4,0,4)=="2006"||substr($ls_08_4,0,4)=="2007"||substr($ls_08_4,0,4)=="2008"){
    					$lsSQL = "SELECT ID_Adu_Moneda FROM SLI..Monedas WHERE ID_Moneda = '".$ls_13_4."'";
    					$msresults = mssql_query($lsSQL);
    					if($row = mssql_fetch_array($msresults)){
    						$lsMoneda = trim($row["ID_Adu_Moneda"]);
    					}
    					if($lsMoneda<>"0"&&strlen($ls_08_4)==8){
        					$lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".$ls_08_4."',id_moneda = ".$lsMoneda." where num_facturainterno = '".$ls_03."'";
        					echo $lsSQL."<br>";
                        }
                    }
                    if(substr($ls_08_5,0,4)=="2006"||substr($ls_08_5,0,4)=="2007"||substr($ls_08_5,0,4)=="2008"){
    					$lsSQL = "SELECT ID_Adu_Moneda FROM SLI..Monedas WHERE ID_Moneda = '".$ls_13_5."'";
    					$msresults = mssql_query($lsSQL);
    					if($row = mssql_fetch_array($msresults)){
    						$lsMoneda = trim($row["ID_Adu_Moneda"]);
    					}
    					if($lsMoneda<>"0"&&strlen($ls_08_5)==8){
        					$lsSQL = "UPDATE CLIENTES..factura_enc SET fecha = '".$ls_08_5."',id_moneda = ".$lsMoneda." where num_facturainterno = '".$ls_03."'";
        					echo $lsSQL."<br>";
                        }
                    }
                    */
    				
				}
				
			}
			fclose($lsFile);
			
		}
		
	} 
	
?>
