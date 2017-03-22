<?php
    
    if(isset($_SERVER["PATH_INFO"])) {
        $lsSRV_Pag = $_SERVER["PATH_INFO"];
        $laSRV_Pag = split("/",$lsSRV_Pag);
        $lsSRV_Pag = $laSRV_Pag[count($laSRV_Pag)-1];
    }
    
    /* Sección original (1)

    $dbh = mssql_connect("jupiter","sis_sli","sliusr") or die ('I cannot connect to the database because: ' . mssql_error());
    //$dbh = mssql_connect("CMATUS","sa","m41gn4c14") or die ('I cannot connect to the database because: ' . mssql_error());
    mssql_select_db("personalizados");
    
    $lsSQL = "
    SELECT  ano
    FROM    [907610004_cmm_parametros]
    WHERE   estado = 1";
    $result = mssql_query($lsSQL);
    
    if($row = mssql_fetch_array($result)){
        $lsAno = $row["ano"];
    }    

    Seccion original (1) */

    /* Sección reemplazo (1) */
    
    $serverName = "SSS-CMATUS\SQLEXPRESS";
    $connectionInfo = array("Database" => "personalizados", "UID" => "sa", "PWD" => "W3nj1t0_");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if(!$conn) {
        echo "Conexión no se pudo establecer.<br />";
        die(print_r(sqlsrv_errors(), true));
    } else {
        $lsSQL = "
        SELECT  ano
        FROM    [907610004_cmm_parametros]
        WHERE   estado = 1";
        $stmt = sqlsrv_query($conn, $lsSQL);
        if(!$stmt) {
            die( print_r( sqlsrv_errors(), true) );
        } else {
            if($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                $lsAno = $row["ano"];
            }
        }

    }
    
    /* Sección reemplazo (1) */

    error_reporting(0);
    
    // funcion de manejos de errores definida por el usuario
    function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {
        // timestamp for the error entry
        $dt = date("Y-m-d H:i:s (T)");
    
        // Define una array con los valores de errores
        // en realidad solamente deberiamos de tener
        // en cuenta los valores 2,8,256,512 y 1024
    
        $errortype = array (
                    1   =>  "Error",
                    2   =>  "Warning",
                    4   =>  "Parsing Error",
                    8   =>  "Notice",
                    16  =>  "Core Error",
                    32  =>  "Core Warning",
                    64  =>  "Compile Error",
                    128 =>  "Compile Warning",
                    256 =>  "User Error",
                    512 =>  "User Warning",
                    1024=>  "User Notice"
                    );
    
        // errores a tener en cuenta
        $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
        
        $err = "<errorentry>\n";
        $err .= "\t<datetime>".$dt."</datetime>\n";
        $err .= "\t<errornum>".$errno."</errornum>\n";
        $err .= "\t<errortype>".$errortype[$errno]."</errortype>\n";
        $err .= "\t<errormsg>".$errmsg."</errormsg>\n";
        $err .= "\t<scriptname>".$filename."</scriptname>\n";
        $err .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\n";
        
        if (in_array($errno, $user_errors))
            $err .= "\t<vartrace>".wddx_serialize_value($vars,"Variables")."</vartrace>\n";
        $err .= "</errorentry>\n\n";
        
        // Para comprobar
        if($errno==1||$errno==4||$errno==16||$errno==64||$errno==256||$errno==2||$errno==32||$errno==128||$errno==512){
            echo $errno."@@".$errortype[$errno]."@@".$errmsg."@@".$filename."@@".$linenum;
        }
    
        // grabar en el fichero de errores y mandar un e-mail si ocurre un error critico de usuario
        //error_log($err, 3, "error.log");
        //if ($errno == E_USER_ERROR)
        //    mail("phpdev@example.com","Critical User Error",$err);
        
    }
    
    
    function distance ($vect1, $vect2) {
        if (!is_array($vect1) || !is_array($vect2)) {
            trigger_error("Incorrect parameters, arrays expected", E_USER_ERROR);
            return NULL;
        }
    
        if (count($vect1) != count($vect2)) {
            trigger_error("Vectors need to be of the same size", E_USER_ERROR);
            return NULL;
        }
    
        for ($i=0; $i<count($vect1); $i++) {
            $c1 = $vect1[$i]; $c2 = $vect2[$i];
            $d = 0.0;
            if (!is_numeric($c1)) {
                trigger_error("Coordinate $i in vector 1 is not a number, using zero", 
                                E_USER_WARNING);
                $c1 = 0.0;
            }
            if (!is_numeric($c2)) {
                trigger_error("Coordinate $i in vector 2 is not a number, using zero", 
                                E_USER_WARNING);
                $c2 = 0.0;
            }
            $d += $c2*$c2 - $c1*$c1;
        }
        return sqrt($d);
    }
    
    $old_error_handler = set_error_handler("userErrorHandler");
    
?>
