<?php
    
    header("Expires: Mon, 26 Jul 1999 05:00:00 GMT"); 
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-cache, must-revalidate"); 
    header("Pragma: no-cache");
    header("Content-type: text/html; charset=ISO8859-1");
    
    include("seguridad.php");
    
    //mssql_query("insert into PERSONALIZADOS..[907610004_cmm_parametros] VALUES(2006,10)");
    echo $lsAno;
    
    $lsSQL = "
    SELECT	name
    FROM	PERSONALIZADOS..sysobjects
    WHERE	type = 'P'
    ORDER	BY
    		name";
    $result = mssql_query($lsSQL);
    
    echo "<table cellpadding=0 cellspacing=0>";
    while($row = mssql_fetch_array($result)){
        echo "<tr><td>&nbsp;".trim($row["name"])."&nbsp;</td></tr>";
    }
    echo "</table>";
    
    $lsSQL = "
    SELECT	OBJ.name tabla,
            COL.name columna,
            TYP.name tipo,
            COL.length largo
    FROM	PERSONALIZADOS..sysobjects OBJ INNER JOIN PERSONALIZADOS..syscolumns COL ON OBJ.ID = COL.ID 
                                           INNER JOIN PERSONALIZADOS..systypes   TYP ON COL.xtype = TYP.xtype
    WHERE	OBJ.type = 'U' AND
            OBJ.name = '907610004_cmm_correccionmonetaria'
    ORDER	BY
    		OBJ.name,
            COL.name";
    $result = mssql_query($lsSQL);
    
    echo "<table cellpadding=0 cellspacing=0>";
    while($row = mssql_fetch_array($result)){
        echo "
        <tr>
            <td>&nbsp;".trim($row["tabla"])."&nbsp;</td>
            <td>&nbsp;".trim($row["columna"])."&nbsp;</td>
            <td>&nbsp;".trim($row["tipo"])."&nbsp;</td>
            <td>&nbsp;".trim($row["largo"])."&nbsp;</td>
        </tr>";
    }
    echo "</table><br>";
    
    $lsSQL = "PERSONALIZADOS..SP_HELPTEXT [sp907610004_cmm_InicializaAno]";
    $result = mssql_query($lsSQL);
    
    echo "<table cellpadding=0 cellspacing=0>";
    while($row = mssql_fetch_array($result)){
        echo "
        <tr><td nowrap>&nbsp;".trim($row["column"])."&nbsp;</td></tr>";
    }
    echo "</table>";
    
?>
