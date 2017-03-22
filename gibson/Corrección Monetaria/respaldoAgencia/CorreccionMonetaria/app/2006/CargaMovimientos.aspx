<%@ Page Language="VB" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<script runat="server">
	DIM coneccion AS sqlCONNECTION
    dim CLAVE,NOMBRE,EDAD As STRING
	dim sql as String
	Dim orden as sqlCOMMAND
	 
	dim cant as Integer  =0
	dim q as String
			dim jerarquia as String = ""
			dim  articulo as String = ""
			dim  planta 	as String = ""
			dim  bodega 	as String = ""
			dim  cantidad 	as String = ""
			dim  unibas		as String = ""
			dim  cvalor  	as String = ""
			dim  valor 		as String = ""
			dim  mon 		as String = ""
			dim  costo		as String = ""
			dim  tipo 		as String = ""
			dim  tipoDesc 	as String = ""
			dim  totalRegMov as String = ""
			dim  numDoc 	as String = ""
			dim  fechaDoc 	as String = ""
			dim  referencia as String = ""
			dim  Proveedor 	as String = ""
			dim  borrar as Boolean 
			dim  costo1,valor1,cantidad1 as Integer
			dim  espacio as String = ""
    Protected Sub Button1_Click(ByVal sender As Object, _
      ByVal e As System.EventArgs)
        If FileUpload1.HasFile Then
            Try
				dim nombre as String = "d:\"& FileUpload1.FileName
                FileUpload1.SaveAs(nombre)
                Label1.Text = "Se ha guardado el archivo " & FileUpload1.FileName
				   coneccions()
				   leerArchivo(nombre)
            Catch ex As Exception
                RESPONSE.Write("MALO")
				
            End Try
        Else
            Label1.Text = "no se ha especificado archivo."
        End If
    End Sub
	
	Public sub leerArchivo(ByVal archivo as String)
			Dim line as String
			Dim sr As New System.IO.StreamReader(archivo)
			dim sql as String
			Dim orden1 as sqlCOMMAND
			try


			do 
			line = sr.ReadLine()
			if not line is nothing then 
				if line.length > 90 then 
				line = Replace(line, "'", "´")
					 if String.Compare(line.substring(0,5), "Usua") <> 0 _
					 and String.Compare(line.substring(0,5), "Ambi") <> 0 _
					 and String.Compare(line.substring(0,5), "Repo") <> 0 _
					 and String.Compare(line.substring(0,5), "-----") <> 0 _
					 and String.Compare(line.substring(0,5), "Jera") <> 0 _
					 and String.Compare(line.substring(0,5), "Prod") <> 0 _
					 and String.Compare(line.substring(0,5), "Crit") <> 0 _
					 and String.Compare(line.substring(104,3), "CLP") <> 0 then
					
							if String.Compare(line.substring(77,3), "PCE") = 0 _
							or String.Compare(line.substring(119,3),"P/C") = 0 then
							 
								dim jerarquia2 as String = line.substring(0,19).trim()
								if not jerarquia2.equals("") then
										jerarquia = jerarquia2
								end if
								dim articulo2 as String = line.substring(20,15).trim()
								if not articulo2.equals("") then
										articulo = articulo2	
								end if
								planta=line.substring(45,6).trim()
								bodega=line.substring(53,7).trim()
								if line.substring(64,13).trim().equals("") then
								cantidad = "0"
								else
								cantidad =replace(replace(line.substring(64,13).trim(),".",""),"-","")
								
								end if	
								
								unibas=line.substring(77,3).trim()
								
								
								if line.substring(84,15).trim().equals("") then
								valor = "0"
								else
								valor =replace(replace(line.substring(84,15).trim(),".",""),"-","")
								
								end if
								
								mon = line.substring(100,4).trim()
								
								
								if line.substring(104,8).trim().equals("") then
								costo = "0"
								else
								costo =replace(replace(line.substring(104,8).trim(),".",""),"-","")
								
								end if
								
								tipo =line.substring(119,3).trim()
								tipoDesc =line.substring(124,23).trim()
								totalRegMov = line.substring(144,9).trim()
								numDoc =line.substring(154,10).trim()
								fechaDoc =line.substring(164,10).trim()
								
								if line.length()>195 then
									Proveedor = line.substring(195,(line.length()-195)).trim()
									referencia = line.substring(179,16).trim()
								else
								Proveedor = ""
									if line.length()>180 then
										referencia = line.substring(174,line.length()-179).trim()
									else
									    referencia = ""
									end if
								end if
								
								sql = "insert into LibroExistencia (jerarquia,articulo,planta,bodega,cantidad,unidad,valor,moneda,costo,mov_tipo,mov_desc,mov_reg,docto_num,docto_fec,referencia,proveedor) values (@jerarquia, @articulo, @planta, @bodega , @cantidad ,@unibas ,@valor ,@mon ,@costo,@tipo ,@tipoDesc ,@totalRegMov ,@numDoc ,convert(smalldatetime,@fechaDoc,104) ,@referencia , @Proveedor )" 
						
