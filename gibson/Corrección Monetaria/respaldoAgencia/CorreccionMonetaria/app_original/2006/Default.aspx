<%@ Page Language="C#" AutoEventWireup="true"  CodeFile="Default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
    <title>Untitled Page</title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
        <br />
        Ingrese Planta<asp:TextBox ID="txtPla" runat="server"></asp:TextBox><br />
        <br />
        Ingrese Fecha<asp:TextBox ID="txtFec" runat="server"></asp:TextBox><br />
        <br />
        <asp:Button ID="Ver" runat="server" Text="Ver en Pdf" OnClick="Ver_Click" Width="149px" style="left: 324px; position: absolute; top: 130px" BorderStyle="None" />
        &nbsp;&nbsp;
        <asp:SqlDataSource ID="SqlDataSource1" runat="server" ConnectionString="<%$ ConnectionStrings:Comex %>"
            SelectCommand="spLibroExistencias" SelectCommandType="StoredProcedure">
            <SelectParameters>
                <asp:Parameter DefaultValue="CL71" Name="Planta" Type="String" />
                <asp:Parameter DefaultValue="200612" Name="Mes" Type="String" />
            </SelectParameters>
        </asp:SqlDataSource>
    </div>
    </form>
</body>
</html>
