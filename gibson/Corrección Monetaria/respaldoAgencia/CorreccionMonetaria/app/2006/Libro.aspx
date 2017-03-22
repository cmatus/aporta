
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<%@ Import Namespace="System.Data.SqlClient" %>

<script runat="server">
	Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load 
	dim sql as String
	dim dt as Datatable
	dim d,x,i,n as integer
	Dim oDa As New OleDbDataAdapter()
	dim destino as String = ConfigurationManager.ConnectionStrings("Comex").ConnectionString
	sql = "SELECT ARTICULO,DESCRIPCION,CANTIDAD FROM libroexistencia where referencia = '"&request("numfactura")& "' " 
	oDa = New OleDbDataAdapter(sql, Destino)
	dt = New DataTable
	oDa.Fill(dt)
	n = dt.Rows.Count
	d = 0
	x = 1
	If n = 0 Then
	Else
	
	response.write("<table border=1 bgcolor='#FFFF00'>")
	response.write("<tr>")
	response.write("<td width='30px' style='font:bold'>&nbsp;Item&nbsp;</td><td width='80px' style='font:bold'>&nbsp;Código&nbsp;</td><td width='225px' style='font:bold'>&nbsp;Descripción&nbsp;</td><td width='45px' style='font:bold'>&nbsp;Cantidad&nbsp;</td>")
	response.write("</tr>")
	For i = 0 To n - 1
	response.write("<tr>")
	response.write("<td>&nbsp;" & x.tostring & "&nbsp;</td> ")
		for d = 0 to 2
			response.write("<td>&nbsp;" & dt.Rows(i)(d).ToString & "&nbsp;</td> ")
	 	next
	 response.write("</tr>")
	 x = x+1
    Next
	response.write("</table>")
End If
End Sub
</script>