orden = New SqlCommand(sql, coneccion)
orden.Parameters.Add(New sqlParameter("@jerarquia", sqlDbType.VarChar, 25))
orden.Parameters("@jerarquia").Value = jerarquia
orden.Parameters.Add(New sqlParameter("@articulo", sqlDbType.VarChar, 25))
orden.Parameters("@articulo").Value = articulo
orden.Parameters.Add(New sqlParameter("@planta", sqlDbType.VarChar, 25))
orden.Parameters("@planta").Value = planta
orden.Parameters.Add(New sqlParameter("@bodega", sqlDbType.VarChar, 25))
orden.Parameters("@bodega").Value = bodega
orden.Parameters.Add(New sqlParameter("@cantidad", sqlDbType.Decimal))
orden.Parameters("@cantidad").Value = cantidad
orden.Parameters.Add(New sqlParameter("@unibas", sqlDbType.VarChar, 25))
orden.Parameters("@unibas").Value = unibas
orden.Parameters.Add(New sqlParameter("@valor", sqlDbType.Decimal))
orden.Parameters("@valor").Value = valor
orden.Parameters.Add(New sqlParameter("@mon", sqlDbType.VarChar, 10))
orden.Parameters("@mon").Value = mon
orden.Parameters.Add(New sqlParameter("@costo", sqlDbType.int))
orden.Parameters("@costo").Value = Integer.parse(costo)
orden.Parameters.Add(New sqlParameter("@tipo", sqlDbType.VarChar, 25))
orden.Parameters("@tipo").Value = tipo
orden.Parameters.Add(New sqlParameter("@tipoDesc", sqlDbType.VarChar, 30))
orden.Parameters("@tipoDesc").Value = tipoDesc
orden.Parameters.Add(New sqlParameter("@totalRegMov", sqlDbType.VarChar, 10))
orden.Parameters("@totalRegMov").Value = totalRegMov
orden.Parameters.Add(New sqlParameter("@numDoc", sqlDbType.VarChar, 15))
orden.Parameters("@numDoc").Value = numDoc
orden.Parameters.Add(New sqlParameter("@fechaDoc", sqlDbType.smalldatetime))
orden.Parameters("@fechaDoc").Value = fechaDoc
orden.Parameters.Add(New sqlParameter("@referencia", sqlDbType.VarChar, 20))
orden.Parameters("@referencia").Value = referencia
orden.Parameters.Add(New sqlParameter("@Proveedor", sqlDbType.VarChar, 40))
orden.Parameters("@Proveedor").Value = proveedor

coneccion.Open()
orden.ExecuteNonQuery()
coneccion.close()

cant = cant +1
							end if 
					end if
					 
				end if
			end if
			Loop Until line Is Nothing
			
			catch e as Exception
				response.Write(e.Message.ToString())
				
			end try	 
			sr.Close()
			
	End sub
	public sub coneccions()
	try
				coneccion = New SqlConnection(ConfigurationManager.ConnectionStrings("Comex").ToString())
	catch e as Exception 
	RESPONSE.Write("MALO")
	end try
	end sub
</script>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>Upload Files</title>
</head>
<body>
<form name="form1" id="form1" runat="server"><div>
  <asp:FileUpload ID="FileUpload1" runat="server" /><br />
        <br />
        <asp:Button ID="Button1" runat="server" OnClick="Button1_Click" 
         Text="Subir archivo" />&nbsp;<br />
        <br />
        <asp:Label ID="Label1" runat="server"></asp:Label></div>
</form>
<p>&nbsp;</p>
    <p>&nbsp; </p>
</body>
</html>
