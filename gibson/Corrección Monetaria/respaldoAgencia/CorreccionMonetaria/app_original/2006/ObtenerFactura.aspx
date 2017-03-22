<%@ Page Language="VB" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<%@ Import Namespace="System.Data.SqlClient" %>
<script runat="server">
Dim sql,sql2,sql3	As String
DIM coneccion 		AS sqlCONNECTION
Dim orden,orden1	As sqlCOMMAND
dim sApartado (34)	As String
Dim i, n, n3, t, z 	As Integer
Dim oCmd 			As String
Dim oDa,oDa3		As OleDbDataAdapter
Dim dt, dt3		 	As DataTable

    Private Sub cmdEnviar_Click(ByVal sender As Object, ByVal e As System.EventArgs) _
    Handles cmdEnviar.Click
        Try
            Dim Destino As String = Server.MapPath(System.DBNull.Value.ToString()) & "\" & _
    Path.GetFileName(File1.PostedFile.FileName)
            coneccions()
            Dim duplicao As String = ""
            If File1.HasFile Then
                File1.PostedFile.SaveAs(Destino)
                Mensaje.Text = "Su archivo ha sido cargado en : <b>" & Destino & _
                "</b><br>Tamaño: " & File1.PostedFile.ContentLength() & " bytes."
                Destino = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=" & Destino & _
                ";Extended Properties=Excel 8.0;"
                ' Consulta los registros de excel
                sql = "SELECT * FROM miTabla"
                oDa = New OleDbDataAdapter(sql, Destino)
                dt = New DataTable
                oDa.Fill(dt)
                n = dt.Rows.Count
            End If
            
            If n = 0 Then
                ' No se ha encontrado ningún registro que coincida con la selección
            Else
                
                For i = 0 To n - 1 ' leer la cantidad de filas que en la planilla
                    ' Comprobara si la factura existe
                    If duplicao = dt.Rows(i)(0).ToString Then
                        ' SE ENCUENTRA EL REGISTRO
                    Else
                        ProcAlm(1)
                        Response.Write("hola <br>")
                        
                    End If
                    ProcAlm(2)
                    
                    duplicao = dt.Rows(i)(0).ToString
                    
                Next
            End If
        Catch ex As Exception
            Response.Write("malo " & ex.ToString)
        End Try
    End Sub
    Public Sub coneccions()
        
        Dim strConnString As String = ConfigurationManager.ConnectionStrings("Comex").ToString()
        Try
            coneccion = New SqlConnection(strConnString)
            


        Catch e As Exception
            Response.Write(e.ToString)
        End Try
    End Sub
    Public Sub ProcAlm(ByVal tipo As Integer)
        orden = New SqlCommand("spFacturaProveedor " & tipo & ", '907610004','" & dt.Rows(i)(0).ToString & "','" & dt.Rows(i)(0).ToString & "','" & dt.Rows(i)(1).ToString & "','" & dt.Rows(i)(2).ToString & "','" & dt.Rows(i)(3).ToString & "','" & dt.Rows(i)(4).ToString.Substring(0, 10) & "','" & dt.Rows(i)(5).ToString & "','" & dt.Rows(i)(6).ToString & "','" & dt.Rows(i)(7).ToString & "','" & dt.Rows(i)(8).ToString & "','" & dt.Rows(i)(9).ToString & "','" & dt.Rows(i)(10).ToString & "' ", coneccion)
        coneccion.Open()
        orden.ExecuteNonQuery()
        coneccion.Close()
    End Sub

	</script>
	<html xmlns="http://www.w3.org/1999/xhtml" >
	<head id="Head1" runat="server">
    <title>Upload Files</title>
	</head>
<body>
<form id="Form1" method="post" encType="multipart/form-data" runat="server">
   Seleccione el Archivo a Enviar:   <asp:FileUpload ID="File1" runat="server" /><br />
     <asp:button id="cmdEnviar" runat="server" Text="Enviar"></asp:button>
     <BR>
     <asp:label id="Mensaje" runat="server"></asp:label>
</form>
</body>
</html>