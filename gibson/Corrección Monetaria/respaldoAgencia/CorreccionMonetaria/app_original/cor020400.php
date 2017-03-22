<?php
    
    include("seguridad.php");
    
    $lsAnterior = "";
    $lsAcumulado = 0;
    
    $lsArticulo = $HTTP_GET_VARS["ART"];
    $lsPlanta   = $HTTP_GET_VARS["PLA"];
    //$lsAno      = $HTTP_GET_VARS["ANO"];
    
    //$lsSQL = "UPDATE [907610004_cmm_libroexistencias] SET cantidad = cantidad - 1305 WHERE ID = 249231";
    //mssql_query($lsSQL);
    
    if(trim($lsArticulo)==""){
        
        $lsSQL = "
        SELECT	FIN.planta							planta,
        		FIN.articulo						articulo,
        		CONVERT(CHAR(10),FIN.docto_fec,103)	fecha,
        		FIN.mes								mes,
        		FIN.saldo							saldo,
        		CASE WHEN ISNULL(FIN.costo,0)=0 THEN CONVERT(NUMERIC(15,4),FIN.valor/FIN.saldo) ELSE FIN.costo END costo,
        		FIN.valor							valor,
        		FIN.sli_total						sli_total,
        		FIN.ppp                             ppp,
        		FIN.ppp_acumulado                   ppp_acumulado,
        		CONVERT(NUMERIC(15,0),CMM.elegido*CMM.factor) revaluo,
        		((FIN.ppp * FIN.saldo) - FIN.ppp_acumulado) dif_ppp
        FROM	[907610004_cmm_saldosfinales] FIN LEFT OUTER JOIN [907610004_cmm_correccionmonetaria] CMM ON FIN.planta = CMM.planta AND FIN.articulo = CMM.articulo AND CMM.ano = '".trim($lsAno)."'
        WHERE   FIN.mes    = '".trim($lsAno)."12' AND
        		FIN.saldo <> 0 --AND
        		--((FIN.ppp * FIN.saldo) - FIN.ppp_acumulado) <> 0
        ORDER	BY
                ABS((FIN.ppp * FIN.saldo) - FIN.ppp_acumulado) desc,
        		FIN.planta,
        		FIN.articulo";
        $result = mssql_query($lsSQL);
        
        $liCount = 0;
        
        echo "<table border=1>";
            echo "<tr>
            <td bgcolor='silver' align='center'><b>#</b></td>
            <td align='center' bgcolor='silver'><b>PLANTA</b></td>
            <td align='center' bgcolor='silver'><b>ARTICULO</b></td>
            <td align='center' bgcolor='silver'><b>FECHA</b></td>
            <td align='center' bgcolor='silver'><b>MES</b></td>
            <td align='center' bgcolor='silver'><b>SALDO</b></td>
            <td align='center' bgcolor='silver'><b>SAP</b></td>
            <td align='center' bgcolor='silver'><b>SLI</b></td>
            <td align='center' bgcolor='silver'><b>PPP</b></td>
            <td align='center' bgcolor='silver'><b>REV</b></td>
            <td align='center' bgcolor='silver'><b>SAP</b></td>
            <td align='center' bgcolor='silver'><b>SLI</b></td>
            <td align='center' bgcolor='silver'><b>PPP</b></td>
            <td align='center' bgcolor='silver'><b>REV</b></td>
            <td align='center' bgcolor='yellow'><b>DIF.PPP</b></td>
            </tr>";
        while($row = mssql_fetch_array($result)){
            $liCount++;
            echo "<tr onclick='document.location.replace(".chr(34)."cor020400.php?ART=".trim($row["articulo"])."&PLA=".trim($row["planta"]).chr(34).")'>
            <td bgcolor='silver' align='right'><b>".trim($liCount)."</b></td>
            <td>".trim($row["planta"])."</td>
            <td>".trim($row["articulo"])."</td>
            <td>".trim($row["fecha"])."</td>
            <td>".trim($row["mes"])."</td>
            <td>".trim($row["saldo"])."</td>
            <td>".trim($row["costo"])."</td>
            <td>".trim($row["sli_total"])."</td>
            <td>".trim($row["ppp"])."</td>
            <td>".trim($row["revaluo"])."</td>
            <td>".trim($row["valor"])."</td>
            <td>".trim($row["sli_total"]*$row["saldo"])."</td>
            <td>".trim($row["ppp_acumulado"])."</td>
            <td>".trim($row["revaluo"]*$row["saldo"])."</td>
            <td>".trim($row["dif_ppp"])."</td>
            </tr>";
        }
        echo "</table>";
        
    } else{
    
        $lsSQL = "
        SELECT	id                              id,
                docto_num                       docto_num,
                planta							planta,
        		articulo						articulo,
        		CONVERT(CHAR(10),docto_fec,103)	fecha,
        		mes								mes,
        		cantidad						cantidad,
        		saldo							saldo,
        		mov_tipo                        mov_tipo,
        		costo                           sap,
        	    sli_total                       sli,
        		ppp                             ppp,
        		ppp_acumulado                   ppp_acumulado
        FROM    [907610004_cmm_libroexistencias]
        WHERE   articulo = '".$lsArticulo."' AND
        		planta   = '".$lsPlanta."' AND
        		LEFT(mes,4) = '".trim($lsAno)."'
        ORDER	BY
                mes,
        		docto_fec,
        		mov_tipo,
                id";
        $result = mssql_query($lsSQL);
        
        $liCount = 0;
        
        echo "<table border=1>";
        echo "<tr>
        <td bgcolor='silver' align='center'><b>#</b></td>
        <td align='center' bgcolor='silver'><b>PLANTA</b></td>
        <td align='center' bgcolor='silver'><b>ARTICULO</b></td>
        <td align='center' bgcolor='silver'><b>FECHA</b></td>
        <td align='center' bgcolor='silver'><b>MES</b></td>
        <td align='center' bgcolor='silver'><b>CANTIDAD</b></td>
        <td align='center' bgcolor='silver'><b>SALDO</b></td>
        <td align='center' bgcolor='silver'><b>MOV</b></td>
        <td align='center' bgcolor='silver'><b>SAP</b></td>
        <td align='center' bgcolor='silver'><b>SLI</b></td>
        <td align='center' bgcolor='silver'><b>PPP</b></td>
        <td align='center' bgcolor='silver'><b>ACUM</b></td>
        <td align='center' bgcolor='yellow'><b>SALDO_CMA</b></td>
        <td align='center' bgcolor='yellow'><b>PPP_CMA</b></td>
        <td align='center' bgcolor='yellow'><b>ACUM_CMA</b></td>
        </tr>";
        
        $liAcum = 0;
        $liAcum_ppp = 0;
        while($row = mssql_fetch_array($result)){
            
            if(trim($liCount)=="0"){
                
                $lsSQL_2 = "
                SELECT	id                              id,
                        docto_num                       docto_num,
                        planta							planta,
                		articulo						articulo,
                		CONVERT(CHAR(10),docto_fec,103)	fecha,
                		mes								mes,
                		cantidad						cantidad,
                		saldo							saldo,
                		mov_tipo                        mov_tipo,
                		costo                           sap,
                	    sli_total                       sli,
                		ppp                             ppp
                FROM    [907610004_cmm_saldosiniciales]
                WHERE   articulo = '".$lsArticulo."' AND
                		planta   = '".$lsPlanta."' AND
                		mes = '".trim($row["mes"])."'
                ORDER	BY
                        mes,
                		docto_fec,
                		mov_tipo,
                        id";
                $result_2 = mssql_query($lsSQL_2);
                if($row_2 = mssql_fetch_array($result_2)){
                
                    $liCount++;
                    $liAcum = $liAcum + $row_2["saldo"];
                    
                    if(trim($row_2["mov_tipo"])=="101"){
                        $liAnt_ppp = trim($row_2["sli"]);
                    }
                    $liAcum_ppp = $liAcum_ppp + ($liAnt_ppp * $row_2["cantidad"]);
                    if(trim($liAcum)!="0"){
                        $liAnt_ppp  = $liAcum_ppp/$liAcum;
                    }
                
                    echo "<tr bgcolor='yellow'>
                    <td bgcolor='silver' align='right' title='".trim($row_2["id"])."@".trim($row_2["docto_num"])."'><b>".trim($liCount)."</b></td>
                    <td>".trim($row_2["planta"])."</td>
                    <td>".trim($row_2["articulo"])."</td>
                    <td>".trim($row_2["fecha"])."</td>
                    <td>".trim($row_2["mes"])."</td>
                    <td>".trim($row_2["cantidad"])."</td>
                    <td>".trim($row_2["saldo"])."</td>
                    <td>".trim($row_2["mov_tipo"])."</td>
                    <td>".trim($row_2["sap"])."</td>
                    <td>".trim($row_2["sli"])."</td>
                    <td>".trim($row_2["ppp"])."</td>
                    <td>&nbsp;</td>
                    <td>".trim($liAcum)."</td>
                    <td>".trim($liAnt_ppp)."</td>
                    <td>".trim($liAcum_ppp)."</td>
                    </tr>";
                    
                }
            }
            
            $liCount++;
            $liAcum = $liAcum + $row["cantidad"];
            
            if(trim($row["mov_tipo"])=="101"){
                $liAnt_ppp = trim($row["sli"]);
            }
            $liAcum_ppp = $liAcum_ppp + ($liAnt_ppp * $row["cantidad"]);
            if(trim($liAcum)!="0"){
                $liAnt_ppp  = $liAcum_ppp/$liAcum;
            }
                        
            echo "<tr>
            <td bgcolor='silver' align='right' title='".trim($row["id"])."@".trim($row["docto_num"])."'><b>".trim($liCount)."</b></td>
            <td>".trim($row["planta"])."</td>
            <td>".trim($row["articulo"])."</td>
            <td>".trim($row["fecha"])."</td>
            <td>".trim($row["mes"])."</td>
            <td>".trim($row["cantidad"])."</td>
            <td>".trim($row["saldo"])."</td>
            <td>".trim($row["mov_tipo"])."</td>
            <td>".trim($row["sap"])."</td>
            <td>".trim($row["sli"])."</td>
            <td>".trim($row["ppp"])."</td>
            <td>".trim($row["ppp_acumulado"])."</td>
            <td>".trim($liAcum)."</td>
            <td>".trim($liAnt_ppp)."</td>
            <td>".trim($liAcum_ppp)."</td>
            </tr>";
            
            //$lsSQL  = "UPDATE [907610004_cmm_libroexistencias] SET saldo = ".trim($liAcum).", PPP = ".trim($liAnt_ppp).", ppp_acumulado = ".trim($liAcum_ppp)." WHERE ID = ".trim($row["id"]);
            //mssql_query($lsSQL);
            
        }
        echo "</table>";
    
    }
    
?>
